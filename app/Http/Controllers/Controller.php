<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $doesntHaveRoles = true;
    public $cartCount = 0;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $this->doesntHaveRoles = $request->user()
                ? $request->user()->roles()->doesntExist()
                : true;
            view()->share('doesntHaveRoles', $this->doesntHaveRoles);

            return $next($request);
        });

        $this->middleware(function ($request, $next) {
            if (auth()->user()){
                $cart = Cart::withCount('items')->where('user_id',auth()->id())->first();
                if ($cart){
                    $this->cartCount = $cart->items_count;
                }
                view()->share('cartCount', $this->cartCount);
            }

            return $next($request);
        });

    }
}
