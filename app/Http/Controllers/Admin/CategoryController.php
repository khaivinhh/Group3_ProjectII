<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        // return view('admin/category/create', compact('auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $item = $request->all();
        // if ($request->hasFile('photo')) {
        //     $file = $request->file('photo');
        //     $ext = $file->getClientOriginalExtension();
        //     if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
        //         return redirect('/admin/category/create');
        //     }
        //     $imageFile = $file->getClientOriginalName();
        //     $file->move('images/myimg/category/product_iphone',$imageFile);
        // } else {
        //     $imageFile = null;
        // }
        // $item['image'] = 'images/myimg/category/product_iphone/'.$imageFile;
        // Category::create($item);
        // return redirect('admin/category');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
       
    }
}
