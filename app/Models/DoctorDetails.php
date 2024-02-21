<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DoctorAppointmentDetails;

class DoctorDetails extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'clinic_id',
        'user_id',
        'address',
        'expertice',
        'experience',
        'status',
        'latitude',
        'logitude',
        // 'receptionist_id',

    ];

    //this doctor belongs to user
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function appointments(){
        return $this->hasMany(DoctorAppointmentDetails::class);
    }
}
