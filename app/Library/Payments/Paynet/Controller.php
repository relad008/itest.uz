<?php
namespace App\Library\Payments\Paynet;
use Log,
	Request,
	DB,
	Schema,
	App\Library\Payments\BaseTransactionModel as Transaction,
	App\Library\Payments\ErrorException;

class Controller extends \App\Library\Payments\BaseController
{
	protected
		$parameters=null,
		$method,
		$arguments,
		$status=0;
	protected static $system_name='paynet';
	protected static $error_messages=
	[
		0=>'Проведено успешно',
		100=>'Услуга временно не поддерживается',
		101=>'Квота исчерпана',
		102=>'Системная ошибка',
		103=>'Неизвестная ошибка',
		201=>'Транзакция уже существует',
		202=>'Транзакция уже отменена',
		203=>'Карта уже зарегистрирована',
		301=>'Номер не существует',
		302=>'Клиент не найден',
		303=>'Заказ не существует',
		304=>'Товар не найден',
		305=>'Услуга не найдена',
		401=>'Ошибка валидации параметра 1',
		402=>'Ошибка валидации параметра 2',
		403=>'Ошибка валидации параметра 3',
		404=>'Ошибка валидации параметра 4',
		405=>'Ошибка валидации параметра 5',
		406=>'Ошибка валидации параметра 6',
		407=>'Ошибка валидации параметра 7',
		408=>'Ошибка валидации параметра 8',
		409=>'Ошибка валидации параметра 9',
		410=>'Ошибка валидации параметра 10',
		411=>'Не заданы один или несколько обязательных параметров',
		412=>'Неверный логин',
		413=>'Неверная сумма',
		414=>'Неверный формат даты и времени',
		501=>'Транзакции юридическим лицам запрещены',
		502=>'Клиент вне обслуживания провайдером',
		601=>'Доступ запрещен',
		602=>'Ошибка синхронизации времени',
		603=>'Неправильный код команды',
	];
	protected static $transaction_states=
	[
		'commited'=>1,
		'canceled'=>2,
	];
	protected static $def_config=
	[
		'username' => null,
		'password' => null,
		'ip_list' => [
			// '213.230.106.112', //28
			// '213.230.65.80', // 28
			'213.230.106.113',
			'213.230.106.114',
			'213.230.106.115',
			'213.230.106.116',
			'213.230.106.117',
			'213.230.106.118',
			'213.230.106.119',
			'213.230.106.120',
			'213.230.106.121',
			'213.230.106.122',
			'213.230.106.123',
			'213.230.106.124',
			'213.230.106.125',
			'213.230.106.126',
			'213.230.65.81',
			'213.230.65.82',
			'213.230.65.83',
			'213.230.65.84',
			'213.230.65.85',
			'213.230.65.86',
			'213.230.65.87',
			'213.230.65.88',
			'213.230.65.89',
			'213.230.65.90',
			'213.230.65.91',
			'213.230.65.92',
			'213.230.65.93',
			'213.230.65.94',
			'127.0.0.1',
		],
	];

	protected static $request_params=
	[
		'GetInformation'=>
		[
			'serviceId',
			'parameters'
		],
		'GetStatement'=>[
			'serviceId',
			'dateFrom',
			'dateTo',
			'onlyTransactionId'
		],
		'ChangePassword'=>[
			'newPassword'
		],
		'CancelTransaction'=>[
			'serviceId',
			'transactionId'
		],
		'CheckTransaction'=>[
			'serviceId',
			'transactionId',
			'transactionTime'
		],
		'PerformTransaction'=>[
			'serviceId',
			'parameters',
			'amount',
			'transactionId',
			'transactionTime'
		]
	];


	// CASTOMISATIONS
	public function getAccountId()
	{
		$account_id_name=self::config('system_account_id_name',true);
		if(!isset($this->parameters[$account_id_name]))
			$this->wrongParametrs();
		return $this->parameters[$account_id_name];
	}
	// Validate ammount
	public function getAmount()
	{
		return round($this->arguments->amount/100);
	}
	// get User_info

