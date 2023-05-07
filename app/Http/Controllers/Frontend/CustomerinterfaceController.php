<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Customer;
use Illuminate\Support\Str;

use App\Models\Macbook;
use App\Models\Appwatch;
use App\Models\Cart;
use App\Models\Cartdetail;
use App\Models\Category;
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
        $new_value = 1;
        $categorydetails = Categorydetail::all();

        $top_rated_products = Comment::selectRaw('product_id, AVG(rate) as avg_rate')
            ->groupBy('product_id')
            ->orderByDesc('avg_rate')
            ->take(9)
            ->get();
        // $iphones = Iphone::select('*', DB::raw("$new_value AS new_col"))->take(9)->get();
        return view('frontend/home', compact('categorydetails', 'top_rated_products'));
    }
    public function shop($category_product)
    {
        $count_iphone = count(Iphone::all());
        $count_macbook = count(Macbook::all());
        $count_appwatch = count(Appwatch::all());
        if ($category_product == 1) {
            $iphones = Iphone::inRandomOrder()->paginate(9);
            return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
        } elseif ($category_product == 2) {
            return view('frontend/shop_macbook', compact('count_iphone', 'count_macbook', 'count_appwatch'));
        } elseif ($category_product == 3) {
            return view('frontend/shop_appwatch', compact('count_iphone', 'count_macbook', 'count_appwatch'));
        }
    }
    public function about()
    {
        return view('frontend/about');
    }
    public function contact()
    {
        return view('frontend/contact');
    }



    public function myaccount(Request $request)
    {
        // nếu đã đăng nhập chuyển đến trang profile
        if (session()->has('user')) {
            $user = $request->session()->get('user');
            return view('frontend/profile', compact('user'));
        }
        // nếu chưa đăng nhập chuyển đến trang myaccount
        else {
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
        ]);

        if ($customer->wasRecentlyCreated) {
            $name = $request->first_name . ' ' . $request->last_name;
            Mail::send('frontend.sendmail', compact('name'), function ($email) use ($request) {
                $email->to($request->email)->subject('Email from IShopApple');
            });
            return response()->json(['notification' => 'successfully']);
        } else {
            return response()->json(['notification' => 'error']);
        }
    }

    public function signin_user(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $customer = Customer::where('email', $email)->first();
        //$customer && Hash::check($password, $customer->password)
        if ($customer && $customer->password == $password) { //thành công chuyển đến trang profile
            session()->put('user', $customer);
            return response()->json(['notification' => 'successfully']);
        } else { //thất bại chuyển lại trang myaacount
            return response()->json(['notification' => 'error']);
        }
    }

    public function profile(Request $request)
    {
        if (session()->has('user')) {
            $user = $request->session()->get('user');
            return view('frontend/profile', compact('user'));
        } else {
            return redirect('frontend/myaccount');
        }
    }

    public function signout_user(Request $request)
    {
        if (session()->has('user')) {
            session()->forget('user');
            return redirect('frontend/myaccount');
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



    public function search_by_name(Request $request)
    {
        $count_iphone = count(Iphone::all());
        $count_macbook = count(Macbook::all());
        $count_appwatch = count(Appwatch::all());
        $categorydetail = Categorydetail::where('name', 'like', '%' . $request->name . '%')
            ->first();

        if ($categorydetail == '') {
            return view('frontend/layout_shop/layout', compact('count_iphone', 'count_macbook', 'count_appwatch'));
        } else {
            if ($categorydetail->category_id == 1) {
                $iphones = Iphone::leftJoin('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                    ->select('iphones.*')
                    ->where('categorydetails.name', 'like', '%' . $request->name . '%')
                    ->with('categorydetails')
                    ->paginate(9);
                $iphones->appends(['name' => $request->name]);

                return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
            } elseif ($categorydetail->category_id == 2) {
            } elseif ($categorydetail->category_id == 3) {
            }
        }
    }



    public function search_price(Request $request)
    {
        $count_iphone = count(Iphone::all());
        $count_macbook = count(Macbook::all());
        $count_appwatch = count(Appwatch::all());
        if ($request->category == 1) {
            $from = $request->from;
            $to = $request->to;
            if ($request->from == '' || $request->to == '') {
                return redirect('frontend/shop/1');
            }
            $iphones = Iphone::whereBetween('price', [$from, $to])->inRandomOrder()->paginate(9);
            $iphones->appends(['category' => $request->category, 'from' => $request->from, 'to' => $request->to]);
            return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
        } elseif ($request->category == 2) {
            return view('frontend/shop_macbook', compact( 'count_iphone', 'count_macbook', 'count_appwatch'));

        } elseif ($request->category == 3) {
            return view('frontend/shop_appwatch', compact('count_iphone', 'count_macbook', 'count_appwatch'));

        }
    }
    public function sort_by(Request $request)
    {
        $count_iphone = count(Iphone::all());
        $count_macbook = count(Macbook::all());
        $count_appwatch = count(Appwatch::all());
        switch ($request->category) {
            case 1:
                echo $request->sort_by;
                switch ($request->sort_by) {
                    case 1:
                        $iphones = Iphone::join('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                            ->orderBy('categorydetails.name', 'asc')
                            ->select('iphones.*')
                            ->paginate(9);
                        $iphones->appends(['sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
                    case 2:
                        $iphones = Iphone::join('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                            ->orderBy('categorydetails.name', 'desc')
                            ->select('iphones.*')
                            ->paginate(9);
                        $iphones->appends(['sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
                    case 3:
                        $iphones = Iphone::select('*')
                            ->orderBy('price', 'asc')
                            ->paginate(9);
                        $iphones->appends(['sort_by' => $request->sort_by]);

                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
                    case 4:
                        $iphones = Iphone::select('*')
                            ->orderBy('price', 'desc')
                            ->paginate(9);
                        $iphones->appends(['sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
                    case 5:
                        $iphones = Iphone::select('*')
                            ->orderBy('created_at', 'asc')
                            ->paginate(9);
                        $iphones->appends(['sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
                    case 6:
                        $iphones = Iphone::select('*')
                            ->orderBy('created_at', 'desc')
                            ->paginate(9);
                        $iphones->appends(['sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone', 'count_macbook', 'count_appwatch'));
                }
                break;
            case 2:
                echo 'mac';
                break;
            case 3:
                echo 'watch';
                break;
        }
    }


    public function iphone_detail(Request $request, $id)
    {
        // tìm sản phẩm theo id
        $iphone = Iphone::find($id);
        // tìm tất cả comment của sản phẩm 
        $comments = Comment::where('category_id', $iphone->category_id)
            ->where('product_id', $iphone->id)
            ->get();

        // lấy tất cả categorydetail liên quan đến sản phẩm
        $products_relate = Iphone::where('categorydetail_id', $iphone->categorydetail_id)
            ->inRandomOrder()->get();
        // lấy tất cả số sao của sản phẩm
        $stars = 0;
        foreach ($comments as $item) {
            $stars += $item->rate;
        }

        // kiểm tra số lượt đánh giá sản phẩm và tính trung bình cộng
        $count_review_product = count($comments);
        $star_product = 0;
        if ($count_review_product > 0) {
            $star_product = $stars / $count_review_product;
        }

        // kiểm tra người dùng có quyền đánh giá sản phẩm hay chưa
        $name_user = '';
        $write_review = 'false';
        if (session()->has('user')) {
            $user = $request->session()->get('user');
            $orders = Order::where('customer_id', $user->id)
                ->where('status', 'complete')
                ->get();
            $name_user = $user->first_name . ' ' . $user->last_name;
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $orderdetails = Orderdetail::where('order_id', $order->id)
                        ->where('category_id', $iphone->category_id)
                        ->where('product_id', $iphone->id)
                        ->get();
                    if (count($orderdetails) > 0) {
                        $write_review = 'true';
                    }
                }
            }
        }

        // kiểm tra người dùng đã đánh giá sản phẩm này hay chưa
        if (session()->has('user')) {
            $user = $request->session()->get('user');
            $comments_user = Comment::where('category_id', $iphone->category_id)
                ->where('customer_id', $user->id)
                ->where('product_id', $iphone->id)
                ->get();
            if (count($comments_user) > 0) {
                foreach ($comments_user as $item) {
                    $star_user =  $item->rate;
                    $content_user = $item->content;
                }
                return view('frontend/iphone_detail', compact('iphone', 'products_relate', 'comments', 'write_review', 'star_product', 'count_review_product', 'star_user', 'content_user', 'name_user'));
            }
        }


        // truyền sản phẩm , tất cả comments sản phẩm , sao sản phẩm , số lượt đánh giá của sản phẩm
        return view('frontend/iphone_detail', compact('iphone', 'products_relate', 'comments', 'write_review', 'star_product', 'count_review_product', 'name_user'));
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
                ->where('status', 'complete')
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $orderdetails = Orderdetail::where('order_id', $order->id)
                        ->where('category_id', $macbook->category_id)
                        ->where('product_id', $macbook->id)
                        ->get();
                    if (count($orderdetails) > 0) {
                        $check = 'complete';
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
                ->where('status', 'complete')
                ->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $orderdetails = Orderdetail::where('order_id', $order->id)
                        ->where('category_id', $appwatch->category_id)
                        ->where('product_id', $appwatch->id)
                        ->get();
                    if (count($orderdetails) > 0) {
                        $check = 'complete';
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
            $categorydetails = Categorydetail::all();
            return view('frontend/category_iphone_detail', compact('categorydetail', 'categorydetails'));
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
            if (isset($request->color) && isset($request->capacity)) {
                $iphones = Iphone::where('color_id', $request->color)
                    ->where('capacity_id', $request->capacity)
                    ->where('categorydetail_id', $request->categorydetail_id)
                    ->get();
                if (count($iphones) == 0) {
                    return response()->json(['notification' => 'The product is out of stock']);
                } else {
                    $product = $iphones->first();
                }
            } else {
                $product = Iphone::find($request->product_id);
            }
        } elseif ($request->category_id == 2) {
            if (isset($request->color) && isset($request->capacity)) {
                $macbooks = Macbook::where('color_id', $request->color)
                    ->where('capacity_id', $request->capacity)
                    ->where('categorydetail_id', $request->categorydetail_id)
                    ->get();
                if (count($macbooks) == 0) {
                    return response()->json(['notification' => 'The product is out of stock']);
                } else {
                    $product = $macbooks->first();
                }
            } else {
                $product = Macbook::find($request->product_id);
            }
        } elseif ($request->category_id == 3) {
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
                    $count_cart = count($request->session()->get('cart'));
                    return response()->json(['notification' => 'You have just added a product to your cart' , 'count_cart' => $count_cart]);
                }
            }
        }
        // Nếu sản phẩm chưa tồn tại, thêm nó vào giỏ hàng
        $cart[] = $cartItem;
        //luu lai bien session
        $request->session()->put('cart', $cart);
        $count_cart = count($request->session()->get('cart'));
        return response()->json(['notification' => 'You have just added a product to your cart', 'count_cart' => $count_cart]);
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


    public function check_coupon(Request $request)
    {
        if ($request->session()->has('cart')) {
            $user = $request->session()->get('user');
            $cart = $request->session()->get('cart');
            if ($request->name) {
                $discount_code = $request->name;
                $count = Discount::where('name', $request->name)
                    ->value('count');
                $value = Discount::where('name', $request->name)
                    ->value('value');
                if ($value > 0 && $count > 0) {
                    $notification = 'You have successfully entered ' . $value . '% discount code';
                    return view('frontend/checkout', compact('cart', 'user', 'value', 'notification', 'discount_code'));
                } elseif ($value > 0 && $count == 0) {
                    $notification = 'Expired code';
                    return view('frontend/checkout', compact('cart', 'user', 'notification'));
                } else {
                    $notification = 'Incorrect discount code';
                    return view('frontend/checkout', compact('cart', 'user', 'notification'));
                }
            } else {
                return redirect('frontend/checkout');
            }
        }
    }

    public function place_order(Request $request)
    {
        $request->session()->has('cart');
        $user = $request->session()->get('user');
        $cart_product = $request->session()->get('cart');
        $order = new Order();
        $order->customer_id = $user->id;
        $order->address = $request->address;
        $order->date = date('Y-m-d H:i:s', time());
        $order->status = 'process';
        $order->total = $request->total;
        $order->save();

        foreach ($cart_product as $item) {
            if ($item->product->category_id == 1) {
                $orderdetail = new Orderdetail();
                $orderdetail->order_id = $order->id;
                $orderdetail->category_id = $item->product->category_id;
                $orderdetail->product_id = $item->product->id;
                $orderdetail->quantity = $item->quantity;
                $orderdetail->price = $item->product->price * $item->quantity;
                $orderdetail->save();
            } elseif ($item->product->category_id == 2) {
            } elseif ($item->product->category_id == 3) {
            }
        }

        
        session()->put('cart_copy', $cart_product);
        $cart_copy = $request->session()->get('cart_copy');

        $cart_copy['discount_code'] = $request->discount_code;
        session()->put('cart_copy', $cart_copy);


        $request->session()->forget('cart');
    }

    public function add_review(Request $request)
    {

        if ($request->category_id == 1) {

            $user = $request->session()->get('user');
            $comments_user = Comment::where('customer_id', $user->id)
                ->where('category_id', $request->category_id)
                ->where('product_id', $request->product_id)
                ->get();

            if (count($comments_user) > 0) {
                foreach ($comments_user as $item) {
                    $item->rate = $request->rate;
                    $item->content = $request->content;
                    $item->save();
                }
            } else {
                $review = new Comment();
                $review->customer_id = $user->id;
                $review->category_id = $request->category_id;
                $review->product_id = $request->product_id;
                $review->rate = $request->rate;
                $review->content = $request->content;
                $review->save();
                // return ['notification' => 'add comment'];
            }
        } elseif ($request->category_id == 2) {
        } elseif ($request->category_id == 3) {
        }
    }


    public function purchase_history(Request $request)
    {
    }

    public function re_order(Request $request)
    {
    }

    public function order_status(Request $request)
    {
    }

    public function update_profile(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        if ($request->confirmpassword || $request->newpassword) {
            if ($request->curentpassword != $customer->password) {
                return ['notification' => 'password error'];
            } elseif ($request->curentpassword == $customer->password && $request->newpassword != $request->confirmpassword) {
                return ['notification' => 'password incorrect'];
            } else {
                $customer->password = $request->newpassword;
                $customer->save();
            }
        } else {


            if ($request->hasFile('newimguser')) {

                $customer->first_name = $request->first_name;
                $customer->last_name = $request->last_name;
                $customer->email = $request->email;
                $customer->address = $request->address;
                $customer->phone = $request->phone;

                $file = $request->file('newimguser');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('images/myimg/frontend/customer'), $filename);
                $customer->image = 'images/myimg/frontend/customer/' . $filename;
            } else {

                $customer->first_name = $request->first_name;
                $customer->last_name = $request->last_name;
                $customer->email = $request->email;
                $customer->phone = $request->phone;
                $customer->address = $request->address;
            }
            $customer->save();
            session()->put('user', $customer);

            return [
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
            ];
        }
    }
    public function delete_customer($id)
    {
        Customer::findorfail($id)->delete();
        session()->forget('user');

        return view('frontend/myaccount');
    }


    public function recover_password(Request $request)
    {
        // return response()->json(['notification' => $request->email]);
        $account_customers = Customer::where('email', $request->email)->first();
        if ($account_customers == '') {
            return response()->json(['notification' => 'error']);
        } else {
            $name = $account_customers->first_name . ' ' . $account_customers->last_name;
            $new_password = Str::random(8);
            $account_customers->password = $new_password;
            $account_customers->save();
            Mail::send('frontend.recover_password', compact('name','new_password'), function ($email) use ($request) {
                $email->to($request->email)->subject('Email from IShopApple');
            });
            return response()->json(['notification' => 'successfully']);
        }
    }



    public function view_cart(Request $request)
    {
        dd($request->session()->get('cart_copy'));
    }

    public function delete_cart(Request $request)
    {
        $request->session()->forget('cart_copy');
    }
}
