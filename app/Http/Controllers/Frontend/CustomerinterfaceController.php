<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Customer;

use App\Models\Macbook;
use App\Models\Appwatch;
use App\Models\Categorydetail;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Iphone;
use App\Models\Order;
use App\Models\Orderdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
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
        return view('frontend/shop', compact('iphone', 'macbook', 'appwatch'));
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
        if (!($request->session()->has('user'))) {
            return view('frontend/myaccount');
        } elseif (!($request->session()->has('cart'))) {
            return view('frontend/cart');
        } else {
            $user = $request->session()->get('user');
            $cart = $request->session()->get('cart');
            if ($request->session()->get('cart') == null) {
                return view('frontend/cart');
            }
            return view('frontend/checkout', compact('user', 'cart'));
        }
    }




    ///////////////////
    public function iphone_detail(Request $request, $id)
    {
        $iphone = Iphone::find($id);
        $comments = Comment::where('category_id', $iphone->category_id)
            ->where('product_id', $iphone->id)
            ->get();
        $check = 'fail';

        if (session()->has('user')) {
            $user = $request->session()->get('user');
            $orders = Order::where('customer_id', $user->id)
                ->where('status', 'success')
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $orderdetails = Orderdetail::where('order_id', $order->id)
                        ->where('category_id', $iphone->category_id)
                        ->where('product_id', $iphone->id)
                        ->get();
                    if (count($orderdetails) > 0) {
                        $check = 'success';
                    }
                }
            }
        }
        return view('frontend/iphone_detail', compact('iphone', 'comments', 'check'));
    }
    public function macbook_detail(Request $request, $id)
    {
        $macbook = Macbook::find($id);
        $comments = Comment::where('category_id', $macbook->category_id)
            ->where('product_id', $macbook->id)
            ->get();
        $check = 'fail';

        if (session()->has('user')) {
            $user = $request->session()->get('user');
            $orders = Order::where('customer_id', $user->id)
                ->where('status', 'success')
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $orderdetails = Orderdetail::where('order_id', $order->id)
                        ->where('category_id', $macbook->category_id)
                        ->where('product_id', $macbook->id)
                        ->get();
                    if (count($orderdetails) > 0) {
                        $check = 'success';
                    }
                }
            }
        }
        return view('frontend/macbook_detail', compact('macbook', 'comments', 'check'));
    }



    public function appwatch_detail(Request $request, $id)
    {
        $appwatch = Appwatch::find($id);
        $comments = Comment::where('category_id', $appwatch->category_id)
            ->where('product_id', $appwatch->id)
            ->get();
        $check = 'fail';

        if (session()->has('user')) {
            $user = $request->session()->get('user');
            $orders = Order::where('customer_id', $user->id)
                ->where('status', 'success')
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $orderdetails = Orderdetail::where('order_id', $order->id)
                        ->where('category_id', $appwatch->category_id)
                        ->where('product_id', $appwatch->id)
                        ->get();
                    if (count($orderdetails) > 0) {
                        $check = 'success';
                    }
                }
            }
        }
        return view('frontend/appwatch_detail', compact('appwatch', 'comments', 'check'));
    }




    public function category_detail($id, $category_id)
    {
        if ($category_id == 1) {
            $categorydetail = Categorydetail::find($id);
            return view('frontend/category_iphone_detail', compact('categorydetail'));
        } elseif ($category_id == 2) {
            $categorydetail = Categorydetail::find($id);
            return view('frontend/category_macbook_detail', compact('categorydetail'));
        } elseif ($category_id == 3) {
            $categorydetail = Categorydetail::find($id);
            return view('frontend/category_appwatch_detail', compact('categorydetail'));
        }
    }




    public function add_to_cart(Request $request)
    {

        if ($request->category_id == 1) {
            if (isset($request->color) && isset($request->ram) && isset($request->capacity)) {
                $iphones = Iphone::where('color_id', $request->color)
                    ->where('ram_id', $request->ram)
                    ->where('capacity_id', $request->capacity)
                    ->where('categorydetail_id', $request->categorydetail_id)
                    ->get();
                if (count($iphones) == 0) {
                    return response()->json(['info' => 'san pham dang het hang']);
                } else {
                    $product = $iphones->first();
                }
            } else {
                $product = Iphone::find($request->product_id);
            }
        } elseif ($request->category_id == 2) {
            if (isset($request->color) && isset($request->ram) && isset($request->capacity)) {
                $macbooks = Macbook::where('color_id', $request->color)
                    ->where('ram_id', $request->ram)
                    ->where('capacity_id', $request->capacity)
                    ->where('categorydetail_id', $request->categorydetail_id)
                    ->get();
                if (count($macbooks) == 0) {
                    return response()->json(['info' => 'san pham dang het hang']);
                } else {
                    $product = $macbooks->first();
                }
            } else {
                $product = Macbook::find($request->product_id);
            }
        } elseif ($request->category_id == 3) {
            if (isset($request->color) && isset($request->size) && isset($request->capacity)) {
                $appwatches = Appwatch::where('color_id', $request->color)
                    ->where('size_id', $request->size)
                    ->where('capacity_id', $request->capacity)
                    ->where('categorydetail_id', $request->categorydetail_id)
                    ->get();
                if (count($appwatches) == 0) {
                    return response()->json(['info' => 'san pham dang het hang']);
                } else {
                    $product = $appwatches->first();
                }
            } else {
                $product = Appwatch::find($request->product_id);
            }
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
            $count = count($cart);
         
            $index = 0;
            foreach ($cart as $item) {
                echo $item->quantity = $quantity[$index];
                $index++;
            }

            $request->session()->put('cart', $cart);
            $cart = $request->session()->get('cart');
            return redirect('frontend/cart');
        }
    }



    public function remove_cart(Request $request, $index)
    {
        echo $index;
        $cart = session()->get('cart');
        unset($cart[$index]);
        session()->put('cart', $cart);
        return redirect('frontend/cart');
    }


    public function check_coupon(Request $request, $total)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $value = Discount::where('name', $request->name)
                ->value('value');
            $newtotal = $total - $total * (floatval(str_replace('%', '', $value)) / 100);
            if ($newtotal) {
                return view('frontend/cart', compact('cart', 'newtotal'));
            } else {
                return view('frontend/cart');
            }
        }
        return view('frontend/cart');
    }

    public function place_order(Request $request)
    {
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
            foreach ($cart as $item) {
                $total += $item->product->price * $item->quantity;
            }
            $order->total = $total;
            $order->save();

            foreach ($cart as $item) {
                $orderdetail = new Orderdetail();
                $orderdetail->order_id = $order->id;
                $orderdetail->category_id = $item->product->category_id;
                $orderdetail->product_id = $item->product->id;
                $orderdetail->quantity = $item->quantity;
                $orderdetail->price = $item->product->price * $item->quantity;
                $orderdetail->save();
            }
            // su li thanh cong thi xoa cart
            $request->session()->forget('cart');
            return redirect('frontend/cart');
        } else {
            return redirect('frontend/cart');
        }
    }

    public function add_review(Request $request)
    {
        $user = $request->session()->get('user');
        $review = new Comment();
        $review->customer_id = $user->id;
        $review->category_id = $request->category_id;
        $review->product_id = $request->product_id;
        $review->rate = $request->rate;
        $review->content = $request->content;
        $review->save();
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
