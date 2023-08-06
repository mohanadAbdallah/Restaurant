<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = ['name','price','slag','category_id','image','restaurant_id','description'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,'category_item');
    }

    public function orders():BelongsToMany
    {
        return $this->belongsToMany(Order::class,'item_order')->withPivot('quantity');
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class)->withPivot(['quantity']);
    }

}
