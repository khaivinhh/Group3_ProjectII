<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Categorydetail;
use App\Models\Iphone;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }


    public function checklogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json('successfully');
        };
        return response()->json('error');
    }


    public function dashboard()
    {
        $auth = Auth::user();
        // return view('admin/dashboard', ['auth' => $auth]);
        return view('admin/dashboard', compact('auth'));
    }


    public function searchname(Request $request)
    {
        $name = $request->name;
        $product = Iphone::where('title', 'like', '%' . $name . '%')->get();
        return view('examp/index', compact('examp'));
    }


    public function editprofile()
    {
        $auth = Auth::user();
        $createdAt = $auth->created_at->format('d/m/Y H:i:s');
        $updatedAt = $auth->updated_at->format('d/m/Y H:i:s');
        // return view('admin/editprofile', ['auth' => $auth, 'createdAt' => $createdAt, 'updatedAt' => $updatedAt]);
        return view('admin/editprofile', compact('auth','createdAt','updatedAt'));
    }

    public function confirm_order($order_id){
        $order = Order::findOrFail($order_id); // Tìm đơn hàng tương ứng với order_id
        $order->status = 'success'; // Cập nhật giá trị status
        $order->save(); // Lưu thay đổi vào cơ sở dữ liệu
        return redirect('admin/order');
    }
    
    public function logout()
    {
        Auth::guard('web')->logout();
        return view('admin/login');
    }
    public function test(){
        $category = Category::all();
        return view('test',compact('category'));
    }
}
