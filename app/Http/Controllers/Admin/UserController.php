<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('haha');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Mã hóa mật khẩu
        $password = Hash::make($request->password);

        // Tạo hoặc cập nhật người dùng trong cơ sở dữ liệu
        $admin = User::firstOrCreate(['email' => $request->email], [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'image' => "images/myimg/admin/logo-user-default.png",
        ]);

        if ($admin->wasRecentlyCreated) {
            return response()->json('successfully');
        } else {
            return response()->json('error');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        if ($request->confirmpassword || $request->newpassword) {
            if (!Hash::check($request->curentpassword, $user->password)) {
                return ['notification' => 'password error'];
            } elseif (Hash::check($request->curentpassword, $user->password) && $request->newpassword != $request->confirmpassword) {
                return ['notification' => 'password incorrect'];
            } else {
                $user->password = Hash::make($request->newpassword);
                $user->save();
            }
        } else {

            if ($request->hasFile('newimguser')) {
                $user->name = $request->name;
                $user->email = $request->email;

                $file = $request->file('newimguser');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('images/myimg/admin'), $filename);
                $user->image = 'images/myimg/admin/' . $filename;
            } else {
                $user->name = $request->name;
                $user->email = $request->email;
            }
            $user->save();
            return [
                'name' => $user->name,
                'email' => $user->email,
            ];
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findorfail($id)->delete();
        return redirect('admin/login');
    }
}
