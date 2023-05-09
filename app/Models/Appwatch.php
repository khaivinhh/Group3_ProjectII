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
