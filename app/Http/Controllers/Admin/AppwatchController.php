<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appwatch;
use App\Models\Categorydetail;
use App\Models\Color;
use App\Models\Capacity;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppwatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $appwatch = Appwatch::all();
        return view('admin/product/appwatch/index', compact('auth', 'appwatch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        $size = Size::all();
        $capacity = Capacity::all();
        return view('admin/product/appwatch/create', compact('auth', 'categorydetail', 'color', 'size', 'capacity'));
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
                return redirect('/admin/appwatch/create');
            }
            $imageFile = $file->getClientOriginalName();
            $file->move('images/myimg/product_appwatch', $imageFile);
        } else {
            $imageFile = null;
        }
        $item['image'] = 'images/myimg/product_appwatch/' . $imageFile;
        Appwatch::create($item);
        return redirect('admin/appwatch');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appwatch $appwatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appwatch $appwatch)
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        $size = Size::all();
        $capacity = Capacity::all();
        return view('admin/product/appwatch/edit',compact('appwatch','auth','categorydetail','color','size','capacity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appwatch $appwatch)
    {
        $appwatch->update($request->all());
        return redirect('admin/appwatch');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appwatch $appwatch)
    {
        $appwatch->delete();
        return redirect('admin/appwatch');

    }

    public function searchappwatch(Request $request)
    {
        $appwatch = Appwatch::leftJoin('categorydetails', 'appwatches.categorydetail_id', '=', 'categorydetails.id')
            ->select('appwatches.*')
            ->where('categorydetails.name', 'like', '%' . $request->valuesearch . '%')
            ->with('categorydetails')
            ->get();

        $auth = Auth::user();
        return view('admin/product/appwatch/index', compact('auth', 'appwatch'));
    }
}
