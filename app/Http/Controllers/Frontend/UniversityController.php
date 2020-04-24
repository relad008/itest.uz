<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Region;
use App\Models\University;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UniversityController extends Controller
{
    public function index()
    {
        $cities = Region::has('universities')->get();
        $univers_count = University::count();
    	return view('frontend.university.index', compact('cities', 'univers_count'));
    }

    public function list(Request $request)
    {
        $cities = Region::has('universities')->get();
        $univers = University::orderBy('name_'.app()->getLocale())
            ->when($request->has('city_id'), function ($query, $role) use ($request) {
                return $query->where('city_id', $request->city_id);
            })
            ->get();

    	return view('frontend.university.list', compact('cities', 'univers'));
    }

    public function show($id)
    {
        $univer = University::find($id);
        
        if (!$univer) {
            abort(404);
        }

        $subjects  = TestCategory::pluck('name_'.app()->getLocale(), 'id')->toArray();
        $faculties = $univer->faculties()->get()->groupBy('lang')->all();
        
        return view('frontend.university.show', compact('univer', 'subjects', 'faculties'));
    }
}
