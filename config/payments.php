<?php

return [
	'table_prefix'=>'',
	'users_table' => 'users',
	'user_id'=>'phone',
	'user_name'=>'name',
	'system_account_id_name'=>'phone',
	'min_amount'=>500,
	'max_amount'=>9999999,
	'debug'=>env('PAYMENTS_DEBUG',false),

	'systems'=>
	[
		'click'=>
		[
			'secret_key'=>'oG4VyyfJq2v#0FdIr@Ll2LAq',
			'merchant_id'=>'213',
			'merchant_service_id'=>'164',
			'merchant_user_id'=>'164',


		],
		'paynet'=>
		[
			'username' => 'itest_strong_user',
			'password' => 'S9PxzbwcdvYTyfv',
			// 'ip_list'=>[]
		],
		'paycom'=>
		[
			'username'=>'Paycom',
			'password'=>'FD?MAregMkXqg67A2F4jetrZS1TN8qd2n1FF',
			'merchant_id'=>'58ac189bce775bff41f43154',

		],
	],
];