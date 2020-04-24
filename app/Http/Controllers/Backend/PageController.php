<?php

namespace App\Http\Controllers\Backend;

use App\Models\Theme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;

class PageController extends Controller
{
    public function dashboard()
    {
        $parents_arr = func_get_args();
		$parents = '';
		if ($parents_arr) {
			$parents = '#'.implode('##', $parents_arr).'#';
        }

		$categories = Theme::where('parents', $parents)->get();
        return view('backend.page.dashboard', compact('categories', 'parents_arr'));
    }

    public function referalStat()
	{
		return view('backend.page.referal-stat');
    }
    
    public function referalStatData()
    {
        $data = DB::table('referals')
                  ->select(DB::raw('count(id) as count'), 'from')
                  ->groupBy('from');

        return DataTables::of($data)->make(true);
    }
}
