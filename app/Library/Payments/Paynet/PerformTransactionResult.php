<?php
namespace App\Library\Payments\Paynet;
class PerformTransactionResult extends BaseResult
{

	protected $providerTrnId = null;

	public function __construct($status,$providerTrnId=null)
	{
		parent::__construct($status);
		$this->providerTrnId=$providerTrnId;
	}
}