<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GeneralSettings;
use App\Models\DoctorDetails;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\DoctorAppointmentDetails;
use App\Models\PatientDetails;
use App\Models\ClinicDetails;
use App\Models\ReceptionistDetails;
use Spatie\Permission\Models\Role;
use Auth;
use DateTime;
use DataTables;
use Carbon\Carbon;
use App\Mail\PrescriptionMail;
use Illuminate\Support\Facades\Mail;

class DoctorController extends Controller
{
    /**
     * Use: Call main dashboard for doctor
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function dashboard() {
        //   dd(Auth::check());
        $clinicCount = ClinicDetails::get()->count();
        
        $receptionistCount = ReceptionistDetails::get()->count();
        
        $doctors = DoctorDetails::select(array(
                'id','user_id','patient_id','clinic_id','status','created_at'
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
        
        return view('doctor.dashboard',$this->data);
    }

     /**
     * Use: Appointments listing 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function appointments(Request $request) {
        $user_id = auth()->id();
        // dd($user_id);
        $clinic_details = ClinicDetails::select('id','user_id')->where('user_id',$user_id)->first();
        // dd($clinic_details);
       $selected_date=$request->appointment_date;

        $doctors = DoctorDetails::select('id','user_id')->where('user_id',Auth::user()->id)->get();
        if(Auth::user()->hasRole(['Hospital'])) {
            // dd('dd');
            $doctors = DoctorDetails::select('id','user_id')->where('clinic_id',$clinic_details->id)->get();
        }
  

        if ( $request->ajax() ) {
            
            if ( $request->load_view == 'true' ) {
                
  
                // dd($doctors);

                $current_time = now()->toTimeString();
                
                $available_slots = DoctorAppointmentDetails::getAvailableTimeslotes( $request->appointment_date, $request->event_name );

                $clinic_details = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();

                if(Auth::user()->hasRole(['Hospital'])){
                
                    $receptionist_details = ReceptionistDetails::select('id','user_id','clinic_id')->where('clinic_id',Auth::user()->id)->first();
                }

                if(Auth::user()->hasRole(['Receptionist'])){
                    $receptionist_details = ReceptionistDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
                //    dd($receptionist_details);
                }

                if(Auth::user()->hasRole(['Doctor'])){
                    $user_id = DoctorDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();

                    $patients = PatientDetails::select(array(
                        'id', 'user_id',
                    ))->with(array(
                        'user' => function ( $query ) {
                            return $query->select(array(
                                'id', 'first_name', 'last_name','phone_no'
                            ));
                        }
                    ))->where(array(
                        'doctor_id' => $user_id->id,
                    ))->latest()->get();
                    // dd($selected_date);
                }
           
                if(Auth::user()->hasRole(['Hospital'])){
                    $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
                    
                    $patients = PatientDetails::select(array(
                        'id', 'user_id',
                    ))->with(array(
                        'user' => function ( $query ) {
                            return $query->select(array(
                                'id', 'first_name', 'last_name','phone_no'
                            ));
                        }
                    ))->where(array(
                        'clinic_id' => $user_id->id,
                    ))->latest()->get();

                    // dd($patients);
                }

                if(Auth::user()->hasRole(['Patient'])){
                    $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
                    $patients = PatientDetails::select(array(
                        'id', 'user_id',
                    ))->with(array(
                        'user' => function ( $query ) {
                            return $query->select(array(
                                'id', 'first_name', 'last_name',
                            ));
                        }
                    ))->where(array(
                        'patient_id' => Auth::user()->id,
                    ))->latest()->get();
                }

                if(Auth::user()->hasRole(['Receptionist'])){
                    // $user=Auth::user();
                    // dd($user);
                    $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
                    // dd($user_id);
                    $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->id)->first();
                    // dd($clinic_user_id);
                    $doctors = DoctorDetails::select('id','user_id','clinic_id')->where('id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
                    // dd($doctors);
                    $patients = PatientDetails::select(array(
                        'id', 'user_id',
                    ))->with(array(
                        'user' => function ( $query ) {
                            return $query->select(array(
                                'id', 'first_name', 'last_name',
                            ));
                        }
                    ))->where(array(
                        'receptionist_id' => $user_id->id,
                    ))->orWhere('clinic_id',$user_id->clinic_id)->latest()->get();
                }
        //    dd($patients);
                $this->data = array(
                    'appointment_date' => $request->appointment_date,
                    'patients' => $patients,
                    'available_slots' => $available_slots,
                    'clinic_details' => $clinic_details,
                    'selected_date' =>  $selected_date
                );

                if(Auth::user()->hasAnyRole(['Hospital','Receptionist'])){
                    $this->data = array(
                        'appointment_date' => $request->appointment_date,
                        'patients' => $patients,
                        'available_slots' => $available_slots,
                        'doctors' => $doctors,
                        'clinic_details' => $clinic_details,
                        'receptionist_details'=> $receptionist_details,
                        'selected_date' =>  $selected_date
                    );

                }

                $view = view('doctor.appointments.book-appointment', $this->data)->render();

                $this->data = array(
                    'status' => true,
                    'data' => array(
                        'view' => $view,
                    ),
                );

                return response()->json($this->data);
            }
        }

        $generalSettings = GeneralSettings::select('start_time','end_time','duration')->where('user_id',Auth::user()->id)->first();

        if($generalSettings == null) {
            return view('test');
        }

        $user_id = auth()->id();
        
        $date = today();
        $available_slot = [];

        if(Auth::user()->hasRole(['Doctor'])){
     

            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();

            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            

            $all_appointment = DoctorAppointmentDetails::where('doctor_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->withTrashed()->get()->count();
        //  dd($all_appointment);
            $wheres = function ( $query ) use ( $date, $user_id, $clinic_user_id ) {
                $query->where(array(
                    'appointment_date' => $date,
                    'disease_name' => '',
                    'doctor_id' => $user_id->id,
                ))->orWhere('clinic_id', @$clinic_user_id->clinic_id);
            };

            $where = function ( $query ) use ( $date, $user_id, $clinic_user_id ) {
                $query->where(array(
                    array('appointment_date', '>', $date),
                    'disease_name' => '',
                    'doctor_id' => $user_id->id,
                ))->orWhere('clinic_id', @$clinic_user_id->clinic_id);
            };
            // dd($where);
           
            $todays_appointment = DoctorAppointmentDetails::where('appointment_date', $date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })
                ->where('is_complete','=','0')->count();
                // dd($todays_appointment);
            
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id); 
                    })->count();

            $past_appointment = DoctorAppointmentDetails::where('disease_name','!=','')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })->get()->count();
                
        }


        if(Auth::user()->hasRole(['Hospital'])){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            // dd($user_id->id);

            $receptionist_details = ReceptionistDetails::select('id','user_id','clinic_id')->where('clinic_id',$user_id->id)->first();
            // dd($receptionist_details->id);
            $all_appointment = DoctorAppointmentDetails::where('clinic_id',$user_id->id)
                ->when($receptionist_details, function ($query) use ($receptionist_details) {
                    $query->orWhere('receptionist_id', $receptionist_details->id);
                })
                ->withTrashed()
                ->get()->count();
            
            $wheres = array(
                'appointment_date' => $date,
                'disease_name' => '',
                'clinic_id' => $user_id->id
            );

            $where = array(
                array('appointment_date', '>', $date),
                'disease_name' => '',
                'clinic_id' => $user_id->id
            );

            $todays_appointment = DoctorAppointmentDetails::where('appointment_date', $date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($receptionist_details, $user_id) {
                    $query
                        ->where('clinic_id', $user_id->id)
                        ->when($receptionist_details, function ( $query ) use ($receptionist_details) {
                            $query->orWhere('receptionist_id', $receptionist_details->id);
                        });
                })
                ->where('is_complete','=','0')->count();
            
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($receptionist_details, $user_id) {
                    $query
                        ->when($receptionist_details, function ( $query ) use ($receptionist_details){
                            $query->orWhere('receptionist_id', $receptionist_details->id);
                        })
                        ->where('clinic_id', $user_id->id);
                })
                ->where('is_complete','=','0')->count();
            
            $past_appointment = DoctorAppointmentDetails::where('disease_name','!=','')->with('user')->withTrashed()
                ->where(function ( $query ) use ($receptionist_details, $user_id) {
                    $query
                        ->when($receptionist_details, function ( $query ) use ($receptionist_details) {
                            $query->orWhere('receptionist_id', $receptionist_details->id);
                        })
                        ->where('clinic_id', $user_id->id);
                })->get()->count();


        }

     
        if(Auth::user()->hasRole(['Receptionist'])){
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $all_appointment = DoctorAppointmentDetails::where('receptionist_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->withTrashed()->get()->count();

            $wheres = function ( $query ) use ( $date, $user_id, $clinic_user_id ) {
                $query->where(array(
                    'appointment_date' => $date,
                    'disease_name' => '',
                ))->orWhere(array(
                    'receptionist_id' => $user_id->id,
                    'clinic_id' => $user_id->clinic_id
                ));
            };
            // dd($cliz)
            $where = function ( $query ) use ( $date, $user_id, $clinic_user_id ) {
                $query->where(array(
                    array('appointment_date', '>', $date),
                    'disease_name' => '',
                ))->orWhere(array(
                    'receptionist_id' => $user_id->id,
                    'clinic_id' =>  $user_id->clinic_id
                ));
            };
           
            $todays_appointment = DoctorAppointmentDetails::where('appointment_date', $date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', $user_id->clinic_id);
                })
                ->where('is_complete','=','0')->count();
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', $user_id->clinic_id);
                })
                ->where('is_complete','=','0')->count();
            $past_appointment = DoctorAppointmentDetails::where('disease_name','!=','')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', $user_id->clinic_id);
                })->get()->count();
        }
 
        $patients = PatientDetails::with('user')->where('doctor_id',$user_id)->get();

        $current_slots = DoctorAppointmentDetails::where('patient_id',$user_id)->get();

        $available_time_slot = DoctorAppointmentDetails::with('user')->select(array(
            'id', 'patient_id', 'time_start', 'time_end', 'appointment_date',
        ))->where(array(
            'appointment_date' => $date,
            'patient_id' => $user_id,
        ))->get();

        foreach ($available_time_slot as $available) {
            $available_slot[] = $available->time_start . ' - ' . $available->time_end;
        }   
      
        $this->data = array(
            'title' => 'Appointments',
            'todays_appointment' => $todays_appointment,
            'upcoming_appointment' => $upcoming_appointment,
            'all_appointment' =>$all_appointment,
            'past_appointment' => $past_appointment,
        ); 

        if(Auth::user()->hasRole(['Hospital'])){
            $this->data = array(
                'title' => 'Appointments',
                'todays_appointment' => $todays_appointment,
                'upcoming_appointment' => $upcoming_appointment,
                'all_appointment' =>$all_appointment,
                'past_appointment' => $past_appointment,
                'doctors' => $doctors
            ); 
        }
        
        if(Auth::user()->hasRole(['Doctor'])){
            $this->data = array(
                'title' => 'Appointments',
                'todays_appointment' => $todays_appointment,
                'upcoming_appointment' => $upcoming_appointment,
                'all_appointment' =>$all_appointment,
                'past_appointment' => $past_appointment,
                'doctors' => $doctors,
               
            ); 
        }

        return view('doctor.appointments.index', $this->data);
    }

    private function getBookedTimeslots( $request ) {
        $user_id = auth()->id();
        
        $appointments = DoctorAppointmentDetails::where(array(
            'patient_id' => $user_id,
        ))->with('user')->get();
      
        $current_time = now()->toTimeString();

        foreach($appointments as $app){
            // if($app->time_start > $current_time){
               $available_time_slot = DoctorAppointmentDetails::with('user')->select(array(
                'id', 'patient_id', 'time_start', 'time_end', 'appointment_date',
                    ))->where(array(
                        'appointment_date' => date('Y/m/d', strtotime()),
                        'patient_id' => $user_id,
                    ))->get();

        }
        foreach ($available_time_slot as $available) {
                    $available_slot[] = $available->time_start . ' - ' . $available->time_end;
                }    

    }

    public function calendarEvents(Request $request) {
        // dd($request);
        $splitTime = explode('-', $request->time_start, 2);
        if(Auth::user()->hasRole(['Doctor'])){
            $doctor_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $doctor_main_id = $doctor_id->id;
            $doctor_main_clinicid = $doctor_id->clinic_id;
            // dd($doctor_id);

        }
        else {

            $doctor_main_id = $request->doctor_id ? $request->doctor_id : 0;
            $doctor_main_clinicid = $request->clinic_id ? $request->clinic_id : 0;

        }
        // dd($doctor_main_clinicid);
        $event = DoctorAppointmentDetails::create([
          'patient_id' => $request->event_name,
          'user_id' => $request->event_name,
          'disease_name' => $request->disease_name ?? '',   
          'appointment_date' => $request->appointment_date,
          'doctor_id' => $doctor_main_id,
          'receptionist_id' => $request->receptionist_id ? $request->receptionist_id : 0,
          'clinic_id' => $doctor_main_clinicid,
          'created_by' => $request->created_by,
          'time_start' => $splitTime[0],
          'time_end' => $splitTime[1],
          'weight'=>$request->weight ?? null,
          'blood_pressure'=>$request->blood_pressure ?? null
        ]);
        // dd($request);

        if($request->disease_name != null){
            PatientDetails::create('disease_name',$request->disease_name);
        }

        return response()->json($event);
    }

    public function patients(Request $request) {
        
        $this->data = array(
            'title' => 'Patients',
        ); 

        return view('admin.patients.index',$this->data);
    }

    public function all_appointment(Request $request){
        $date = today();
        if ( $request->load_view == '1' ) {
            $this->data = [];
            $view = view('doctor.appointments.all_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view,
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::with('user')->withTrashed()->where('patient_id',Auth::user()->id)->get();
    

        if(Auth::user()->hasRole(['Doctor'])){
            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            // dd($user_id);
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $appointments = DoctorAppointmentDetails::with('user')->withTrashed()->where('doctor_id',$user_id->id)->orWhere('clinic_id',@$clinic_user_id->clinic_id)->get();
            // dd($appointments);
        }

        if(Auth::user()->hasRole(['Hospital'])){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            // dd($user_id->id);
            $receptionist_details = ReceptionistDetails::select('id','user_id','clinic_id')->where('clinic_id',$user_id->id)->first();
            // dd($receptionist_details);
            $appointments = DoctorAppointmentDetails::with('user')->withTrashed()
                ->where(function ( $query ) use ($receptionist_details, $user_id) {
                    $query->where('receptionist_id',@$receptionist_details->id)
                        ->orWhere('clinic_id', $user_id->id);
                })->get();
        }

        if(Auth::user()->hasRole(['Receptionist'])){
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $appointments = DoctorAppointmentDetails::with('user')->withTrashed()->where('receptionist_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
        }

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user?->phone_no;
                // dd($row);
            })
            ->addColumn('appointment_date',function($row){
                return date('d-m-Y',strtotime($row->appointment_date));
                // dd($row->appointment_date);
            })
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name; 
            })
            ->addColumn('status', function($row) {
                return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
            ->addColumn('action', function($row){
                 $actionBtn =   '<div class="dropable-btn">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                           <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                        </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                        <li>
                                           <a class="dropdown-item edit-all-appointment" href="javascript:void(0)" data-url="'. route('all-appointments.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="editmodal" data-target="#myEditModal">
                                              <span class="svg-icon">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                 </svg>
                                              </span>
                                              <span class="svg-text">Attend Patient</span>
                                           </a>
                                        </li>
                                        <li>
                                           <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="delete btn btn-delete" title="Delete">
                                                  <span class="svg-icon">
                                                     <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                        <g>
                                                           <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                              h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                              M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                              c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                           <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                           <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                           <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                        </g>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Reject</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>';
                        return $actionBtn;
                })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);

        return response()->json($this->data);
    }

    public function todays_appointment(Request $request){

        // dd($request);
        $date = today()->format('Y-m-d');
        // dd($date);
        // $date=Carbon::createFromFormat('Y-m-d',$d)->format('d-m-Y');
        // dd($date);
         if ( $request->load_view == '1' ) {
            $this->data = [];
            $view =  view('doctor.appointments.todays_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::whereDate('appointment_date','=',$date)->with('user')->withTrashed()->where('patient_id',Auth::user()->id)->where('is_complete','=','0')->get();
        // dd($appointments);
     

        if(Auth::user()->hasRole(['Doctor'])){
            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $appointments = DoctorAppointmentDetails::whereDate('appointment_date', $date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })
                ->where('is_complete','=','0')->get();
        //    dd($appointments);
  
            }

        if(Auth::user()->hasRole(['Hospital'])){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $appointments = DoctorAppointmentDetails::where('appointment_date','=',$date)->with('user')->withTrashed()->where('clinic_id',$user_id->id)->where('is_complete','=','0')->get();
        }

        if(Auth::user()->hasRole(['Receptionist'])){

            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();

            $appointments = DoctorAppointmentDetails::where('appointment_date', $date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', $user_id->clinic_id);
                })
                ->where('is_complete','=','0')->get();
        }
        // dd($appointments);

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })
            ->addColumn('appointment_date', function($row) {
                return date('d-m-Y' , strtotime( $row->appointment_date)) ;
            })
            ->addColumn('status', function($row) {
                    return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            }) 
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name;  
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
            ->addColumn('action', function($row){
                 $actionBtn =   '<div class="dropable-btn">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                           <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                        </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                        <li>
                                           <a class="dropdown-item edit-all-appointment" href="javascript:void(0)" data-url="'. route('all-appointments.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="editmodal" data-target="#myEditModal">
                                              <span class="svg-icon">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                 </svg>
                                              </span>
                                              <span class="svg-text">Attend Patient</span>
                                           </a>
                                        </li>
                                        <li>
                                           <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="delete btn btn-delete" title="Delete">
                                                  <span class="svg-icon">
                                                     <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                        <g>
                                                           <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                              h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                              M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                              c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                           <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                           <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                           <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                        </g>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Reject</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>';
                        return $actionBtn;
                })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);
        return response()->json($this->data);
    }

    public function upcoming_appointment(Request $request){

        $date = today()->format('Y-m-d');

         if ( $request->load_view == '1' ) {
            $this->data = [];
            $view = view('doctor.appointments.upcoming_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::where('appointment_date','>',$date)->withTrashed()->where('is_complete','=','0')->with('user')->where('patient_id',Auth::user()->id)->get();

        if(Auth::user()->hasRole(['Doctor'])){
            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $appointments = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id); 
                    });
        }

        if(Auth::user()->hasRole(['Hospital'])) {
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $receptionist_details = ReceptionistDetails::select('id','user_id','clinic_id')->where('clinic_id',$user_id->id)->first();
            $appointments = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()->where('clinic_id',$user_id->id)->orWhere('receptionist_id',$receptionist_details->id)->where('is_complete','=','0')->get();
        }

        if(Auth::user()->hasRole(['Receptionist'])){
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $appointments = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', $user_id->clinic_id);
                })
                ->where('is_complete','=','0')->get();
        }

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })

            ->addColumn('appointment_date', function($row) {
                return date('d-m-Y' , strtotime( $row->appointment_date)) ;
            })
            ->addColumn('status', function($row) {
                    return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            }) 
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name;  
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
            ->addColumn('action', function($row){
                 $actionBtn =   '<div class="dropable-btn">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                           <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                        </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                        <li>
                                           <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="delete btn btn-delete" title="Delete">
                                                  <span class="svg-icon">
                                                     <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                        <g>
                                                           <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                              h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                              M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                              c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                           <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                           <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                           <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                        </g>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Reject</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>';
                        return $actionBtn;
                })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);

        return response()->json($this->data);
    }

    public function past_appointment(Request $request){

        $date = today()->format('Y-m-d');

         if ( $request->load_view == '1' ) {
            $this->data = [];
            $view = view('doctor.appointments.past_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::where('disease_name','!=','')->withTrashed()->with('user')->where('patient_id',Auth::user()->id)->get();

        if(Auth::user()->hasRole(['Doctor'])){
            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            // dd($user_id);
             $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            //  dd($clinic_user_id);
            $appointments = DoctorAppointmentDetails::where('disease_name','!=','')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })->get();
        }

        if(Auth::user()->hasRole(['Hospital'])){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $receptionist_details = ReceptionistDetails::select('id','user_id','clinic_id')->where('clinic_id',$user_id->id)->first();
            $appointments = DoctorAppointmentDetails::where('disease_name','!=','')->with('user')->withTrashed()->where('clinic_id',$user_id->id)->orWhere('receptionist_id',$receptionist_details->id)->get();
        }

        if(Auth::user()->hasRole(['Receptionist'])){
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $appointments = DoctorAppointmentDetails::where('disease_name','!=','')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', $user_id->clinic_id);
                })->get();
        }

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })
            ->addColumn('appointment_date', function($row) {
                return date('d-m-Y' , strtotime( $row->appointment_date)) ;
            })
           ->addColumn('status', function($row) {
                    return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            })
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name;  
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
             ->addColumn('next_date', function($row) {
                return $row->next_date ? date('d-m-Y', strtotime($row->next_date)) : 'N/A';
            })
            ->addColumn('action', function($row){
                $actionBtn =   '<div class="dropable-btn">
                                <div class="dropdown">
                                   
                                           <a class="dropdown-item patient-view" href="javascript:void(0)" data-url="'. route('patients.view',$row->patient_id) .'" data-id="'. $row->patient_id .'" data-bs-toggle="viewmodal" data-bs-target="#myViewModal">
                                              <span class="svg-icon">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"></path>
                                                 </svg>
                                              </span>
                                           </a>
                                       
                                </div>
                            </div>';
                    return $actionBtn;   
            })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);

        return response()->json($this->data);
    }

     /**
     * Use: Insert record for settings 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function settingsCreate () {

        $generalSettings = GeneralSettings::select('start_time','end_time','duration')->where('user_id',Auth::user()->id)->first();
        $this->data = array(
            'title' => 'Settings',
            'generalSettings' => $generalSettings,
        );
        
        $view = view('doctor.settings', $this->data)->render();
        
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,

            ),
        );

        return response()->json($response);
    }

    /**
     * Use: store settings
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function settingsStore(Request $request) {   
       
        GeneralSettings::updateOrCreate(
        [
        'user_id'   => Auth::user()->id,
        ],
        ['start_time'=> date('H:i:s',strtotime($request->start_time)),'end_time'=>date('H:i:s',strtotime($request->end_time)),'duration'=>$request->duration,'break_time'=>$request->break_time]);
         
        return response()->json(
             [
               'status' => true,
               'message' => 'Settings has been created!'
             ]
        );
    }

    /**
     * Use: Edit form for all-appointments's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        // dd($id);

        $user_id = auth()->id();

        $date = today();
        
        $available_time_slot = DoctorAppointmentDetails::with('user')->select(array(
            'id', 'patient_id', 'time_start', 'time_end', 'appointment_date','next_start_time','next_end_time'
        ))->where(array(
            'appointment_date' => $date,
            'patient_id' => $user_id,
        ))->get();


        $available_slot[] = '';
        foreach ($available_time_slot as $available) {
            $available_slot[] = $available->next_start_time . ' - ' . $available->next_end_time;
        }   
        // dd($available_slot);
        $general_time = GeneralSettings::select('start_time', 'end_time', 'duration')->where('user_id', $user_id)->first();

        $current_date = date('H:00:00');
        
        $current_time = now()->toTimeString();
        
        $start = new DateTime($general_time->start_time ?? '8:00 AM');

        $end = new DateTime($general_time->end_time ?? '8:00 PM');
        
        $start_time = $start->format('H:i:s');
    
        $end_time = $end->format('H:i:s');
        
        $duration = $general_time->duration ?? 10;
        
        $break_time = $general_time->break_time ?? 10;
        
        $time = [];
       
        $i=0;

        while(strtotime($start_time) <= strtotime($end_time)) {
            
            $start = $start_time;
            
            $end = date('H:i:s',strtotime('+'.$duration.' minutes',strtotime($start_time)));

            $start_time = date('H:i:s',strtotime('+'.$break_time.'minutes'. '+'.$duration.' minutes',strtotime($start_time)));
                        
          
            
            if(strtotime($start_time) <= strtotime($end_time)){
                $time[$i]['start'] = $start;
                $time[$i]['end'] = $end;
            }
            $i++;
            // dd($time);
        } 
        
       
       
        $all_appointent = DoctorAppointmentDetails::with('user')->findOrFail($id);
        $appointment_history=DoctorAppointmentDetails::select('id','user_id','appointment_date','time_start','time_end'
        ,'disease_name','prescription','weight','blood_pressure','dietplan','next_date')->where('patient_id',$all_appointent->patient_id)->with('user')->get();
        // dd($appointment_history);
        $view = view('doctor.appointments.all_edit', compact('all_appointent','time','available_slot','current_time','appointment_history'))->render();
        
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

    /**
     * Use: Update all-appointments's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateAppointmentRequest $request, $id) {
        // dd($request);
        $post_data = $request->validated();
        // dd($post_data);
        $splitTime = !empty($post_data['next_start_time']) ? explode('-', $post_data['next_start_time'], 2) :['',''];
    //    dd($splitTime);
        $all_appointent = DoctorAppointmentDetails::with('user')->find($id);
        $all_appointent->disease_name = $post_data['disease_name'];
        $all_appointent->prescription = $post_data['prescription'];
        $all_appointent->weight = $post_data['weight'];
        $all_appointent->blood_pressure = $post_data['blood_pressure'];
        $all_appointent->dietplan = $post_data['dietplan'];
        // dd($all_appointent);
        $all_appointent->next_date = isset($post_data['next_date'])? $post_data['next_date']:null;
        // dd($all_appointent);
        $all_appointent->is_complete = $request->is_complete ?? 0;
        // dd($all_appointent);
        $all_appointent->next_start_time = isset($splitTime[0]) ? $splitTime[0] : $all_appointent->time_start;
        $all_appointent->next_end_time = isset($splitTime[1]) ? $splitTime[1]:$all_appointent->time_end;
        // dd($all_appointent);
        $all_appointent->save();

        return response()->json(
             [
               'status' => true,
               'message' => 'Appointment has been updated.'
             ]
        );
        
        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $delete_appointment = DoctorAppointmentDetails::where('id',$request->id)->first();

        if ($delete_appointment->delete()) {

            return response()->json([
                'status' => 'Appointment has been deleted!'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong!  Appointment not found!'
        ]);
    }

    public function changeStatus(UpdateAppointmentRequest $request){
        // dd($request);

        $user_id = DoctorAppointmentDetails::with('user')->where('id',$request->id)->first();
        $post_data = $request->validated( $request->messages());
        $splitTime = $request->next_start_time ? explode('-', $request->next_start_time, 2) : null;
        $all_appointent = DoctorAppointmentDetails::with('user')->find($request->id);
        $all_appointent->disease_name = $post_data['disease_name'];
        $all_appointent->is_complete = isset($post_data['is_complete'])? $post_data['is_complete']:null;
        $all_appointent->next_date =  $request->next_date ? date('Y/m/d', strtotime($request->next_date)) : null;
        $all_appointent->next_start_time =  @$splitTime[0] ? $splitTime[0] : $all_appointent->next_start_time;
        $all_appointent->next_end_time = @$splitTime[1] ? $splitTime[1] : $all_appointent->next_end_time;;
        $all_appointent->save();

        if($all_appointent->save() == true) {
            $user = DoctorAppointmentDetails::with('user')->where('patient_id',$user_id->user_id)->first();
            $clinic_details = DoctorAppointmentDetails::with('user')->where('clinic_id',$user_id->clinic_id)->first();
            // dd($user->time_start);
            \Mail::to($user['user']['email'])->send(new PrescriptionMail($user,$request,$clinic_details));
        }


        return response()->json(['success'=>'Data updated successfully.']);
    }

     public function patientAppointments(Request $request) {
        
        if(Auth::user()->hasRole(['Patient'])){
            $date = today();
            $user_id = PatientDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            // dd($user_id);
            $all_appointment = DoctorAppointmentDetails::withTrashed()->where('patient_id',Auth::user()->id)->count();
            $todays_appointment = DoctorAppointmentDetails::where('appointment_date', $date)->where('patient_id',Auth::user()->id)->where('is_complete','=','0')->withTrashed()->count();
            
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->where('patient_id',Auth::user()->id)->withTrashed()->where('is_complete','=','0')->count();
            
            $past_appointment = DoctorAppointmentDetails::where('is_complete',1)->with('user')->withTrashed()->where('patient_id',Auth::user()->id)->count();

            $selected_date=$request->appointment_date;
            // dd($selected_date);
        }

        $clinics = ClinicDetails::where('is_main_branch',1)->get();
      
        if ( $request->ajax() ) {

            // dd($request->appointment_date);

            if ( $request->load_view == 'true' ) {
                $available_slots = DoctorAppointmentDetails::getAvailableTimeslotes( $request->appointment_date, $request->event_name );
                // dd($available_slots);

                $clinic_details = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();

                $this->data = array(
                    'appointment_date' => $request->appointment_date,
                    'available_slots' => $available_slots,
                    'clinics' => $clinics,
                    'selected_date' =>  $selected_date
                );

                $view = view('doctor.appointments.patient-book-appointment', $this->data)->render();

                $this->data = array(
                    'status' => true,
                    'data' => array(
                        'view' => $view,
                    ),
                );

                return response()->json($this->data);
            }
        }

        $generalSettings = GeneralSettings::select('start_time','end_time','duration')->where('user_id',Auth::user()->id)->first();
        // dd($generalSettings);
        $user_id = auth()->id();
        
        $date = today();

        $available_slot = [];

        
        $patients = PatientDetails::with('user')->where('doctor_id',$user_id)->get();

        $current_slots = DoctorAppointmentDetails::where('patient_id',$user_id)->get();


        $available_time_slot = DoctorAppointmentDetails::with('user')->select(array(
            'id', 'patient_id', 'time_start', 'time_end', 'appointment_date',
        ))->where(array(
            'appointment_date' => $date,
            'patient_id' => $user_id,
        ))->get();

        foreach ($available_time_slot as $available) {
            $available_slot[] = $available->time_start . ' - ' . $available->time_end;
        }   
      
        $this->data = array(
            'title' => 'Appointments',
            'todays_appointment' => $todays_appointment,
            'upcoming_appointment' => $upcoming_appointment,
            'all_appointment' =>$all_appointment,
            'past_appointment' => $past_appointment,
        ); 
       
        return view('doctor.appointments.patient-index', $this->data);
    }

    public function fetchDoctors(Request $request)
    {
        $clinic_id = ClinicDetails::where('user_id',$request->clinic_id)->first();
        $data['doctors'] = DoctorDetails::where("clinic_id",$clinic_id->id)->with('user')->get();
        return response()->json($data);
    }

    public function fetchTimeSlots(Request $request)
    {
        // dd($request);
        $clinic_id = ClinicDetails::where('user_id',$request->clinic_id)->first();
        // dd($clinic_id);
        $data['generalSettings'] = GeneralSettings::select('start_time','end_time','duration')->where('user_id',$request->clinic_id)->first();
        //  dd($data);
        $user_id = auth()->id();
        
        $date = today();

        $available_slot = [];

        $current_time = now()->toTimeString();

        $data['current_slots'] = DoctorAppointmentDetails::where('clinic_id',$clinic_id->id)->get();
        // dd($data);

        $available_time_slots = DoctorAppointmentDetails::with('user')->select(array(
            'id', 'patient_id', 'time_start', 'time_end', 'appointment_date','clinic_id'
        ))->where(array(
            'appointment_date' => $date,
            'clinic_id' => $clinic_id->id,
        ))->get();

        $booked_timeslots = [];

        foreach ($available_time_slots as $available) {
            $data['booked_timeslots'][] = $available->time_start . '-' . $available->time_end;
        }

        $data['booked_timeslots'] = array_unique($booked_timeslots);

        $general_time = GeneralSettings::select(array(
            'start_time', 'end_time', 'duration'
        ))->where(array(
            'user_id' => $request->clinic_id,
        ))->first();

        $current_time = now()->toTimeString();

        $start = new DateTime($general_time->start_time ?? '');
        $start_time = $start->format('H:i:s');
        
        $end = new DateTime($general_time->end_time ?? '');
        $end_time = $end->format('H:i:s');
        
        $duration = $general_time->duration ?? 10;
        
        // $break_time = $general_time->break_time ?? 10;
        
        $all_day_time_slots = array();

        $current_date = \Carbon\Carbon::now()->format('Y-m-d');
        $data['all_day_time_slots']=[];
        while(strtotime($start_time) <= strtotime($end_time)) {
            $start = $start_time;
            $end = date('H:i:s', strtotime("+$duration minutes", strtotime($start_time)));

            $start_time = date('H:i:s', strtotime("+$duration minutes", strtotime($start_time)));

            $cur_date = $request->appointment_date;

            if ($current_date == $cur_date) {
                if ( ( strtotime($start_time) < strtotime($end_time) )  && ( $current_time < $start_time )) {
                    $data['all_day_time_slots'][] = "$start-$end";
                }
            } else {
                if ( ( strtotime($start_time) <= strtotime($end_time) ) ) {
                     $data['all_day_time_slots'][]  = "$start-$end";
                }
            }
        }

        $data['arr'] = array_values(array_diff($data['all_day_time_slots'], $data['booked_timeslots']));
        return response()->json($data);
    }


    public function fetchTimeSlotsDoctor(Request $request)
    {
        // dd($request);
        $doctor_id = DoctorDetails::where('user_id',$request->doctor_id)->first();
        // dd($doctor_id);
        
        $data['generalSettings'] = GeneralSettings::select('id','start_time','end_time','duration')->where('user_id',$request->doctor_id)->first();
        //  dd($data);
        $user_id = auth()->id();
        
        $date = today();

        $available_slot = [];

        $current_time = now()->toTimeString();

        $data['current_slots'] = DoctorAppointmentDetails::where('doctor_id',$doctor_id->id)->get();

        $available_time_slots = DoctorAppointmentDetails::with('user')->select(array(
            'id', 'patient_id', 'time_start', 'time_end', 'appointment_date','doctor_id'
        ))->where(array(
            'appointment_date' => $date,
            'doctor_id' => $doctor_id->id,
        ))->get();

        $booked_timeslots = [];

        foreach ($available_time_slots as $available) {
            $data['booked_timeslots'][] = $available->time_start . '-' . $available->time_end;
        }

        $data['booked_timeslots'] = array_unique($booked_timeslots);

        $general_time = GeneralSettings::select(array(
            'start_time', 'end_time', 'duration'
        ))->where(array(
            'user_id' => $request->doctor_id,
        ))->first();

        $current_time = now()->toTimeString();

        $start = new DateTime($general_time->start_time ?? '');
        $start_time = $start->format('H:i:s');
        
        $end = new DateTime($general_time->end_time ?? '');
        $end_time = $end->format('H:i:s');
        
        $duration = $general_time->duration ?? 10;
        
        // $break_time = $general_time->break_time ?? 10;
        
        $all_day_time_slots = array();

        $current_date = \Carbon\Carbon::now()->format('Y-m-d');
        
        $data['all_day_time_slots']=[];

        while(strtotime($start_time) <= strtotime($end_time)) {
            $start = $start_time;
            $end = date('H:i:s', strtotime("+$duration minutes", strtotime($start_time)));

            $start_time = date('H:i:s', strtotime(" +$duration minutes", strtotime($start_time)));

            $cur_date = $request->appointment_date;

            if ($current_date == $cur_date) {
                if ( ( strtotime($start_time) < strtotime($end_time) )  && ( $current_time < $start_time )) {
                    $data['all_day_time_slots'][] = "$start-$end";
                }
            } else {
                if ( ( strtotime($start_time) <= strtotime($end_time) ) ) {
                     $data['all_day_time_slots'][]  = "$start-$end";
                }
            }
        }

        $data['arr'] = array_values(array_diff($data['all_day_time_slots'], $data['booked_timeslots']));
        return response()->json($data);
    }

    public function patientcalendarEvents(Request $request) {
        // dd($request->all(),Auth::user()->id);
        $splitTime = explode('-', $request->time_start, 2);

        if(Auth::user()->hasRole(['Doctor'])){
            $doctor_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $doctor_main_id = $doctor_id->id;
            $doctor_main_clinicid = $doctor_id->clinic_id;

        }
        if(Auth::user()->hasRole(['Patient'])) {
            $doctor_id = DoctorDetails::select('id','user_id','clinic_id')->with('user')->where('user_id',$request->doctor_id)->first();
            $clinic_id = ClinicDetails::select('id','user_id')->with('user')->where('user_id',$request->event_name)->first();
            $doctor_main_id = $request->doctor_id ? $doctor_id->id  :  0;
            $doctor_main_clinicid = $request->event_name ?  $clinic_id->id  : 0;

        }
        // dd($request->all());
        $event = DoctorAppointmentDetails::create([
          'patient_id' => Auth::user()->id,
          'user_id' => $request->event_name,
          'disease_name' => $request->disease_name ?? '',   
          'appointment_date' => $request->appointment_date,
          'doctor_id' => $doctor_main_id,
          'receptionist_id' => $request->receptionist_id ? $request->receptionist_id : 0,
          'clinic_id' => $doctor_main_clinicid,
          'created_by' => $request->created_by,
          'time_start' => $splitTime[0],
          'time_end' => $splitTime[1],
        ]);

        if($request->disease_name != null){
            PatientDetails::create('disease_name',$request->disease_name);
        }

        return response()->json($event);
    }

    public function all_patient_appointment(Request $request){
        $date = today();
        if ( $request->load_view == '1' ) {
            $this->data = [];
            $view = view('doctor.appointments.all_patient_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view,
                ),
            );
            return response()->json($this->data);
        }

        $appointments = DoctorAppointmentDetails::with('user')->withTrashed()->where('patient_id',Auth::user()->id)->get();

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name; 
            })
            ->addColumn('status', function($row) {
                return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
            ->addColumn('action', function($row){
                $status = $row->deleted_at =='' ? 'Aprooved' : 'Rejected';
                $actionBtn =   '<div class="dropable-btn">
                                    <div class="dropdown">
                                        <a class="dropdown-item" href="javascript:void(0)" class="update-status delete btn btn-delete" title="Delete" data-status="'. $status .'">
                                            <span class="svg-icon">
                                                     <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                        <g>
                                                           <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                              h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                              M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                              c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                           <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                           <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                           <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                        </g>
                                                     </svg>
                                                  </span>
                                    </div>
                                </div>';
                        return $actionBtn;
                })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);

        return response()->json($this->data);
    }

    public function todays_patient_appointment(Request $request){

        $date = today()->format('Y-m-d');

         if ( $request->load_view == '1' ) {
            $this->data = [];
            $view =  view('doctor.appointments.todays_patient_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::where('appointment_date','=',$date)->with('user')->withTrashed()->where('patient_id',Auth::user()->id)->where('is_complete','=','0')->get();

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })
            ->addColumn('status', function($row) {
                    return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            }) 
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name;  
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
            ->addColumn('action', function($row){
                 $actionBtn =   '<div class="dropable-btn">                                    
                                           <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="delete btn btn-delete" title="Delete">
                                                  <span class="svg-icon">
                                                     <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                        <g>
                                                           <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                              h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                              M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                              c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                           <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                           <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                           <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                        </g>
                                                     </svg>
                                                  </span>
                                                
                                </div>';
                        return $actionBtn;
                })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);
        return response()->json($this->data);
    }

    public function upcoming_patient_appointment(Request $request){

        $date = today()->format('Y-m-d');

         if ( $request->load_view == '1' ) {
            $this->data = [];
            $view = view('doctor.appointments.upcoming_patient_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::where('appointment_date','>',$date)->withTrashed()->where('is_complete','=','0')->with('user')->where('patient_id',Auth::user()->id)->get();

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })
            ->addColumn('status', function($row) {
                    return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            }) 
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name;  
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
            ->addColumn('action', function($row){
                 $actionBtn =   '<div class="dropable-btn">
                                           <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="delete btn btn-delete" title="Delete">
                                                  <span class="svg-icon">
                                                     <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                        <g>
                                                           <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                              h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                              M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                              c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                           <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                           <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                           <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                        </g>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Reject</span>
                                                </a>
                                </div>';
                        return $actionBtn;
                })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);

        return response()->json($this->data);
    }

    public function past_patient_appointment(Request $request){

        $date = today()->format('Y-m-d');

         if ( $request->load_view == '1' ) {
            $this->data = [];
            $view = view('doctor.appointments.past_patient_appointment', $this->data)->render();

            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view
                ),
            );
            return response()->json($this->data);
        }
        
        $appointments = DoctorAppointmentDetails::where('is_complete',1)->withTrashed()->with('user')->where('patient_id',Auth::user()->id)->get();

        return Datatables::of($appointments)
            ->addColumn('phone_no', function($row) {
                return $row->user->phone_no;
            })
           ->addColumn('status', function($row) {
                    return $row->deleted_at =='' ? 'Approved' : 'Rejected';
            })
            ->addColumn('created_by', function($row) {
                $created_by = User::select('id','first_name','last_name','name')->where('id',$row->created_by)->first();
                return $created_by->first_name . ' - ' . $created_by->name;  
            })
            ->addColumn('time_start', function($row) {
                return date('H:i A', strtotime($row->time_start));
            })
            ->addColumn('time_end', function($row) {
                return date('H:i A', strtotime($row->time_end));
            })
             ->addColumn('next_date', function($row) {
                return $row->next_date ? date('d-m-Y', strtotime($row->next_date)) : 'N/A';
            })
            ->addColumn('action', function($row){
                $actionBtn =   '<div class="dropable-btn">
                                <div class="dropdown">
                                   <a class="dropdown-item patient-view" href="javascript:void(0)" data-url="'. route('patients.view',$row->patient_id) .'" data-id="'. $row->patient_id .'" data-bs-toggle="viewmodal" data-bs-target="#myViewModal">
                                      <span class="svg-icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"></path>
                                         </svg>
                                      </span>
                                   </a>
                                </div>
                            </div>';
                    return $actionBtn;   
            })
            ->rawColumns([ 'phone_no', 'disease_name', 'time_start', 'time_end', 'action' ])
            ->make(true);

        return response()->json($this->data);
    }

    public function destroyPatient(Request $request)
    {
        if($request->id) {
            $delete_appointment = DoctorAppointmentDetails::where('id',$request->id)->first();

            if ($delete_appointment->delete()) {

                return response()->json([
                    'status' => 'Appointment has been deleted!'
                ]);
            }
            return response()->json([
                'error' => 'Something went wrong!  Appointment not found!'
            ]); 
        }
     
    }

}
