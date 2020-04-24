<?php

namespace App\Http\Controllers\Backend;

use Upload;
use DataTables;
use App\Models\Region;

use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UniversityController extends Controller
{
    public function index()
    {
        $cities = Region::select('id', 'name_ru', 'parent_id')
            ->orderBy('name_ru')
            ->where('parent_id', '!=', 0)
            ->get()
            ->groupBy('parent_id');
        $regions = Region::where('parent_id', 0)->get();
        
        $list = [];
        foreach ($regions as $region) {
            $list[$region->name_ru] = $cities[$region->id]->pluck('name_ru', 'id');
        }
         
        return view('backend.university.index', compact('list'));
    }

    public function data(Request $request)
    {
        $data = University::with('city');
        return DataTables::of($data)
                         ->addColumn('city_name', function($item) {
                            if ($item->city) {
                                return $item->city->name();
                            }
                            return null;
                         })
                         ->addColumn('img', function ($item) {
                            return Upload::getFile('university', $item->id);
                         })
                         ->make(true);
    }

    /**
     * Create and update
     * 
     * @param  Request $request
     * @return json
     */
    public function form(Request $request)
    {
        $i=$request->only('name_ru', 'name_uz', 'subtitle_ru', 'subtitle_uz', 'address_ru', 'address_uz', 'phone', 'founded_at', 'contract_min', 'contract_max', 'city_id', 'about_ru', 'about_uz', 'photo', 'hostel', 'foreign');

		$request->merge([
            'hostel'    => $request->has('hostel'),
            'foreign'   => $request->has('foreign'),
        ]);

        $data = $request->validate([
            'name_ru'               => 'required',
            'name_uz'               => 'required',
            'subtitle_ru'           => '',
            'subtitle_uz'           => '',
            'address_ru'            => '',
            'address_uz'            => '',
            'about_ru'              => '',
            'about_uz'              => '',
            'city_id'               => 'required',
            'phone'                 => 'required',
            'photo'                 => ($request->has('id') ? '' : 'required|').'image',
            'hostel'                => 'boolean',
            'foreign'               => 'boolean',
        ]);
        unset($data['photo']);
        
        if ($request->id) {
            $item = University::find($request->id);

            if($item) {
                $item->update($data);
            }

        } else {
            $data['alias'] = $this->aliasCreate($data['name_ru']);
            $item = University::create($data);
        }
        
        return response()->json(['status' => 'success']);
    }

    /**
     * Delete
     * 
     * @param  Request $request
     * @return json           
     */
    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $item = University::find($request->input('id'));
            $item->blogs()->sync([]);
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

    /**
	 * Alias Create
     * 
	 * @param  string $value
	 * @return string       
	 */
	private function aliasCreate($value)
    {
        $slug = str_slug($value);
        $model = new University;
        $slugCount = count($model->whereRaw("alias REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
