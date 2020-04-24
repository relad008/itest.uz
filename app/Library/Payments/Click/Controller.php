<?php
namespace App\Library\Payments\Click;

use Schema,
	DB,
	App\Library\Payments\ErrorException,
	App\Library\Payments\BaseTransactionModel as Transaction,
	Illuminate\Http\Request,
	Config;

class Controller extends \App\Library\Payments\BaseController
{


	protected static $system_name='click';
	protected static $payments_messages =
	[
		0	=> ["error"=>"0",   "error_note"=>"success"],
		1	=> ["error"=>"-1",  "error_note"=>"SIGN CHECK FAILED!"],
		2	=> ["error"=>"-2",  "error_note"=>"Incorrect parameter amount"],
		3	=> ["error"=>"-3",  "error_note"=>"Action not found"],
		4	=> ["error"=>"-4",  "error_note"=>"Already paid"],
		5	=> ["error"=>"-5",  "error_note"=>"User does not exist"],
		6	=> ["error"=>"-6",  "error_note"=>"Transaction does not exist"],
		7	=> ["error"=>"-7",  "error_note"=>"Failed to update user"],
		8	=> ["error"=>"-8",  "error_note"=>"Error in request from click"],
		9	=> ["error"=>"-9",  "error_note"=>"Transaction cancelled"],
	];
	protected $parameters=[];
	protected static $invoice_messages=
	[
		0=>	'Success',	//Успешно
		-1=>	'Invalid method name',	//Неверное название метода
		-2=>	'Undefined or empty argument(s)',	//Не все требуемые параметры переданы
		-3=>	'Ошибка базы данных',
		-4=>	'No parameters specified',	//Передан пустой запрос
		-5=>	'Method not specified',	//Не указано название метода
		-9=>	'Initialization error',	//Ошибка запуска API
		-11=>	'Неверно указан ID поставщика	',
		-12=>	'Не найден секретный ключ	',
		-13=>	'Минимальная сумма оплаты N	',
		-14=>	'Вы превысили максимальный лимит оплаты в день N	',
		-15=>	'Неверная строка подписи данных	',

	];

	protected static $def_config=
	[
		'min_amount'=>0,

		'secret_key'=>null,

		// Invoice info
		'merchant_id'=>null,
		'merchant_service_id'=>null,
		'merchant_user_id'=>null,

		'transaction_note'=>'',
	];
	protected static $request_params=
	[
		'actionPrepare'=>
		[
			'click_trans_id', // id в в системе клик
			'click_paydoc_id',//Номер платежа в системе CLICK. Отображается в СМС у клиента при оплате.
			'service_id',// ID сервиса в системе клик
			'merchant_trans_id',// ID пользователя\товара\заказа\логин в нашей системе
			'amount',// Сумма платежа в сумах
			'action',//Тип действия для prepare=1
			'error', // Ошибка
			'error_note', // Описание ошибки
			'sign_time',// Время создания запроса
			'sign_string'//Хеш строка
		],
		'actionComplete'=>
		[
			'merchant_prepare_id',//ID платежа в нашей системе для подтверждения, полученный при запросе «Prepare»
			'click_trans_id',
			'click_paydoc_id',
			'service_id',
			'merchant_trans_id',
			'amount',
			'action',
			'error',
			'error_note',
			'sign_time',
			'sign_string'
		],
	];
	public static $response_params=
	[
		'invoice'=>[
			'success', //	int	Признак успешно принятого запроса (всегда 1)
			'error', //	int	Код ошибки
			'error_note', //	varchar	Детали ошибки
			'invoice_id', //	int	Идентификатор выставленного счета

		],
		'invoice_check'=>
		[
			'success',	//int	Признак успешно принятого запроса (всегда 1)
			'error',	//int	Код ошибки
			'error_note',	//varchar	Детали ошибки
			'status',	//int	Код статуса
			'status_note',	//varchar	Описание статуса счета

		]
	];
	public function error($num)
		{
			throw new ErrorException('', $num);

		}
	// ----------- CASTOMISATION
	public function getAccountId()
	{
		return $this->parameters['merchant_trans_id'];
	}

	// ------------------------ END CASTOMISATION


