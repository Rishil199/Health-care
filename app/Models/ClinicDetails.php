<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ClinicDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id',
        'address',
        'status',
        'is_main_branch',
        'latitude',
        'logitude',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}   
