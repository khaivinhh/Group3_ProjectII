<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appwatch;
use App\Models\Category;
use App\Models\Categorydetail;
use App\Models\Iphone;
use App\Models\Cart;
use App\Models\Cartdetail;
use App\Models\Discount;
use App\Models\Macbook;
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
        return view('admin/dashboard', compact('auth','orders'));

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



        $cart_product = $request->session()->get('cart_copy');

        if (isset($cart_product['discount_code'])) {
            $discount = Discount::where('name', $cart_product['discount_code'])->first();
            if ($discount) {
                $discount->count -= 1;
                $discount->save();
            }
        }


        unset($cart_product['discount_code']);
        session()->put('cart_copy', $cart_product);


        $cart = new Cart();
        $cart->customer_id = $order->customer_id;;
        $cart->save();

        foreach ($cart_product as $item) {
            if ($item->product->category_id == 1) {
                $cartdetail = new Cartdetail();
                $cartdetail->cart_id = $cart->id;
                $cartdetail->category_id = $item->product->category_id;
                $cartdetail->product_id = $item->product->id;
                $cartdetail->quantity = $item->quantity;
                $cartdetail->save();
            } elseif ($item->product->category_id == 2) {
            } elseif ($item->product->category_id == 3) {
            }

            $iphone = Iphone::where('id', $item->product->id)
                ->where('category_id', $item->product->category_id)
                ->first();
            $macbook = Macbook::where('id', $item->product->id)
                ->where('category_id', $item->product->category_id)
                ->first();
            $appwatch = Appwatch::where('id', $item->product->id)
                ->where('category_id', $item->product->category_id)
                ->first();
            if ($iphone) {
                $iphone->quantity -= $item->quantity;
                $iphone->save();
            }
            if ($macbook) {

                $macbook->quantity -= $item->quantity;
                $macbook->save();
            }
            if ($appwatch) {

                $appwatch->quantity -= $item->quantity;
                $appwatch->save();
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
