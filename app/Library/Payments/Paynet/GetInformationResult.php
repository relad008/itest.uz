<?php

namespace App\Library\Payments\Paynet;

class GetInformationResult extends BaseResult
{
	protected $parameters = null;

	public function __construct($status,$parameters=[])
	{
		parent::__construct($status);
		$this->parameters=$parameters;
	}

}
