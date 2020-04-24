<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Payments\BaseTransactionModel as Transaction;

class Payment extends Transaction
{
    public function user()
	{
		return $this->hasOne('\App\Models\User', 'phone', 'account_id');
	}
}
