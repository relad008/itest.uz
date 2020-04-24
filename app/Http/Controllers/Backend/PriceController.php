<?php

namespace App\Http\Controllers\Backend;

use App\Models\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;

class PriceController extends Controller
{
    public function index()
	{
		return view('backend.price.index');
    }

    public function data(Request $request)
    {
        $data = Price::query();
        return DataTables::of($data)
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
        $data = $request->only(
            'name_ru',
            'name_uz',
            'price',
            'months_count',
            'economy'
        );
        $data['thematic_available'] = $request->has('thematic_available') ? '1' : '0';
        $data['direction_available'] = $request->has('direction_available') ? '1' : '0';
        $data['has_chat'] = $request->has('has_chat') ? '1' : '0';
        $data['disabled'] = $request->has('disabled') ? '1' : '0';
        $request->merge($data);

        $request->validate([
            'name_ru'               => 'required|min:2|max:255',
            'name_uz'               => 'required|min:2|max:255',
            'price'                 => 'required|numeric',
            'economy'               => 'integer',
			'months_count'          => 'required|integer',
			'thematic_available'    => 'required|in:0,1',
			'direction_available'   => 'required|in:0,1',
			'has_chat'              => 'required|in:0,1',
			'disabled'              => 'required|in:0,1',
        ]);
        
        $data['days_to_expired'] = $data['months_count'] * 31;

        if ($request->id) {
            $item = Price::find($request->id);

            if($item) {
                $item->update($data);
            }

        } else {
            $item = Price::create($data);
        }
        
        return response()->json(['status' => 'success']);
    }
    
	public function edit($id = null)
	{
		if ($id) {
			$price = Price::findOrFail($id);
        } else {
            $price = [];
        }

		return view('backend.price.edit', compact('price'));
    }
    
    /**
     * Delete price
     * 
     * @param  Request $request
     * @return json           
     */
    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $item = Price::find($request->input('id'));
            $item->update([
                'disabled' => '1'
            ]);
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
}
