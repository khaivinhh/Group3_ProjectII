<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'address',
        'date',
        'status',
        'discount',
        'total',
    ];
    public function orderdetails()//foreign key
    {
        return $this->hasMany(Orderdetail::class,'order_id');
    }
    public function customers() //foreign key
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
}
