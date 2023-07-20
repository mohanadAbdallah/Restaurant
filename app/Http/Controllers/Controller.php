<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $doesntHaveRoles = true;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $this->doesntHaveRoles = $request->user()
                ? $request->user()->roles()->doesntExist()
                : true;
            view()->share('doesntHaveRoles', $this->doesntHaveRoles);

            return $next($request);
        });

    }
}
