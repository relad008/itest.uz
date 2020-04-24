<?php

namespace App\Library\Payments\Paynet;

class GetStatementResult extends BaseResult
{
	protected $statements = null;

	public function __construct($status,$statements=[])
	{
		parent::__construct($status);
		$this->statements=$statements;
	}

}
