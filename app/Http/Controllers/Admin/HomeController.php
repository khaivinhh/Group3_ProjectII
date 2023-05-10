<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Categorydetail;
use App\Models\Iphone;
use App\Models\Cart;
use App\Models\Cartdetail;
use App\Models\Discount;
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
        $orders = Order::all();
        return view('admin/dashboard', compact('auth', 'orders'));
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
        return view('admin/editprofile', compact('auth', 'createdAt', 'updatedAt'));
    }

    public function confirm_order(Request $request, $order_id)
    {


        $order = Order::findOrFail($order_id);
        $order->status = 'complete';
        $order->save();


        $discount = Discount::where('name', $order->discount)->first();
        if ($discount) {
            $discount->count -= 1;
            $discount->save();
        }

        $order_detail = $order->orderdetails;


        $cart = new Cart();
        $cart->customer_id = $order->customer_id;;
        $cart->save();

        foreach ($order_detail as $item) {
            if ($item->category_id == 1) {
                $cartdetail = new Cartdetail();
                $cartdetail->cart_id = $cart->id;
                $cartdetail->category_id = $item->category_id;
                $cartdetail->product_id = $item->product_id;
                $cartdetail->quantity = $item->quantity;
                $cartdetail->save();
            } elseif ($item->product->category_id == 2) {
            } elseif ($item->product->category_id == 3) {
            }

            $iphone = Iphone::where('id', $item->product_id)
                ->where('category_id', $item->category_id)
                ->first();
           
            if ($iphone) {
                $iphone->quantity -= $item->quantity;
                $iphone->save();
            }
           
        }
        $request->session()->forget('cart_copy');
        return redirect('admin/order');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return view('admin/login');
    }
    public function test()
    {
        $category = Category::all();
        return view('test', compact('category'));
    }
}
