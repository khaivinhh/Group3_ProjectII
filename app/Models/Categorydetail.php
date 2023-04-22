<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorydetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'image',
    ];

    public function images(){//primary key
        return $this->hasMany(Image::class,'categorydetail_id');
    }
    public function iphones(){//primary key
        return $this->hasMany(Iphone::class,'categorydetail_id');
    }
    public function macbooks(){//primary key
        return $this->hasMany(Macbook::class,'categorydetail_id');
    }
    public function appwatchs(){//primary key
        return $this->hasMany(Appwatch::class,'categorydetail_id');
    }
    

    public function categories(){//foreign key
        return $this->belongsTo(Category::class,'category_id');
    }
    

}
