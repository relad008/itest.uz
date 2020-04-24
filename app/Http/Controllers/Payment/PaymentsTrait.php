<?php
namespace App\Http\Controllers\Payment;

use App\Models\User;
use App\Models\Price;
use App\Models\Account;

use App\Library\Payments\BaseTransactionModel as Transaction;

trait PaymentsTrait
{
	public function onTransactionCommited(Transaction $transaction)
	{
		$user = User::where('phone', $transaction->account_id)->first();
		if($user) {
			$ac = new Account;
			$ac->pays_id = $transaction->system_transaction_id;
			$ac->type = self::$system_name;
			$ac->user_id = $user->id;
			$ac->payment_status = 'commited';
			$ac->sum = $transaction->amount;
            $ac->save();
            
            $price = Price::where('price', $ac->sum)
                          ->where('disabled', 0)
                          ->first();
			if($price) {
				\Log::info($price);
				Account::create([
					'user_id'    => $user->id,
					'type'       => 'price',
					'sum'        => -$price->price,
					'expired_at' => gmdate('Y-m-d H:i:s', time() + ($price->getDaysToExpired() + 1) * 60 * 60 * 24),
					'price_id'   => $price->id,
				]);
			}
		}
    }
    
	public function onTransactionCanceled(Transaction $transaction)
	{
		$user = User::where('phone',$transaction->account_id)->first();
		if ($user) {
			$ac = new Account;
			$ac->pays_id = $transaction->system_transaction_id;
			$ac->type = self::$system_name;
			$ac->user_id = $user->id;
			$ac->payment_status = 'canceled';
			$ac->sum = -$transaction->amount;
			$ac->save();
		}
	}
}