<?php
namespace App\Library\Payments\Paynet;
class CheckTransactionResult extends BaseResult
{

	protected $providerTrnId = null,
		$transactionState = null,
		$transactionStateErrorStatus = null,
		$transactionStateErrorMsg = null;

	public function __construct($status,$providerTrnId=null,$transactionState=null,$transactionStateErrorStatus=null,$transactionStateErrorMsg=null)
	{
		parent::__construct($status);

		$this->providerTrnId=$providerTrnId;
		$this->transactionState=$transactionState;

		$this->transactionStateErrorMsg=$transactionStateErrorMsg;
		$this->transactionStateErrorStatus=$transactionStateErrorStatus;
	}
}