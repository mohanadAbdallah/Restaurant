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


    protected $fillable = ['name','price','slag','category_id','image','description'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,'category_item');
    }
}
