<?php

namespace App\Library\Payments\Paynet;

class CancelTransactionResult extends BaseResult
{
	protected $transactionState = null;

	public function __construct($status,$transactionState=null)
	{
		parent::__construct($status);
		$this->transactionState=$transactionState;
	}

}
