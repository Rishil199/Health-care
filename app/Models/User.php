<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\CustomResetPasswordNotification;
use App\Models\DoctorDetails;
// use Spatie\Sluggable\HasSlug;
// use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public const ROLE_SUPER_ADMIN = 'Super Admin';
    public const ROLE_CLINIC = 'Hospital';
    public const ROLE_DOCTOR = 'Doctor';
    public const ROLE_RECEPTIONIST = 'Staff';
    public const ROLE_PATIENT = 'Patient';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'phone_no',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return trim(ucwords($this->first_name . ' ' . $this->last_name));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $authuser=Auth::user();
        $this->notify(new CustomResetPasswordNotification($token,$authuser));
    }
    

    //  public function getSlugOptions() : SlugOptions
    // {
    //     return SlugOptions::create()
    //         ->generateSlugsFrom('first_name')
    //         ->saveSlugsTo('slug');
    // }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    // public function doctor():HasOne
    // {
    //     return $this->hasOne(DoctorDetails::class);
    // }
}
