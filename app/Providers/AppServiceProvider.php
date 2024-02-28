<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\ClinicDetails;
use App\Models\DoctorDetails;
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceScheme('https');
        
        Schema::defaultStringLength(191);

        Gate::before(function ($user, $ability) {
            return $user->hasRole(User::ROLE_SUPER_ADMIN) ? true : null;
        });


        view()->composer('*', function($view) {
         $user_id = ClinicDetails::select('id','user_id')->where('user_id',auth()->user()?->id)->first();
         $doctors=DoctorDetails::select(array('id','clinic_id','user_id'))->latest()->with('user')->where('clinic_id',$user_id?->id)->get();
        view::share('doctors',$doctors);
        
    });
}
    

        }
    

