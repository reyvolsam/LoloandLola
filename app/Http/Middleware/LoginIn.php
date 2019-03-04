<?php

namespace App\Http\Middleware;

use Closure;
use App\Session;

class LoginIn
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
            date_default_timezone_set('America/Mexico_City');

            if( !\Auth::check() ){
                if($request->ajax()){
                    $res = ['status' => false, 'msg' => 'La Sesion ha terminado.'];
                    return response()->json($res);
                }
                return redirect('login');
            }
        return $next($request);
    }
}