	public function wrongParametrs()
	{
		$this->error(8);
	}
	public function userDoesNotExists()
	{
		$this->error(5);
	}
	public function orderDoesNotExists()
	{
		$this->userDoesNotExists();
	}
	public function productDoesNotExists()
	{
		$this->userDoesNotExists();
	}
	public function serviceDoesNotExists()
	{
		$this->userDoesNotExists();
	}
	public function numberDoesNotExists()
	{
		$this->error(5);
	}
	public function orderAlreadyPayed()
	{
		$this->error(4);
	}
	public function cardAlreadyRegistred()
	{
		$this->error(4);
	}
	public function serviceUnvailable()
	{
		$this->error(7);
	}
	public function amountIsInvalid()
	{
		$this->error(2);
	}

	public function callbackRoute(Request $request)
	{
		$response=null;
		try
		{
			if(!$request->has('action'))
				$this->error(8);

			elseif(!in_array($request->has('action'), [0,1]))
				$this->error(3);
			else
			{

				$method=$request->input('action') == 0?'actionPrepare':'actionComplete';
				$request_arr=$request->toArray();
				$this->parameters=$request_arr;
				// Проверка параметров запроса
				if(array_diff(self::$request_params[$method], array_keys($request_arr)))
					$this->error(8);

				// Проверка хеш суммы
				elseif($this->createInputHash() != $request_arr['sign_string'])
					$this->error(1);


				// Проверка платежа
				$this->checkPayment();
				$this->checkAmount();

		  		$return_array=$this->$method();
		  		$response = array_merge(self::$payments_messages[0], $return_array);
			}
		}
		catch(ErrorException $e)
		{
			\Log::info($e->getTraceAsString());
			$response=self::$payments_messages[$e->getCode()];
		}
		self::storeLog($request->all(),$response);
		return response()->json($response);

	}
	private function actionPrepare()
	{
		$request=$this->parameters;

		$transactionQuery=Transaction::where('system_transaction_id',$request['click_trans_id'])
			->where('system',self::$system_name);

		if($request['error'] != 0)
		{
			$transactionQuery
				->update([
					'state' => 'canceled',
					'updated_at' => date('Y-m-d H:i:s')
				]);
			$this->error(9);
		}

		$transaction=$transactionQuery
			->first();


		if(!$transaction)
		{
			$transaction=Transaction::create(
				[
					'system_transaction_id' => $request['click_trans_id'],
					'account_id' => $request['merchant_trans_id'],
					'amount' => round($request['amount']),
					'amount_tiin' => round($request['amount']*100),
					'system'=>self::$system_name,
					'updated_at' => date('Y-m-d H:i:s'),
					'created_at' => date('Y-m-d H:i:s'),
				]);
				$this->onTransactionCreated($transaction);
		}
		elseif($transaction->state=='commited')
			$this->error(4);
		elseif($transaction->state=='canceled')
			$this->error(9);

		if(!$transaction)
			$this->error(7);

		$return_array =
		[
			'click_trans_id'=> $request['click_trans_id'],
			'merchant_trans_id' => $request['merchant_trans_id'],
			'merchant_prepare_id' => $transaction->id
		];

		return $return_array;

	}

	protected function actionComplete()
	{
		$request=$this->parameters;
		// \Log::info('actionComplete request dump ', $request);

		$transaction = Transaction::where('system_transaction_id', $request['click_trans_id'])
			->where('system',self::$system_name)
			->where('id', $request['merchant_prepare_id'])
			->first();
		// \Log::info('actionComplete transaction_dump ', (array)$transaction);

		if(!$transaction)
			$this->error(6);

		$transaction->amount=floatval($transaction->amount);
		$request['amount']=floatval($request['amount']);
		if($transaction->amount_tiin !=round($request['amount']*100))
			$this->amountIsInvalid();

		if($transaction->state == 'commited')
			$this->error(4);

		elseif($transaction->state == 'canceled')
			$this->error(9);
		// \Log::info('actionComplete before cancel ');
		// Если ошибка не ноль то отмена транзакции
		if($request['error'] != 0)
		{
			$transaction
				->update([
					'state' => 'canceled',
					'updated_at' => date('Y-m-d H:i:s')
				]);

			$this->onTransactionCanceled($transaction);
			$this->error(9);
		}

		$transaction
			->update(
			[
				'state' => 'commited',
				'updated_at' => date('Y-m-d H:i:s')
			]);

		$this->onTransactionCommited($transaction);


		$return_array =
		[
			'click_trans_id'=> $request['click_trans_id'],		// ID Click Trans
			'merchant_trans_id' => $request['merchant_trans_id'], // ID платежа в биллинге Поставщика
			'merchant_confirm_id' => $transaction->id // ID
		];
		return $return_array;

	}

