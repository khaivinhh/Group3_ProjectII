<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];
    public function comments(){//primary key
        return $this->hasMany(Comment::class,'category_id');
    }
    public function cartdetails(){//primary key
        return $this->hasMany(Cartdetail::class,'category_id');
    }
    public function orderdetails(){//primary key
        return $this->hasMany(Orderdetail::class,'category_id');
    }
    public function categorydetails(){//primary key
        return $this->hasMany(Categorydetail::class,'category_id');
    }



    public function iphones(){//primary key
        return $this->hasMany(Iphone::class,'category_id');
    }
    public function macbooks(){//primary key
        return $this->hasMany(Macbook::class,'category_id');
    }
    public function appwatchs(){//primary key
        return $this->hasMany(Appwatch::class,'category_id');
    }
}
