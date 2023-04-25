<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $customer = Customer::all();
        // return view('admin/customer/index', ['auth' => $auth ,'customer' => $customer]);
        return view('admin/customer/index', compact('auth', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        // return view('admin/customer/create', ['auth' => $auth]);
        return view('admin/customer/create', compact('auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return response()->json('successfully');
        } else {
            return response()->json('error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $auth = Auth::user();

        return view('admin/customer/edit', compact('customer', 'auth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect('admin/customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect('admin/customer');
    }
    public function searchcustomer(Request $request)
    {
        $fullname = $request->valuesearch;
        $customer = Customer::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $fullname . '%')
             ->get();


        $auth = Auth::user();
        return view('admin/customer/index', compact('auth', 'customer'));
    }
}
