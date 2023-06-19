<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIranianMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $target_country=["Iran"];
        if(in_array($request->route()->parameter('user.attributes.country'),$target_country)==false){
           // return abort(403);
            return redirect("/step5")
            ->withErrors(
                [
                    'msg' => "The user: ".$request->route()->parameter('user.name')." with id:".$request->route()->parameter('user.id')." wasn\'t in iran! "
                ]
            );
        }
       
        return $next($request);
    }
}
