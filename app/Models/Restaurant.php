<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','phone','address','description','user_id','image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

}
