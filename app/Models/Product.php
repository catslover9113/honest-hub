<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'category_id',
    ];

    
    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}
public function reviews()
{
    return $this->hasMany(Review::class, 'products_id');
}

}