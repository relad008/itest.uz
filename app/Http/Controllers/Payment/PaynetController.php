<?php

namespace App\Http\Controllers\Payment;

use App\Library\Payments\Paynet\Controller as Paynet;

class PaynetController extends Paynet
{
	use PaymentsTrait;
}
