<?php

namespace App\Http\Controllers\API;

use App\Models\Price;
use App\Models\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\ClickController as Click;

class PayController extends Controller
{
    /**
     * Send Click invoice
     *
     * @return void
     */
    public function sendClickInvoice()
	{
		$data = request()->validate([
			'phone'     => 'required|regex:/^998\d{9}$/',
			'price_id'  => 'required|exists:prices,id',
		]);
        $data['phone'] = preg_replace('/[^\d]+/', '', $data['phone']);
		$price = Price::find($data['price_id']);
		
		// Click::sendInvoice($data['phone'], auth()->user()->phone, $price->price);
        
        return response()->json([
            'status' => 1
        ]);
    }
    
    /**
     * Buy test from account balance.
     * It's only for Paynet
     *
     * @return void
     */
    public function buyFromAccount()
	{
		$data = request()->validate([
			'price_id'  => 'required|exists:prices,id',
		]);
        
        $price = Price::find($data['price_id']);
		$ammount = auth()->user()->getAccount(false);
		
		$has = Account::valid()->first();
		if ($has) {
            return response()->json([
                'status' => false,
                'message' =>trans('mess.earlier_bought')
            ]);
        }

		if ($ammount < $price->price)
		{
			return response()->json([
                'status' => false,
				'message' => trans('mess.you_need')
                    .number_format($price->price - $ammount, 0, ',', ' ')
                    .trans('main.sum')
            ]);
        }
        
		Account::create([
			'user_id'    => auth()->user()->id,
			'type'       => 'price',
			'sum'        => -$price->price,
			'expired_at' => gmdate('Y-m-d H:i:s', time()+($price->getDaysToExpired()+1)*60*60*24),
			'price_id'   => $price->id,
        ]);
        
		return response()->json([
            'status'  => true,
            'message' => trans('mess.success_buy')
        ]);

	}
}
