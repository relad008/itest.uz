<?php

namespace App\Http\Controllers\Backend;

use DB;
use DataTables;
use App\Models\User;
use App\Models\Region;
use App\Models\Account;
use App\Models\Faculty;
use App\Models\University;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private static $roles = [
        'admin'         => 'Администратор',
        'main_teacher'  => 'Главный учитель',
        'teacher'       => 'Учитель',
        'student'       => 'Студент'
    ];

    public function index()
    {
        $roles = self::$roles;
        $categories = TestCategory::where('parent_id', '0')->get()->pluck('name_ru', 'id');
        $categories->prepend('-', 0);
        return view('backend.user.index', compact('roles', 'categories'));
    }

    public function userData()
    {
        $data = User::where('role', '!=', 'student')->with('category');
        return DataTables::of($data)
                         ->addColumn('category_name', function ($user) {
                            return $user->category ? $user->category->name : '';
                         })
                         ->make(true);
    }

    public function form(Request $request)
    {
        if (!auth()->user()->hasRole(['admin'])) {
			return ;
        }

        $data = $request->validate([
			'category_id'   => 'required|integer',
			'name'          => 'required',
			'email'         => 'required|email',
			'role'          => 'required|in:-,'.implode(',', array_keys(self::$roles)),
        ]);

		if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->id) {
            $item = User::find($request->id);
            
            if ($item) {
                $item->update($data);
            }
            
        } else {
            $data['phone'] = '';
            User::create($data);
        }
        
		return response()->json(['status' => 'success']);
    }

    /**
     * Delete user
     * 
     * @param  Request $request
     * @return json           
     */
    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $item = User::find($request->id);
            $item->delete();

            $response = [
                'status' => 'success',
                'message' => trans('alert.success.delete')
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Пожалуйста попробуйте снова'
            ];
        }
        
        return response()->json($response);
    }

    public function student()
    {
        $regions = Region::select('id', 'name_'.app()->getLocale().' as name', 'parent_id')
                         ->orderBy('parent_id')
                         ->orderBy('id')
                         ->get();

        $universities = University::select('id', 'name_'.app()->getLocale().' as name')
                                  ->orderBy('name_'.app()->getLocale())
                                  ->get()
                                  ->pluck('name', 'id');

        $faculties = Faculty::select('id', DB::raw('CONCAT(code," ",name_'.app()->getLocale().') as name'), 'university_id')
                      ->orderBy('university_id')
                      ->orderBy('code')
                      ->get()
                      ->groupBy('university_id')
                      ->prepend([]);
        
        $subjects = TestCategory::select('id', 'name_ru', 'subject_type', 'subject_lang')
                                ->where('depth', 0)
                                ->get()
                                ->pluck('name_ru', 'id');

        return view('backend.user.student', compact('regions', 'universities', 'faculties', 'subjects'));
    }

    public function studentData()
    {
        $data = User::where('role', 'student');
        return DataTables::of($data)
                         ->addColumn('account', function ($user) {
                            return $user->getAccount();
                         })
                         ->addColumn('total_tests', function ($user) {
                            return $user->totalTests();
                         })
                         ->make(true);
    }

    public function studentForm(Request $request)
    {
        if (!auth()->user()->hasRole(['admin'])) {
			return ;
        }

        $request->merge([
            'year_subscribe' => $request->has('year_subscribe') ? 2 : 0
        ]);
        $data = $request->validate([
			'name'              => 'required',
			'id'                => 'required',
			// 'email'=>'email|unique:users,email',
			'city_id'           => 'required|integer',
			'district_id'       => 'required|integer',
			'birthdate'         => 'required', //TODO DATE
			'address'           => '',
			'password'          => 'confirmed',
			'phone'             => 'required|regex:/^998\d{9}$/',
			'lang'              => 'required|in:'.implode(',', config('app.available_language')),
			'university_id'     => 'required|integer',
			'faculty_id'        => 'required|integer',
			'subject_1_id'      => 'required|integer',
			'subject_2_id'      => 'required|integer',
            'subject_3_id'      => 'required|integer',
            'year_subscribe'    => 'required'
        ]);

		// Добавляю на счет
		if ($data['year_subscribe']) {
			Account::create([
                'user_id' => $data['id'],
                'sum'     => config('app.year_subscribe_price'),
                'type'    => 'admin'
            ]);
			Account::create([
                'user_id' => $data['id'],
                'sum'     => -config('app.year_subscribe_price'),
                'type'    => 'year_subscribe'
            ]);
		}
		else {
            Account::where('user_id', $data['id'])
                   ->where('sum', config('app.year_subscribe_price'))
                   ->where('type','admin')
                   ->delete();
            Account::where('user_id', $data['id'])
                   ->where('sum', -config('app.year_subscribe_price'))
                   ->where('type', 'year_subscribe')
                   ->delete();
		}
		if ($request->password) {
			$data['password'] = bcrypt($data['password']);
        } else {
			unset($data['password']);
        }

        User::find($data['id'])->update($data);
        return response()->json(['status' => 'success']);
    }

    /**
     * User profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();
        return view('backend.user.profile', compact('user'));
    }

    /**
	 * Save user data
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return redirect()
	 */
    public function saveProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        
        $data = [
            'password' => bcrypt($request->password)
        ];
        $user->update($data);

        return redirect()->back()->with('success', trans('alert.success.update'));
    }
}