	private function createInputHash()
	{
		$request=$this->parameters;
		$sign_string_veryfied = md5(
			$request['click_trans_id'].
			$request['service_id'].
			self::config('secret_key').
			$request['merchant_trans_id'].
			($request['action'] == 1
				? $request['merchant_prepare_id']
				: '').
			$request['amount'].
			$request['action'].
			urldecode($request['sign_time'])
		);
		// \Log::info('$sign_string_veryfied ' , [$sign_string_veryfied,$request['sign_string']]);
		return $sign_string_veryfied;
	}
	public static function getResponseData($data)
	{
		$handler = curl_init();

		curl_setopt_array($handler,
		[
			CURLOPT_URL => 'https://merchant.click.uz/api/',
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_SSL_VERIFYPEER => false
		]);

		$response = curl_exec($handler);

		curl_close($handler);
		$response=json_decode($response,true);
		if(!$response || !is_array($response))
			return false;
		if(!array_diff(self::$response_params[$data['action']], array_keys($response)) && $response['success']==1 && $response['error']>=0)
			return $response;
		return false;
	}
	public static function sendInvoice($click_user_phone,$user_account,$amount,$transaction_note=null)
	{
		if($transaction_note===null)
			$transaction_note=self::config('transaction_note');

		$data=
		[
			'action'=>'invoice', //	varchar	Вызываемый метод
			'service_id'=>self::config('merchant_service_id'), //	int	ID сервиса в системе CLICK
			'merchant_id'=>self::config('merchant_id'), //	int	ID Поставщика в системе CLICK
			'merchant_user_id'=>self::config('merchant_user_id'), //	int	ID Пользователя в системе CLICk
			'amount'=>number_format($amount, 2, '.', ''), //	float	Сумма оплаты (Формат: 500.00)
			'transaction_param'=>$user_account, //	varchar	Идентификатор абонента/услуги (0 если нет)
			'transaction_note'=>$transaction_note, //	varchar	Описание счета. Например: Оплата за услуги «MerchantName»
			'phone'=>$click_user_phone, //	bigint	Номер телефона Клиента, на который выставляется счет.
			'sign_time'=>date('Y-m-d H:i:s'), //	varchar	Время создания счета. (Формат: YYYY-MM-DD HH:MM:SS)
		];
		$data['sign_string']= md5($data['sign_time'] . self::config('secret_key') . $data['service_id'] . $data['transaction_param'] . $data['amount']); //	varchar	Проверочная строка, подтверждающая подлинность отправляемого запроса. ХЭШ MD5 из следующих параметров: md5(sign_time + secret_key +service_id +transaction_param + amount)	secret_key – уникальная строка, выдаваемая Поставщику при подключении.

		$response = self::getResponseData($data);
		if($response)
		{
			$transaction=
			[
				'click_trans_id' => $response['invoice_id'],
				'amount' => $data['amount'],
				'updated_at' => date('Y-m-d H:i:s'),
				'created_at' => date('Y-m-d H:i:s'),
			];
			$transaction_id= DB::table(self::config('table_prefix',true).'payments_click_invoices')
				->insertGetId($transaction);

			$transaction['id']=$transaction_id;

			return $transaction;
		}
		return false;
	}
	public static function checkInvoice($invoice_id)
	{
		$data=
		[
			'action'=>'invoice_check',	//varchar	Вызываемый метод
			'invoice_id'=>$invoice_id,	//Int	ID выставленного счета
			'service_id'=>self::config('merchant_service_id'), //	int	ID сервиса
			'merchant_user_id'=>self::config('merchant_user_id'), //	int	ID Пользователя
			'sign_time'=>date('Y-m-d H:i:s'),	//varchar	Время создания счета. (Формат: YYYY-MM-DD HH:MM:SS)
		];
		$data['sign_string']=md5($data['sign_time'].self::config('secret_key').$data['service_id'].$invoice_id);	//varchar	Проверочная строка, подтверждающая подлинность отправляемого запроса. ХЭШ MD5 из следующих параметров: 		md5(sign_time + secret_key +service_id + invoice_id) 		secret_key – уникальная строка, выдаваемая Поставщику при подключении.

		$response = self::getResponseData($data);
		if($response)
		{
			$transaction=
			[
				'updated_at' => date('Y-m-d H:i:s'),
			];
			// TODO: Проверить коды статуса
			if($response['status']<0)
				$transaction['state']='canceled';
			elseif($response['status']==1)
				$transaction['state']='commited';

			DB::table(self::config('table_prefix',true).'payments_click_invoices')
				->where('click_trans_id',$invoice_id)
				->update($transaction);

			return $transaction;
		}
		return false;
	}

}
