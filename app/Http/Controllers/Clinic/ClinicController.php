<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorDetails;
use App\Models\ClinicDetails;
use App\Models\PatientDetails;
use App\Models\ReceptionistDetails;
use Spatie\Permission\Models\Role;

class ClinicController extends Controller
{
    public function dashboard() {
        $clinicCount = count(ClinicDetails::get());
        $receptionistCount = count(ReceptionistDetails::get());

        $doctors = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
            ))->latest()->with('user')->get();

        $patients = PatientDetails::select(array(
                'id','user_id','created_at'
            ))->latest()->with('user')->get();

        $this->data = array(
            'title' => 'Dashboard',
            'clinicCount' => $clinicCount,
            'patients' => $patients,
            'receptionistCount' => $receptionistCount,
            'doctors' => $doctors
        ); 
        return view('clinic.dashboard',$this->data);
    }

}
