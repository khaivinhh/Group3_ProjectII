<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'categorydetail_id',
        'color_id',
        'path',
    ];
    public function categorydetails(){//primary key
        return $this->belongsTo(Categorydetail::class,'categorydetail_id');
    }
    public function colors(){//primary key
        return $this->belongsTo(Color::class,'color_id');
    }
}
