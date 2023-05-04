<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appwatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'categorydetail_id',
        'category_id',
        'size_id',
        'color_id',
        'capacity_id',
        'image',    
        'price',
        'quantity',
        'description',
    ];
   

    public function comments()//primary key
    {
        return $this->hasMany(commentappwatch::class,'product_id');
    }
    public function cartdetails()//primary key
    {
        return $this->hasMany(cartdetailappwatch::class,'product_id');
    }
    public function orderdetails()//primary key
    {
        return $this->hasMany(orderdetailappwatch::class,'product_id');
    }

    public function categories()//foreign key
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function sizes()//foreign key
    {
        return $this->belongsTo(Size::class,'size_id');
    }
    public function colors()//foreign key
    {
        return $this->belongsTo(Color::class,'color_id');
    }
    public function capacities()//foreign key
    {
        return $this->belongsTo(Capacity::class,'capacity_id');
    }
    public function categorydetails()//foreign key
    {
        return $this->belongsTo(Categorydetail::class,'categorydetail_id');
    }
}
