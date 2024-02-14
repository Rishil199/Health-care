<?php

namespace App\Models;

use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;

class DoctorAppointmentDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'patient_id',
        'appointment_date',
        'next_start_time',
        'next_end_time',
        'disease_name',
        'doctor_id',
        'clinic_id',
        'receptionist_id',
        'created_by',
        'time_start',
        'time_end',
        'next_date',
        'prescription',
        'weight',
        'blood_pressure',
        'dietplan',
        'is_complete',
        'deleted_at'
    ];

    protected $casts = [
        'next_date' => 'datetime:Y-m-d',
    ];

    //this doctor belongs to user
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeGetAvailableTimeslotes( $query, $date, $current_time = '' ) {
        
        $user_id = auth()->id();

        $available_time_slots = $query->select(array(
                'id', 'patient_id', 'time_start', 'time_end', 'appointment_date',
            ))->where(array(
                'appointment_date' => $date,
                'created_by' => $user_id,
            ))->get();
           

        $booked_timeslots = [];

        foreach ($available_time_slots as $available) {
            $booked_timeslots[] = $available->time_start . '-' . $available->time_end;
        }

        $booked_timeslots = array_unique($booked_timeslots);
       
        $general_time = GeneralSettings::select(array(
            'start_time', 'end_time', 'duration'
        ))->where(array(
            'user_id' => $user_id,
        ))->first();

        $current_time = now()->toTimeString();

        $start = new DateTime($general_time->start_time ?? '');
        $start_time = $start->format('H:i:s');
        
        $end = new DateTime($general_time->end_time ?? '');
        $end_time = $end->format('H:i:s');
        
        $duration = $general_time->duration ?? 10;
        
       
        
        $all_day_time_slots = array();

        $current_date = \Carbon\Carbon::now()->format('Y-m-d');
        
        while(strtotime($start_time) <= strtotime($end_time)) {
            $start = $start_time;
            $end = date('H:i:s', strtotime("+$duration minutes", strtotime($start_time)));

            $start_time = date('H:i:s', strtotime(" +$duration minutes", strtotime($start_time)));
            
            if ($current_date == $date) {
                if ( ( strtotime($start_time) < strtotime($end_time) ) && ( $current_time < $start_time ) ) {
                    $all_day_time_slots[] = "$start-$end";

                }
            } else {
                if ( ( strtotime($start_time) <= strtotime($end_time) ) ) {
                    $all_day_time_slots[] = "$start-$end";
                }
            }
        }

        return array_values(array_diff($all_day_time_slots, $booked_timeslots));
    }

    public function scopeAppointmentCounts( $query, $where ) {
        return $query->where($where)->get()->count();
    }
}
