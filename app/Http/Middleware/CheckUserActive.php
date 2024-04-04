<?php

namespace App\Http\Middleware;

use Closure;
use session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
    
        if ($user->hasRole(User::ROLE_CLINIC) && !$user->hospital->status || $user->hasRole(User::ROLE_DOCTOR) && !$user->doctor->status ||
            $user->hasRole(User::ROLE_RECEPTIONIST) && !$user->staff->status) {
            
            Auth::guard('web')->logout();
            session()->flash('error_msg', 'Your account has been deativated, Please connect support team!');
            return redirect()->route('login');
        }

        
        return $next($request);
    }
}