	public function getInfo()
	{
		$params =
		[
			'account_id'=> $this->getAccountId(),
		];
		$user_name=self::config('user_name',true);
		if($user_name)
			$params['user_name']=$this->user->$user_name;
		return $params;
	}
	//-------------
	public function error($code)
	{
		throw new ErrorException('', $code);

	}
	public function wrongParametrs()
	{
		$this->error(411);
	}
	public function userDoesNotExists()
	{
		$this->error(302);
	}
	public function orderDoesNotExists()
	{
		$this->error(303);
	}
	public function productDoesNotExists()
	{
		$this->error(304);
	}
	public function serviceDoesNotExists()
	{
		$this->error(305);
	}
	public function numberDoesNotExists()
	{
		$this->error(301);
	}
	public function orderAlreadyPayed()
	{
		$this->error(103);
	}
	public function cardAlreadyRegistred()
	{
		$this->error(203);
	}
	public function serviceUnvailable()
	{
		$this->error(100);
	}
	public function amountIsInvalid()
	{
		$this->error(413);
	}
	public function validateRequest()
	{
		$IP = self::getRequestIp();
		// \Log::info('IP'.$IP);
		if (!in_array($IP,  self::config('ip_list')))
			$this->error(601);

		if(!isset(self::$request_params[$this->method]))
			$this->error(603);

		$request_params=self::$request_params[$this->method];
		$auth_params = ['password', 'username'];
		$vars = get_object_vars($this->arguments);
		$diff = array_diff(array_merge($request_params, $auth_params), array_keys($vars));
		if (!empty($diff))
			$this->error(411);
		// \Log::info('auth',[$this->arguments->username ,self::config('username') , $this->arguments->password ,self::config('password')]);
		if ($this->arguments->username !=self::config('username') || $this->arguments->password !=self::config('password'))
			$this->error(412);


		if (in_array('amount',self::$request_params[$this->method]))
			$this->checkAmount($this->method,$this->arguments);

		if(in_array('parameters',self::$request_params[$this->method]))
		{
			if(empty($this->arguments->parameters))
				$this->error(411);

			$parameters=$this->arguments->parameters;

			if(is_object($parameters))
				$parameters=[$parameters];

			$parameters=collect($parameters)->pluck('paramValue', 'paramKey')->all();


			$this->parameters=$parameters;
			$this->checkPayment();

		}

	}

	public function __call($method,$arguments)
	{
		\Log::info('__call '.$method,$arguments);
		$response_arr=[];
		$this->method=$method;
		$this->arguments=$arguments[0];

		try
		{
			$this->validateRequest();
			$method_name='action'.$method;
			$response_arr=$this->$method_name();

		}
		catch(ErrorException $e)
		{
			$this->status=$e->getCode();
			\Log::info($e->getTraceAsString());
		}
		catch (\Exception $e)
		{
			$this->status=102;
			\Log::info($e->getMessage());
			\Log::info($e->getTraceAsString());
		}

		array_unshift($response_arr, $this->status);
		self::storeLog([$method,$arguments],$response_arr);

		if($this->status==603)
			$method='Base';

		$reflectionClass = new \ReflectionClass(str_replace('Controller', $method.'Result', self::class));
		return $reflectionClass->newInstanceArgs($response_arr);
	}
	public function actionPerformTransaction()
	{

		$providerTrnId = 0;

		$transaction = Transaction::where('system_transaction_id',$this->arguments->transactionId)
			->where('system',self::$system_name)
			->first();
		// \Log::info('transaction ',[$transaction]);
		if (!$transaction)
		{
			$transaction=Transaction::create(
				[
					'amount_tiin' => $this->arguments->amount,
					'amount' => $this->getAmount(),
					'account_id' => $this->getAccountId(),
					'parameters' => json_encode($this->parameters) ,
					'paynet_service_id' => $this->arguments->serviceId,
					'system_transaction_id' => $this->arguments->transactionId,
					'paynet_transaction_time' => $this->arguments->transactionTime,
					'system'=>self::$system_name,
					'state' => 'commited', // commited
					'created_at' => new \DateTime,
				]);
				$this->onTransactionCreated($transaction);
				$this->onTransactionCommited($transaction);
		}
		else
		{
			$this->status = 201;
		}
		return[$transaction->id];
	}
	public function actionCheckTransaction()
	{
		$providerTrnId = 0;
		$transactionState = 0;

		$transactionStateErrorStatus = 0;
		$transactionStateErrorMsg = 'ОК';

		$transaction = Transaction::where('system_transaction_id',$this->arguments->transactionId)
			->where('system',self::$system_name)
			->first();
		if ($transaction)
		{
			$transactionState =self::$transaction_states[$transaction->state];
			$providerTrnId = $transaction->id;
		}
		else
		{
			$this->status = 103;
			$transactionStateErrorMsg="Транзакция не найдена";
		}
		return [$providerTrnId,$transactionState,$transactionStateErrorStatus,$transactionStateErrorMsg];
	}

