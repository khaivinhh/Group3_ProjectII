<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Customer;
use Illuminate\Support\Str;

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
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Carbon\Carbon;


class CustomerinterfaceController extends Controller
{


    public function home()
    {
        $categorydetails = Categorydetail::all();
        $top_rated_products = Comment::selectRaw('product_id, AVG(rate) as avg_rate')
            ->groupBy('product_id')
            ->orderByDesc('avg_rate')
            ->take(9)
            ->get();
        // $new_value = 1;
        // $iphones = Iphone::select('*', DB::raw("$new_value AS new_col"))->take(9)->get();
        return view('frontend/home', compact('categorydetails', 'top_rated_products'));
    }
    public function shop($category_product)
    {
        $count_iphone = count(Iphone::all());
        if ($category_product == 0) {
            return view('frontend/layout_shop/layout', compact('count_iphone'));
        }
        if ($category_product == 1) {
            $iphones = Iphone::inRandomOrder()->paginate(9);
            return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
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

    public function send_mail_contact(Request $request)
    {
        $name = $request->name;
        Mail::send('frontend.sendmail_contact', compact('name'), function ($email) use ($request) {
            $email->to($request->email)->subject('Email from IShopApple');
        });
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


    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function google_callback()
    {
        $user = Socialite::driver('google')->user();

        $customer = Customer::where('email', $user->email)->first();
        if ($customer == null) {
            $customer = new Customer();
            $customer->name = $user->name;
            $customer->email = $user->email;
            $customer->image = $user->avatar;
            $customer->source = 'google';
            $customer->save();
        }
        session(['user' => $customer]);
        return redirect('frontend/profile');
        // dd($user);
    }

    public function create_user(Request $request)
    {
        // $password = Hash::make($request->password);
        $customer = Customer::firstOrCreate(['email' => $request->email], [
            'name' => $request->name,
            'image' => "images/myimg/admin/logo-user-default.png",
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->password,
            'source' => 'register',
        ]);

        if ($customer->wasRecentlyCreated) {
            $name = $request->name;
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
        if (!($request->session()->has('cart')) || $request->session()->get('cart') == null) {
            return view('frontend/cart');
        } else {
            $user = $request->session()->get('user');
            $cart = $request->session()->get('cart');
            return view('frontend/checkout', compact('user', 'cart'));
        }
    }



    public function search_by_name(Request $request)
    {
        $count_iphone = count(Iphone::all());

        $categorydetail = Categorydetail::where('name', 'like', '%' . $request->name . '%')
            ->first();

        if ($categorydetail == null) {
            return view('frontend/shop_iphone', compact('count_iphone'));
        } else {
            if ($categorydetail->category_id == 1) {
                $iphones = Iphone::leftJoin('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                    ->select('iphones.*')
                    ->where('categorydetails.name', '=',  $request->name)
                    ->with('categorydetails')
                    ->paginate(9);
                $iphones->appends(['name' => $request->name]);

                return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
            }
        }
    }



    public function search_price(Request $request)
    {
        $count_iphone = count(Iphone::all());

        if ($request->category == 1) {
            $from = $request->from;
            $to = $request->to;
            if ($request->from == '' || $request->to == '') {
                return redirect('frontend/shop/1');
            }
            $iphones = Iphone::whereBetween('price', [$from, $to])->inRandomOrder()->paginate(9);
            $iphones->appends(['category' => $request->category, 'from' => $request->from, 'to' => $request->to]);
            return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
        }
    }
    public function sort_by(Request $request)
    {
        $count_iphone = count(Iphone::all());

        switch ($request->category) {
            case 1:
                switch ($request->sort_by) {
                    case 1:
                        $iphones = Iphone::join('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                            ->orderBy('categorydetails.name', 'asc')
                            ->select('iphones.*')
                            ->paginate(9);
                        $iphones->appends(['category' => $request->category, 'sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
                    case 2:
                        $iphones = Iphone::join('categorydetails', 'iphones.categorydetail_id', '=', 'categorydetails.id')
                            ->orderBy('categorydetails.name', 'desc')
                            ->select('iphones.*')
                            ->paginate(9);
                        $iphones->appends(['category' => $request->category, 'sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
                    case 3:
                        $iphones = Iphone::select('*')
                            ->orderBy('price', 'asc')
                            ->paginate(9);
                        $iphones->appends(['category' => $request->category, 'sort_by' => $request->sort_by]);

                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
                    case 4:
                        $iphones = Iphone::select('*')
                            ->orderBy('price', 'desc')
                            ->paginate(9);
                        $iphones->appends(['category' => $request->category, 'sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
                    case 5:
                        $iphones = Iphone::select('*')
                            ->orderBy('created_at', 'asc')
                            ->paginate(9);
                        $iphones->appends(['category' => $request->category, 'sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
                    case 6:
                        $iphones = Iphone::select('*')
                            ->orderBy('created_at', 'desc')
                            ->paginate(9);
                        $iphones->appends(['category' => $request->category, 'sort_by' => $request->sort_by]);
                        return view('frontend/shop_iphone', compact('iphones', 'count_iphone'));
                }
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
            ->get()
            ->map(function ($comment) {
                $comment->diffForHumans = $comment->updated_at->diffForHumans();
                return $comment;
            });


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
        $user = $request->session()->get('user');
        $write_review = 'false';
        if (session()->has('user')) {
            $orders = Order::where('customer_id', $user->id)
                ->where('status', 'complete')
                ->get();

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
            $comment_user = Comment::where('category_id', $iphone->category_id)
                ->where('customer_id', $user->id)
                ->where('product_id', $iphone->id)
                ->first();
            if ($comment_user != null) {
                $star_user =  $comment_user->rate;
                $content_user = $comment_user->content;

                return view('frontend/iphone_detail', compact('iphone', 'products_relate', 'comments', 'write_review', 'star_product', 'count_review_product', 'star_user', 'content_user', 'user'));
            }
        }
        // truyền sản phẩm , tất cả comments sản phẩm , sao sản phẩm , số lượt đánh giá của sản phẩm
        return view('frontend/iphone_detail', compact('iphone', 'products_relate', 'comments', 'write_review', 'star_product', 'count_review_product', 'user'));
    }








    public function category_detail($id, $category_id)
    {
        if ($category_id == 1) {
            $categorydetail = Categorydetail::find($id);
            $categorydetails = Categorydetail::all();
            return view('frontend/category_iphone_detail', compact('categorydetail', 'categorydetails'));
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
                    return response()->json(['notification' => 'error']);
                } else {
                    $product = $iphones->first();
                }
            } else {
                $product = Iphone::find($request->product_id);
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
                    $count_cart = count($request->session()->get('cart'));
                    return response()->json(['notification' => 'You have just added a product to your cart', 'count_cart' => $count_cart]);
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

        $count = Discount::where('name', $request->name)
            ->first();

        if ($count != null) {
            if ($count->count > 0) {
                return response()->json(['notification' => 'You have successfully entered ' . $count->value . '% discount code','value'=>$count->value]);
            } else {
                return response()->json(['notification' => 'Expired code']);
            }
        } else {
            return response()->json(['notification' => 'Incorrect discount code']);
        }
    }

    public function place_order(Request $request)
    {
        $request->session()->has('cart');
        $user = $request->session()->get('user');
        $cart_product = $request->session()->get('cart');
        $order = new Order();
        $order->customer_id = $user->id;
        $order->address = $request->address . ' , ' . $request->ward . ' , ' . $request->district . ' , ' . $request->province;
        $order->date = date('Y-m-d H:i:s', time());
        $order->status = 'processing';
        $order->discount_value = $request->discount_value;
        $order->transport_fee = $request->transport_fee;
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



        $request->session()->forget('cart');
    }

    public function add_review(Request $request)
    {
        if ($request->category_id == 1) {

            $user = $request->session()->get('user');
            $comment_user = Comment::where('customer_id', $user->id)
                ->where('category_id', $request->category_id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($comment_user != null) {
                $comment_user->content = $request->content;
                $comment_user->rate = $request->rate;
                $comment_user->save();
                // return ['notification' => $request->rate];
            } else {
                $review = new Comment();
                $review->customer_id = $user->id;
                $review->category_id = $request->category_id;
                $review->product_id = $request->product_id;
                $review->rate = $request->rate;
                $review->content = $request->content;
                $review->save();
                // return ['notification' => 'comment not exist'];
            }
        }
    }


    public function order_status(Request $request)
    {
        $user = $request->session()->get('user');
        $status_product = Order::where('customer_id', $user->id)
            ->where('status', 'processing')
            ->get();

        return view('frontend/order_status', compact('status_product'));
    }


    public function order_history(Request $request)
    {
        $user = $request->session()->get('user');
        $history_product = Order::where('customer_id', $user->id)
            ->where('status', 'complete')
            ->get();
        return view('frontend/order_history', compact('history_product'));
    }



    public function re_order(Request $request, $order_id)
    {
        $products = Orderdetail::where('order_id', $order_id)
            ->get();
        $carts = [];
        foreach ($products as $item) {
            $cartItem = new CartItem(Iphone::findOrFail($item->product_id), $item->quantity);
            $carts[] = $cartItem;
            $request->session()->put('cart', $carts);
        }
        $cart = $request->session()->get('cart');
        return view('frontend/cart', compact('cart'));
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

            if ($customer->source == "register") {
                $customer->name = $request->name;
                $customer->email = $request->email;
                if ($request->hasFile('newimguser')) {
                    $file = $request->file('newimguser');
                    $filename = $file->getClientOriginalName();
                    $file->move(public_path('images/myimg/frontend/customer'), $filename);
                    $customer->image = 'images/myimg/frontend/customer/' . $filename;
                }
            }
            $customer->phone = $request->phone;
            $customer->address = $request->address;


            $customer->save();
            session()->put('user', $customer);

            return [
                'name' => $customer->name,
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
        $account_customers = Customer::where('email', $request->email)
            ->where('source', 'register')
            ->first();
        if ($account_customers == null) {
            return response()->json(['notification' => 'error']);
        } else {
            $name = $account_customers->first_name . ' ' . $account_customers->last_name;
            $new_password = Str::random(8);
            $account_customers->password = $new_password;
            $account_customers->save();
            Mail::send('frontend.recover_password', compact('name', 'new_password'), function ($email) use ($request) {
                $email->to($request->email)->subject('Email from IShopApple');
            });
            return response()->json(['notification' => 'successfully']);
        }
    }



    public function view_cart(Request $request)
    {
        dd($request->session()->get('user'));
    }

    public function delete_cart(Request $request)
    {
        $request->session()->forget('cart_copy');
    }
}
