<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','price','description','stripe_plan'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
