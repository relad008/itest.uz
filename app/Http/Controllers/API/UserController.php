<?php

namespace App\Http\Controllers\API;

use App\Models\Region;
use App\Models\Faculty;
use App\Models\University;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;

class UserController extends Controller
{
    public function info(Request $request)
    {
        $user = $request->user();
        $user->balance = $request->user()->getAccount();
        return $user;
    }

    public function profileData()
    {
        $regions = Region::select('id', DB::raw('name_'.app()->getLocale().' as name'), 'parent_id')
                         ->orderBy('parent_id')
                         ->orderBy('id')
                         ->get();

        $universities = University::select('id', 'name_'.app()->getLocale().' as name')
                                  ->orderBy('name_'.app()->getLocale())
                                  ->get()
                                  ->pluck('name', 'id');

        $faculties = Faculty::select('id',
                                     DB::raw('CONCAT(code, " ", name_'.app()->getLocale().') as name'),
                                     'university_id',
                                     'subject_1_id',
                                     'subject_2_id',
                                     'subject_3_id'
                                    )
                      ->orderBy('university_id')
                      ->orderBy('code')
                      ->get()
                      ->groupBy('university_id')
                      ->prepend([]);
        
        $subjects = TestCategory::select('id', 'name_ru', 'subject_type', 'subject_lang')
                                ->where('depth', 0)
                                ->get();

        return response()->json(compact(
            'regions',
            'universities',
            'faculties',
            'subjects'
        ));
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail($attribute.' is invalid.');
                    }
                },
            ],
            'new' => 'required|min:6|confirmed',
        ]);

        $data = [
            'password' => bcrypt($request->new)
        ];

        $user->update($data);
        return response()->json([
            'success' => true,
            'message' => trans('alert.success.update')
        ]);
    }

    public function updateGeneral(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name'          => 'required',
            'district_id'   => 'required|exists:regions,id',
            'city_id'       => 'required|exists:regions,id',
            'address'       => 'nullable',
        ]);
        
        $user->update($data);
        $user->balance = $request->user()->getAccount();
        return response()->json([
            'success' => true,
            'message' => trans('alert.success.update'),
            'user'    => $user,
        ]);
    }

    public function updateDirection(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'lang'          => 'required|in:uz,ru',
            'university_id' => 'required|exists:universities,id',
            'faculty_id'    => 'required|exists:faculties,id',
            'subject_1_id'  => 'exists:test_categories,id',
            'subject_2_id'  => 'exists:test_categories,id',
            'subject_3_id'  => 'exists:test_categories,id',
        ]);
        
        $user->update($data);
        $user->balance = $request->user()->getAccount();
        return response()->json([
            'success' => true,
            'message' => trans('alert.success.update'),
            'user'    => $user,
        ]);
    }
}
