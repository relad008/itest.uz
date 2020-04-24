<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Price;

class PriceController extends Controller
{
    public function list()
    {
        $prices = Price::where('disabled', '0')
                       ->orderBy('price')
                       ->get();
        return $prices;
    }
}
