<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class CheckUserRole
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
        if(Auth::check())
        {
            $prefix = $request->route()->getPrefix();
            
            if($prefix == 'admin')
            {
                if(Auth::user()->isUser())
                {
                    return redirect()->route('user.dashboard');
                }
            }else if($prefix == 'user')
            {
                if(Auth::user()->isAdmin())
                {
                    return redirect()->route('admin.dashboard');
                }
            }
        }
        
        return $next($request);
    }
}
