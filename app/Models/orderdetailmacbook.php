<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderdetailmacbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'category_id',
        'product_id',
        'quantity',
        'price',
    ];
   
    public function orders(){//foreign key
        return $this->belongsTo(Order::class,'order_id');
    }
    public function categories(){//foreign key
        return $this->belongsTo(Category::class,'category_id');
    }
    public function macbooks(){//foreign key
        return $this->belongsTo(Macbook::class,'product_id');
    }
}