	public function actionCancelTransaction()
	{


		$transaction = Transaction::where('system_transaction_id',$this->arguments->transactionId)
			->where('system',self::$system_name)->first();
		// \Log::info('transaction',[$transaction]);
		$transactionState = 0;

		if (!$transaction)
		{
			$this->status = 103;
		}
		else
		{
			$transactionState = self::$transaction_states[$transaction->state];
			// \Log::info('transactionState '.$transactionState);
			if ($transaction->state == 'canceled')
			{
				$this->status = 202;
			}
			else
			{
				if ($this->isCancalableTransaction($transaction))
				{
					// Cancel transaction
					$transaction->update(['state' => 'canceled', 'updated_at' => new \DateTime]); // canceled
					$this->onTransactionCanceled($transaction);
				}
				else
				{
					$this->status = 77;
				}

			}

		}
		return [$transactionState];
	}
	public function actionGetInformation()
	{
		$parameters=[];
		$params=$this->getInfo();
		foreach($params as $key=>$val)
		{
			$parameters[]=['paramKey'=>$key,'paramValue'=>$val];
		}
		return [$parameters];
	}

	public function actionGetStatement()
	{
		$fields=[
			'system_transaction_id as transactionId',
			'id as providerTrnId'
		];

		if($this->arguments->onlyTransactionId)
		{
			$fields[]='amount_tiin as amount';
			$fields[]='paynet_transaction_time as transactionTime';
		}
		$statements = Transaction::select($fields)
			->where('system',self::$system_name)
			->whereBetween('created_at', [new \DateTime($this->arguments->dateFrom), new \DateTime($this->arguments->dateTo)])
			// ->where('state', 'commited')
			->where('paynet_service_id', $this->arguments->serviceId)
			->orderBy('created_at')
			->get()->toArray();


		return [$statements];
	}


	public function actionChangePassword()
	{
		$this->status=603;
		// TODO: change password to  $this->arguments->newPassword

		return[];
	}
	public static function getWSDL()
	{
		return __DIR__.'/paynet.wsdl';
	}
	public function callbackRoute(Request $request)
	{
		header("Content-Type: text/xml; charset=utf-8");
		header('Cache-Control: no-store, no-cache');
		header('Expires: '.date('r'));
		ini_set('soap.wsdl_cache_enabled', '0');

		// \Log::info('init callback');

		$server = new \SoapServer(self::getWSDL());
		$server->setObject($this);
		ob_start();
		//Запускаем сервер
		try {
			$server->handle();
		} catch (\Exception $e) {
			\Log::info($e->getTrace());
		}
		$res=rtrim(ob_get_flush ());

		\Log::info($res);
		echo $res;

	}

}