<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iphone;
use App\Models\Category;
use App\Models\Categorydetail;
use App\Models\Color;
use App\Models\Ram;
use App\Models\Capacity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class IphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $iphone = Iphone::all();
        return view('admin/product/iphone/index', compact('auth', 'iphone'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        $ram = Ram::all();
        $capacity = Capacity::all();
        return view('admin/product/iphone/create', compact('auth', 'categorydetail', 'color', 'ram', 'capacity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $item = $request->all();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
                return redirect('/admin/iphone/create');
            }
            $imageFile = $file->getClientOriginalName();
            $file->move('images/myimg/product_iphone', $imageFile);
        } else {
            $imageFile = null;
        }
        $item['image'] = 'images/myimg/product_iphone/' . $imageFile;
        Iphone::create($item);
        return redirect('admin/iphone');
    }

    /**
     * Display the specified resource.
     */
    public function show(Iphone $iphone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Iphone $iphone)
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        $ram = Ram::all();
        $capacity = Capacity::all();
        return view('admin/product/iphone/edit', compact('iphone', 'auth', 'categorydetail', 'color', 'ram', 'capacity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Iphone $iphone)
    {
        $iphone->update($request->all());
        return redirect('admin/iphone');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Iphone $iphone)
    {
        $iphone->delete();
        return redirect('admin/iphone');
    }
    public function searchiphone(Request $request)
    {
        if (empty($request->valuesearch)) {
            $iphone = Iphone::with('categorydetails')->get();
        } else {
            $iphone = Iphone::leftJoin('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                ->select('iphones.*')
                ->where('categorydetails.name', '=', $request->valuesearch)
                ->with('categorydetails')
                ->get();
        }

        $auth = Auth::user();
        return view('admin/product/iphone/index', compact('auth', 'iphone'));
    }
}
