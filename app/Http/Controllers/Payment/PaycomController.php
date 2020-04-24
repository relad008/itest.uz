<?php

namespace App\Http\Controllers\Payment;

use App\Library\Payments\Paycom\Controller as Paycom;

class PaycomController extends Paycom
{
	use PaymentsTrait;
}
