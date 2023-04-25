<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Macbook;
use App\Models\Categorydetail;
use App\Models\Capacity;
use App\Models\Color;
use App\Models\Ram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MacbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $macbook = Macbook::all();
        return view('admin/product/macbook/index', compact('auth', 'macbook'));
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
        return view('admin/product/macbook/create', compact('auth', 'categorydetail', 'color', 'ram', 'capacity'));
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
                return redirect('/admin/macbook/create');
            }
            $imageFile = $file->getClientOriginalName();
            $file->move('images/myimg/product_macbook', $imageFile);
        } else {
            $imageFile = null;
        }
        $item['image'] = 'images/myimg/product_macbook/' . $imageFile;
        Macbook::create($item);
        return redirect('admin/macbook');
    }

    /**
     * Display the specified resource.
     */
    public function show(Macbook $macbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Macbook $macbook)
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        $ram = Ram::all();
        $capacity = Capacity::all();
        return view('admin/product/macbook/edit',compact('macbook','auth','categorydetail','color','ram','capacity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Macbook $macbook)
    {
        $macbook->update($request->all());
        return redirect('admin/macbook');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Macbook $macbook)
    {
        $macbook->delete();
        return redirect('admin/macbook');
    }
    public function searchmacbook(Request $request)
    {
        $macbook = Macbook::leftJoin('categorydetails', 'macbooks.categorydetail_id', '=', 'categorydetails.id')
            ->select('macbooks.*')
            ->where('categorydetails.name', 'like', '%' . $request->valuesearch . '%')
            ->with('categorydetails')
            ->get();

        $auth = Auth::user();
        return view('admin/product/macbook/index', compact('auth', 'macbook'));
    }
}
