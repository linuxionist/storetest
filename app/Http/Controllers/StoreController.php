<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        return response()->json([
            'success' => true,
            'data' => $store
        ]);
    }

    public function show($id)
    {
        $store = auth()->user()->store()->find($id);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'store is not available! '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $store->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'storename' => 'required',
			'storeaddress' => 'required',
			'storephone' => 'required',
			'storeemail' => 'required',
			'storelocation' => 'required',
			'storeimage' => 'required'
        ]);

        $store = new store();
        $store->storename = $request->storename;
        $store->storeaddress = $request->storeaddress;
        $store->storephone = $request->storephone;
		$store->storeemail = $request->storeemail;
		$store->storelocation = $request->storelocation;
		$store->storeimage = $request->storeimage;

        if (auth()->user()->store()->save($store))
            return response()->json([
                'success' => true,
                'data' => $store->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'store could not be added!'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $store = auth()->user()->store()->find($id);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'store could not be found!'
            ], 400);
        }

        $updated = $store->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'store could not be updated!'
            ], 500);
    }

    public function destroy($id)
    {
        $store = auth()->user()->store()->find($id);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'store could not be found!'
            ], 400);
        }

        if ($store->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'store could not be deleted!'
            ], 500);
        }
    }
}
