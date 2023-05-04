<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cartdetailmacbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'category_id',
        'product_id',
        'quantity',
    ];
   
    public function carts(){//foreign key
        return $this->belongsTo(Cart::class,'cart_id');
    }
    public function categories(){//foreign key
        return $this->belongsTo(Category::class,'product_id');
    }
    public function macbooks(){//foreign key
        return $this->belongsTo(Macbook::class,'product_id');
    }
}
