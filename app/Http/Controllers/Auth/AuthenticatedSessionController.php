<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();


        if(auth()->user()->hasRole([User::ROLE_SUPER_ADMIN,User::ROLE_PATIENT]))
        {
            return response()->json(['status'=>'active','redirect'=>RouteServiceProvider::HOME]);    
        }
        elseif(auth()->user()->hasRole(User::ROLE_CLINIC) && auth()->user()->hospital->status==1  )
        {
              return response()->json(['status'=>'active','redirect'=>RouteServiceProvider::HOME]);    
        }
        elseif(auth()->user()->hasRole(User::ROLE_DOCTOR) && auth()->user()->doctor->status==1  )
        {
            return response()->json(['status'=>'active','redirect'=>RouteServiceProvider::HOME]);  
        }
        elseif(auth()->user()->hasRole(User::ROLE_RECEPTIONIST) && auth()->user()->staff->status==1  )
        {
            return response()->json(['status'=>'active','redirect'=>RouteServiceProvider::HOME]);  
        }
        else
        {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            
            // throw ValidationException::withMessages([
            //     'email' => trans('auth.failed'),
            // ]);
            return response()->json(['status'=>'disabled','redirect'=>'login']);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/login');
    }
}
