<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Category;
use App\Models\Categorydetail;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $image = Image::all();
        return view('admin/image/index', compact('auth','image'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        return view('admin/image/create', compact('auth','categorydetail','color'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('images')){
            $images = $request->file('images');
            foreach($images as $image){
                $filename = time() .''. $image->getClientOriginalName();
                $image->move('images/myimg/image_color',$filename);
                $image = new Image();
                $image->categorydetail_id = $request->categorydetail_id;
                $image->color_id = $request->color_id;
                $image->path = 'images/myimg/image_color/'.$filename;
                $image->save();
            }
        }
        return redirect('admin/image');
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        $auth = Auth::user();
        $categorydetail = Categorydetail::all();
        $color = Color::all();
        return view('admin/image/edit',compact('image','categorydetail','color','auth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        $image->update($request->all());
        return redirect('admin/image');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return redirect('admin/image');
    }
    public function searchimage(Request $request)
    {
        $image = Image::leftJoin('categorydetails', 'images.categorydetail_id', '=', 'categorydetails.id')
            ->select('images.*')
            ->where('categorydetails.name', 'like', '%' . $request->valuesearch . '%')
            ->with('categorydetails')
            ->get();

        $auth = Auth::user();
        return view('admin/image/index', compact('auth', 'image'));
    }
}
