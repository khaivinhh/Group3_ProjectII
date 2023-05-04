<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commentmacbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'category_id',
        'product_id',
        'content',
    ];
    public function customers(){//primary key
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function categories(){//primary key
        return $this->belongsTo(Category::class,'category_id');
    }
    public function macbooks(){//primary key
        return $this->belongsTo(Macbook::class,'product_id');
    }
}
