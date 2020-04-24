<?php

namespace App\Library\Payments;

class BaseTransactionModel extends \Illuminate\Database\Eloquent\Model
{
	protected $guarded = [];
	public function __construct(array $attributes = [])
	{
		$this->table = config('payments.table_prefix').'payments';
		parent::__construct($attributes);
	}
}