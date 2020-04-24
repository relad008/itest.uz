<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Region;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfiController extends Controller
{
	public function index()
	{
		$reviews = Review::get();
		$regions = Region::where('parent_id', 0)->orWhere('id', 2)->get()->pluck('name_ru', 'id');
		return view('frontend.pro-edu.index', compact('reviews', 'regions'));
	}

	public function teachers()
	{
		return view('frontend.pro-edu.teachers');
	}

	public function about()
	{
		return view('frontend.pro-edu.about');
	}
}
