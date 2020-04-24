<?php

namespace App\Http\Controllers\Payment;

use App\Library\Payments\Click\Controller as Click;

class ClickController extends Click
{
	use PaymentsTrait;
}
