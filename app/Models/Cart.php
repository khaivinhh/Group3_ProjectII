<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
    ];
    public function cartdetails(){//primary key
        return $this->hasMany(Cartdetail::class,'cart_id');
    }
    public function customers(){//foreign key
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
