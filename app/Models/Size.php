<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];
    public function iphones(){//primary key
        return $this->hasMany(Iphone::class,'capacity_id');
    }
    public function mackbooks(){//primary key
        return $this->hasMany(Macbook::class,'capacity_id');
    }
    public function appwatchs(){//primary key
        return $this->hasMany(Appwatch::class,'id_capacity_id');
    }
}
