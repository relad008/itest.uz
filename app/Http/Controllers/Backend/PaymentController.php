<?php

namespace App\Http\Controllers\Backend;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        $total_by_service = [];
		$total = 0;
		foreach (config('lib_payments.systems') as $system_name => $val) {
            $amount = Payment::where('state', 'commited')
                             ->where('system', $system_name)
                             ->sum('amount');
			$total += $amount;
			$total_by_service[$system_name] = $this->number($amount);
		}
        $total = $this->number($total);
        
        return view('backend.payment.index', compact('total_by_service', 'total'));
    }

    public function data(Request $request)
    {
        $data = Payment::with('user');
        return DataTables::of($data)
            ->addColumn('amount_format', function(Payment $payment) {
                return $this->number($payment->amount).' сум';
            })
            ->make(true);
    }

    public function number($data)
	{
		return number_format($data, 0, ',', ' ');
	}

}
