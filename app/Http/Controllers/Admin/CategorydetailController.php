<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Categorydetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategorydetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        return view('admin/categorydetail/index', compact('auth', 'categorydetail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        $category = Category::all();
        return view('admin/categorydetail/create', compact('auth', 'category'));
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
                return redirect('/admin/categorydetail/create');
            }
            $imageFile = $file->getClientOriginalName();
            $file->move('images/myimg/category', $imageFile);
        } else {
            $imageFile = null;
        }
        $item['image'] = 'images/myimg/category/' . $imageFile;
        Categorydetail::create($item);
        return redirect('admin/categorydetail');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorydetail $categorydetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorydetail $categorydetail)
    {
        $auth = Auth::user();
        $category = Category::all();
        $categorydt = Categorydetail::all();
        return view('admin/categorydetail/edit', compact('categorydetail', 'category', 'categorydt', 'auth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorydetail $categorydetail)
    {
        $categorydetail->update($request->all());
        return redirect('admin/categorydetail');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorydetail $categorydetail)
    {
        $categorydetail->delete();
        return redirect('admin/categorydetail');
    }
    public function searchcategorydetail(Request $request)
    {
        $categorydetail = Categorydetail::where('name', 'like', '%' . $request->valuesearch . '%')
            ->get();

        $auth = Auth::user();
        return view('admin/categorydetail/index', compact('auth', 'categorydetail'));
    }
}
