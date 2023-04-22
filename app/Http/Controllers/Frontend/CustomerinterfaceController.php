<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Customer;

use App\Models\Macbook;
use App\Models\Appwatch;
use App\Models\Categorydetail;
use App\Models\Comment;
use App\Models\Iphone;
use App\Models\Order;
use App\Models\Orderdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class CustomerinterfaceController extends Controller
{
    public function home()
    {
        $categorydetail = Categorydetail::all();
        $iphone = Iphone::all();
        $macbook = Macbook::all();
        $appwatch = Appwatch::all();
        return view('frontend/home', compact('categorydetail', 'iphone', 'macbook', 'appwatch'));
    }
    public function shop()
    {
        $iphone = Iphone::all();
        $macbook = Macbook::all();
        $appwatch = Appwatch::all();
        return view('frontend/shop', compact('iphone', 'macbook','appwatch'));
    }
    public function about()
    {
        return view('frontend/about');
    }
    public function contact()
    {
        return view('frontend/contact');
    }



    public function myaccount()
    {
        if (session()->has('user')) {
            return view('frontend/profile');
        } else {
            return view('frontend/myaccount');
        }
    }

    public function create_user(Request $request)
    {
        // $password = Hash::make($request->password);

        $customer = Customer::firstOrCreate(['email' => $request->email], [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'image' => "images/myimg/admin/logo-user-default.png",
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->password,
            // 'password' => $password,
        ]);

        if ($customer->wasRecentlyCreated) {
            $name = $request->first_name . ' ' . $request->last_name;


            Mail::send('frontend.sendmail', compact('name'), function ($email) use ($request) {
                $email->to($request->email)->subject('Email from IShopApple');
            });

            return redirect('frontend/myaccount');
        } else {
            return redirect('frontend/create_user');
        }
    }

    public function signin_user(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $customer = Customer::where('email', $email)->first();
        //$customer && Hash::check($password, $customer->password)
        if ($customer && $customer->password == $password) { //sucess
            session()->put('user', $customer);
            return view('frontend/profile');
        } else { //error
            return view('frontend/myaccount');
        }
    }

    public function signout_user(Request $request)
    {
        if (session()->has('user')) {
            session()->forget('user');
            return view('frontend/myaccount');
        }
    }



    public function cart(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            return view('frontend/cart', compact('cart'));
        }
        return view('frontend/cart');
    }


    public function checkout(Request $request)
    {
        if (session()->has('user')) {
            $user = $request->session()->get('user');
            if ($request->session()->has('cart')) {
                $cart = $request->session()->get('cart');
            }
            return view('frontend/checkout', compact('user','cart'));
        } else {
            return view('frontend/myaccount');
        }
    }




    ///////////////////
    public function iphone_detail(Request $request , $id)
    {
        $iphone = Iphone::find($id);
        $comments = Comment::where('category_id',$iphone->category_id)
                    ->where('product_id',$iphone->id)
                    ->get();
        $check = 'fail';

        if (session()->has('user')) {
            $user = $request->session()->get('user');
            $orders = Order::where('customer_id',$user->id)
            ->where('status','success')
            ->get();

            if(count($orders) > 0){
                foreach($orders as $order){
                    $orderdetails = Orderdetail::where('order_id',$order->id)
                    ->where('category_id',$iphone->category_id)
                    ->where('product_id',$iphone->id)
                    ->get();
                    if(count($orderdetails) > 0){
                        $check = 'success';
    
                    }
                }
            }
        }
        return view('frontend/iphone_detail', compact('iphone','comments','check'));
    }
    public function macbook_detail($id)
    {
        $macbook = Macbook::find($id);
        return view('frontend/macbook_detail', compact('macbook'));
    }
    public function appwatch_detail($id)
    {
        $appwatch = Appwatch::find($id);
        return view('frontend/appwatch_detail', compact('appwatch'));
    }

    public function category_detail($categorydetail_id,$categogy)
    {
        if ($categogy == 'iphone') {
            $categorydetail = Categorydetail::find($categorydetail_id);
            return view('frontend/category_iphone_detail', compact('categorydetail'));
        } elseif ($categogy == 'macbook') {
            $categorydetail = Categorydetail::find($categorydetail_id);
            return view('frontend/category_macbook_detail');
        } elseif ($categogy == 'appwatch') {
            $categorydetail = Categorydetail::find($categorydetail_id);
            return view('frontend/category_appwatch_detail');
        }
    }




    public function add_to_cart(Request $request)
    {

        if ($request->categoryname == 'iphone') {
            if (isset($request->color) && isset($request->ram) && isset($request->capacity)) {
                $products = Iphone::where('color_id', $request->color)
                    ->where('ram_id', $request->ram)
                    ->where('capacity_id', $request->capacity)
                    ->where('categorydetail_id', $request->categorydetail_id)
                    ->get();
                if (count($products) == 0) {
                    return response()->json(['info' => 'san pham dang het hang']);
                } else {
                    $product = $products->first();

                }
            } else {
                $product = Iphone::find($request->id);
            }
        } elseif ($request->categoryname == 'macbook') {
            $product = Macbook::find($request->id);
        } elseif ($request->categoryname == 'appwatch') {
            $product = Appwatch::find($request->id);
        }


        $quantity = $request->quantity;
        $cartItem = new CartItem($product, $quantity);


        $cart = [];
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            foreach ($cart as $item) {
                if ($item->product->id == $cartItem->product->id && $item->product->id_category == $cartItem->product->id_category) {
                    // Nếu sản phẩm đã tồn tại, cộng dồn quantity vào sản phẩm đó
                    $item->quantity += $cartItem->quantity;
                    $request->session()->put('cart', $cart);
                    return response()->json(['info' => 'Add To Cart Successful !']);
                }
            }
        }
        // Nếu sản phẩm chưa tồn tại, thêm nó vào giỏ hàng
        $cart[] = $cartItem;
        //luu lai bien session
        $request->session()->put('cart', $cart);
        return response()->json(['info' => 'Add To Cart Successful !']);
    }


    public function update_cart(Request $request)
    {
        $quantity = $request->qty;
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            foreach($cart as $index => $item){
                $item->quantity = $quantity[$index];
            }
            $request->session()->put('cart', $cart);
            $cart = $request->session()->get('cart');
            return redirect('frontend/cart');
        }
    }



    public function remove_cart(Request $request, $index)
    {
        $cart = session()->get('cart');
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart', $cart);
        }
        return redirect('frontend/cart');
    }
   
    public function place_order(Request $request){
        if ($request->session()->has('cart')) {
            $user = $request->session()->get('user');
            $cart = $request->session()->get('cart');
            $order = new Order();
            $order->customer_id = $user->id;
            $order->image = $user->image;
            $order->address = $request->address;
            $order->date = date('Y-m-d H:i:s', time());
            $order->status = 'processing';
            $total = 0;
            foreach($cart as $item){
                $total += $item->product->price*$item->quantity;
            }
            $order->total = $total;
            $order->save();

            foreach($cart as $item){
                $orderdetail = new Orderdetail();
                $orderdetail->order_id = $order->id;
                $orderdetail->category_id = $item->product->category_id;
                $orderdetail->product_id = $item->product->id;
                $orderdetail->quantity = $item->quantity;
                $orderdetail->price = $item->product->price*$item->quantity;
                $orderdetail->save();
            }
            // su li thanh cong thi xoa cart
            $request->session()->forget('cart');
            return redirect('frontend/cart');
        }
        else{
            return redirect('frontend/cart');
        }
    }





    public function view_cart(Request $request)
    {
        dd($request->session()->get('cart'));
    }

    public function delete_cart(Request $request)
    {
        $request->session()->forget('cart');
    }
}
