<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Carbon\Carbon;
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

    protected $fillable = ['user_id', 'total', 'status','number'];

    protected $appends = ['order_status','status_badge'];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_order')->withPivot('quantity');

    }

    public function getOrderStatusAttribute(): ?string

    {
        if ($this->status == self::Confirmed) {
            return 'Confirmed';
        } elseif ($this->status == 2) {
            return 'Pending';
        } elseif ($this->status == 0) {
            return 'Canceled';
        } else return null;

    }

    public function getStatusBadgeAttribute(): ?string
    {
        if ($this->status == 0) {
            return 'badge  badge-danger';
        } elseif ($this->status == 1) {
            return 'badge  badge-success';

        } elseif ($this->status == 2) {
            return 'badge  badge-secondary';
        } else
            return null;
    }

    public static function booted()
    {
        static::creating(function(Order $order){
            $order->number = Order::getNextOrderNumber();
        });
    }
    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at',$year)->max('number');

        if($number){
            return $number + 1;
        }

        return $year. '0001';

    }

}
