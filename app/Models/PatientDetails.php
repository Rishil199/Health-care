<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class PatientDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id',
        'doctor_id',
        'patient_number',
        'gender',
        'admit_date',        
        'disease_name',
        'prescription',
        'allergies',
        'illness',
        'exercise',
        'alchohol_consumption',
        'diet',
        'smoke',
        'address',
        'latitude',
        'logitude',
        'height',
        'weight',
        'blood_group',
        'blood_pressure',
        'is_mediclaim_available',
        'relation',
        'relative_name',
        'emergency_contact'

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

   
}
