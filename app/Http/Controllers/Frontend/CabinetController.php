<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CabinetController extends Controller
{

	/**
	 * Cabinet - Vue SPA
	 * 
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
		// If not student access redirect to admin panel
		if (!auth()->user()->hasRole(['student'])) {
			return redirect()->route('backend.dashboard');
		}

		$user = request()->user();
        $user->balance = $user->getAccount();

    	return view('frontend.cabinet.index', compact('user'));
    }
}
