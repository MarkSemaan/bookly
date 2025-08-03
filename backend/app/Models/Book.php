<?php

namespace App\Models;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'published_year',
        'description',
        'price',
        'stock',
        'sold',
        'image',
        'is_available',
        'rating'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

}
