<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use PHPUnit\Framework\Constraint\Count;

class CountryManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->user_country = Country::find(session('geo_data_user_country'));
        
        return $next($request);
    }
}
