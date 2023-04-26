<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];
    public function iphons(){//primary key
        return $this->hasMany(Iphone::class,'color_id');
    }
    public function macbooks(){//primary key
        return $this->hasMany(Macbook::class,'color_id');
    }
    public function appwatchs(){//primary key
        return $this->hasMany(Appwatch::class,'color_id');
    }
    public function images(){//primary key
        return $this->hasMany(Image::class,'color_id');
    }
}
