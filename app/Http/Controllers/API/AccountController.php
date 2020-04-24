<?php

namespace App\Http\Controllers\API;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function list(Request $request)
    {
        $per_page = $request->input('per_page', 20);
        
        return Account::where('user_id', $request->user()->id)
                      ->orderBy('id', 'desc')
                      ->with('price')
                      ->paginate($per_page);
    }
}
