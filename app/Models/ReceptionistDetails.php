<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceptionistDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id',
        'experience',
        'status',
        'gender',
        'qualification',
        'latitude',
        'logitude',

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
