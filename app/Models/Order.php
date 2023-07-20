<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    const Canceled = 0;
    const Confirmed = 1;
    const Pending = 2;

    use HasFactory;
    protected $fillable=['user_id','total','status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class,'item_order');

    }
}
