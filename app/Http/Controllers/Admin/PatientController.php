<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatientDetails;
use App\Models\User;
use DataTables;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Carbon\Carbon;
use App\Models\DoctorDetails;
use App\Models\ReceptionistDetails;
use App\Models\ClinicDetails;
use App\Models\DoctorAppointmentDetails;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Str;


class PatientController extends Controller
{
    /**
     * Use: Display listing of patients.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {

        $clinic_details = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
        // $patients = PatientDetails::select(array(
        //     'id','user_id','clinic_id','created_at','doctor_id'
        //     ))->latest()->with('user')->where('doctor_id',$user_id->id)->get();
        if ($request->ajax()) {
            
            if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)){
                $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at'
                    ))->latest()->with('user')->get();  
                }
                if(Auth::user()->hasRole(User::ROLE_DOCTOR)) {
                    
                $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();

                $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
                
                $doctorIds=DoctorDetails::select('id','user_id','clinic_id')->where('clinic_id',$user_id->clinic_id)->pluck('id');
           
                $patients=PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at','doctor_id'
                 ))->latest()->with('user')->where('clinic_id',$user_id->clinic_id)->orWhereIn('doctor_id',$doctorIds)->orderByDesc('created_at')->get();


                // $patients = PatientDetails::select(array(
                // 'id','user_id','clinic_id','created_at','doctor_id'
                // ))->with('user')->where('doctor_id',$user_id->id)->orderByDesc('created_at')->get();
               
            }
             if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)) {
 
                    $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
                    $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id','receptionist_id')->where('clinic_id',$user_id->clinic_id)->first();
                    $doctorsIds = DoctorDetails::select(array(
                        'id','user_id','clinic_id','status','created_at'
                    ))->latest()->with('user')->where('clinic_id',$user_id->clinic_id)->pluck('id');
                
                    
                    $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at'
                 ))->latest()->with('user')->where('clinic_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->orWhereIn('doctor_id',$doctorsIds)->get();
              
         
                }

            if(Auth::user()->hasRole(User::ROLE_CLINIC)) {

                $user_id = ClinicDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
          
                $doctorsIds = DoctorDetails::select(array(
                    'id','user_id','clinic_id','status','created_at'
                ))->latest()->with('user')->where('clinic_id',$user_id->id)->pluck('id');
            
                $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','doctor_id','created_at'
                ))->latest()->with('user')->where('clinic_id',$clinic_details->id)->orWhere('receptionist_id',$user_id->id)->orWhereIn('doctor_id',$doctorsIds)->get();
              
            }

            return Datatables::of($patients)
                ->editColumn('created_at', function($row) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('dS F, Y h:i A');
                    return $formatedDate;
                })
                ->addColumn('fullname', function($row) {
                    return $row->user->first_name.' '.$row->user->last_name;
                })
                ->addColumn('email', function($row) {
                    return '<a href="mailto:' . $row->user->email . '?">' . $row->user->email . '</a>';
                })
                ->addColumn('action', function($row) {
                    $actionBtn =   '<div class="dropable-btn">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                               <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <li>
                                               <a class="dropdown-item patient-view" href="javascript:void(0)" data-url="'. route('patients.view',$row->id) .'" data-id="'. $row->id .'" data-toggle="viewmodal" data-target="#myViewModal" title="View">
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item edit-patient" href="javascript:void(0)" data-url="'. route('patients.edit', $row->id) .'" data-id="'. $row->id .'">
                                                  <span class="svg-text" title="Edit">Edit</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="btn btn-delete" title="Delete">
                                                      <span class="svg-text">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action','status','first_name','email'])
                ->make(true);
        }
    
        $this->data = array(
            'title' => 'Patients',
        );
  

        return view('admin.patients.index', $this->data);
    }

    /**
     * Use: Insert record for patient 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request) {

        $clinics = ClinicDetails::with('user')->select('id','user_id')->where('is_main_branch',1)->get();
        
        $doctors = DoctorDetails::with('user')->select('id','user_id')->get();

        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){    

            
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();

            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id','receptionist_id')->where('clinic_id',$user_id->clinic_id)->first();

            $patients = PatientDetails::select(array(
            'id','user_id','clinic_id','created_at'
            ))->latest()->with('user')->where('receptionist_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
            
            $doctors = DoctorDetails::with('user')->select('id','user_id')->where('clinic_id',Auth::user()->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
              
        }

        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $clinics = ClinicDetails::with('user')->select('id','user_id')->where('is_main_branch',1)->first();
            $doctors = DoctorDetails::with('user')->where('clinic_id',$user_id->id)->get();
        }
        
        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New patient',
                'clinics'=>$clinics,
                'doctors'=>$doctors,

            );
            $view = view('admin.patients.create', $this->data)->render();
            
            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view,
                    
                ),
            );
        } else {
            $this->data = array(
                'status' => false,
                'message' => 'Something went wrong. Request method is not allowed',
            );
        }
        return response()->json($this->data);
    }

    /**
     * Use: store data of patient 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store( StorePatientRequest $request ) {

        $role = Role::where(['name' => 'Patient'])->first();
        $post_data = $request->validated();

        $clinic_id = 0;
        $doctor_id = 0;

        $user_id = 0;
        $latitude = 0;
        $logitude = 0;

        $clinic_id = ClinicDetails::select('id','user_id')->where('user_id',$request->clinic_id)->first();
        $doctor_id = DoctorDetails::select('id','user_id')->where('user_id',$request->doctor_id)->first();

        $patient = new PatientDetails;
        $users = new User;
        $users->first_name = $post_data['first_name'];
        $users->last_name = $request['last_name'] ?? '';
        $users->email = $post_data['email'];
        $users->phone_no = $post_data['phone_no'];
        $users->name = $role->name;
        $users->assignRole(Role::findOrFail($role->id));
        $users->save();
        $patient->address = $post_data['address'];
        $patient->gender = $request['gender'];
        $patient->admit_date = isset($request['admit_date']) ? Carbon::createFromFormat('d/m/Y',$request['admit_date']) : null;
        $patient->disease_name = $request['disease_name'];
        $patient->patient_number = Str::random(8);
        $patient->allergies = $request['allergies'] ?? '';
        $patient->prescription = $request['prescription'] ?? '';
        $patient->illness = $request['illness'] ?? '';
        $patient->exercise = $request['exercise'] ?? '';
        $patient->alchohol_consumption = $request['alchohol_consumption'] ?? '';
        $patient->diet = $request['diet'] ?? '';
        $patient->smoke = $request['smoke'] ?? '';
        $patient->user_id = $users['id'];
        $patient->height = $request['height'];
        $patient->weight = $request['weight'];
        $patient->blood_group = $request['blood_group'];
        $patient->blood_pressure = $request['blood_pressure'];
        $patient->is_mediclaim_available= $request['is_mediclaim_available'];
        $patient->relation = $request['relation'];
        $patient->relative_name = $request['relative_name'];
        $patient->emergency_contact = $request['emergency_contact'];


        $patient->clinic_id = $request->clinic_id ? $clinic_id->id : Auth::user()->id;
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $patient->receptionist_id = $request->receptionist_id ?? $user_id->id;
            $patient->clinic_id = $user_id->clinic_id;
        }
        if(Auth::user()->hasRole(User::ROLE_DOCTOR)){
            $user_id = DoctorDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $patient->doctor_id = $request->doctor_id ?? $user_id->id;
        }
        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            // $user=Auth::user()->id;
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $doctor_id = DoctorDetails::select('id','user_id')->where('user_id',$request->doctor_id)->first();
            $patient->clinic_id = $request->clinic_id ?? $user_id->id;
            $patient->doctor_id = $request->doctor_id ?? Null;
        }
        if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)) {
            $patient->doctor_id = $request->doctor_id ? $doctor_id->id : Auth::user()->id;
        }
        $patient->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $patient->logitude = $request['logitude'] ? $request['logitude'] : $logitude;
        
        $patient->save();
        $token = $request->_token;

        if($users) {
            // Mail::to($users['email'])->send(new WelcomeMail($users,$request));

            Password::sendResetLink(
                $request->only('email')
            );
            $users->sendEmailVerificationNotification();
            
        }
        return response()->json(
            [
               'status' => true,
               'message' => 'New Patient has been created!'
            ]
        );
    }

    /**
     * Use: Display patients details 
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function show(Request $request, $id) {

        $patient = PatientDetails::select('id','clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('id',$id)->with('user')->first();

        $patientId = PatientDetails::select('id','clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$id)->with('user')->first();

        if($patient){
           $patient_history=DoctorAppointmentDetails::select('id','user_id','patient_id','doctor_id','appointment_date','time_start','time_end'
        ,'disease_name','prescription','weight','blood_pressure','dietplan','next_date')->where('patient_id',$patient?->user_id)->with(['user','doctor.user'])->orderByDesc('id')->get();

        }
        else 
        {
            $patient_history=DoctorAppointmentDetails::select('id','user_id','patient_id','doctor_id','appointment_date','time_start','time_end'
            ,'disease_name','prescription','weight','blood_pressure','dietplan','next_date')->where('patient_id',$patientId?->user_id)->with(['user','doctor.user'])->orderByDesc('id')->get();
              
        }
        
  

        if(Auth::user()->hasRole(User::ROLE_CLINIC)){

            $user_id =PatientDetails::find($id);
        
            if($user_id){

            $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('id',$user_id->id)->with('user')->first();
        }
        else 
        {
         $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$id)->with('user')->first();

        }
}

       
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
             $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('id',$id)->with('user')->first();
             if(!$patient)
             {
                $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$id)->with('user')->first();
        
             }

        }
     
        if(Auth::user()->hasRole(User::ROLE_DOCTOR)){
            $user=DoctorAppointmentDetails::select('id','user_id','patient_id')->where('patient_id',$id)->with('patient')->first(); 
            $user_id = PatientDetails::find($id);
            
            if ($user)
            {
              $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$user->patient_id)->with('user')->first(); 
            } 
            else if ($user_id)
            {
                $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$user_id->user_id)->with('user')->first();

            }
        }


       

        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'View Patient Details',
                'id' => $id,
                'patient' => $patient,
                'patient_history'=>$patient_history
            );
            $view = view('admin.patients.view', $this->data)->render();
            
            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view,
                ),
            );
        } else {
            $this->data = array(
                'status' => false,
                'message' => 'Something went wrong. Request method is not allowed',
            );
        }
        return response()->json($this->data);
    }

    /**
     * Use: Edit form for patient's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {

        $patient = PatientDetails::with('user')->findOrFail($id);
        $clinics = ClinicDetails::with('user')->select('id','user_id')->where('is_main_branch',1)->get();
        $doctors = DoctorDetails::with('user')->select('id','user_id')->get();

        if(Auth::user()->hasRole(User::ROLE_CLINIC)) {
            $doctors = DoctorDetails::with('user')->whereIn('clinic_id', $clinics->pluck('id')->toArray())->get();
        }

        $this->data = array(
            'patient' => $patient,
            'clinics' => $clinics,
            'doctors' => $doctors,
        );

        $view = view('admin.patients.edit', $this->data)->render();
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

     /**
     * Use: Update patient's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePatientRequest $request, $id)
    {
     
        $clinic_id = 0;
        $latitude = 0;
        $logitude = 0;

        $patient = PatientDetails::with('user')->findOrFail($id);
        
        $patient->address = $request->validated()['address'];
        $patient->gender = $request['gender'];
        $patient->admit_date = Carbon::createFromFormat('d/m/Y',$request['admit_date']);;
        $patient->disease_name = $request['disease_name'];
        $patient->allergies = $request['allergies'];
        $patient->illness = $request['illness'];
        $patient->exercise = $request['exercise'];
        $patient->prescription = $request['prescription'];
        $patient->alchohol_consumption = $request['alchohol_consumption'];
        $patient->diet = $request['diet'];
        $patient->smoke = $request['smoke'];
        $patient->height = $request['height'];
        $patient->weight = $request['weight'];
        $patient->blood_group = $request['blood_group'];
        $patient->blood_pressure = $request['blood_pressure'];
        $patient->is_mediclaim_available= $request['is_mediclaim_available'];
        $patient->relation = $request['relation'];
        $patient->relative_name = $request['relative_name'];
        $patient->emergency_contact = $request['emergency_contact'];
        // $patient->clinic_id = isset($request['clinic_id']) ? $request['clinic_id'] : $clinic_id;
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            $patient->receptionist_id = isset($request['receptionist_id']) ? $request['receptionist_id'] : Auth::user()->id;
        }
        // $patient->doctor_id = isset($request['doctor_id']) ? $request['doctor_id'] : Auth::user()->id;
        $patient->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $patient->logitude = $request['logitude'] ? $request['logitude'] : $logitude;
        $patient->save();
        $patient->user()->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'] ?: '',
            'email' => $request['email'],
            'phone_no' => $request['phone_no']],
        );
        
        return response()->json(
             [
               'status' => true,
               'message' => 'Patient has been updated.'
             ]
        );
        return response()->json($response);
        
    }

    /**
     * Use: Delete patient's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request)
    {
        if($request->id){
            $delete_patient = PatientDetails::where('id',$request->id)->first();
        }
       
        if ($delete_patient->delete()) {
            $delete_patientuser = User::where('id',$delete_patient->user_id)->first();
            $delete_patientuser->delete();
            return response()->json([
                'status' => 'Doctor has been deleted!'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong!  Role not found!'
        ]);
  
    }

     /**
     * Use: Get the data of receptionist in CSV file
     * By: DKP
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(Request $request)
    {
        $fileName = 'patients.csv';
        $patients = PatientDetails::with('user')->orderByDesc('created_at')->get();
       
        if(Auth::user()->hasRole(User::ROLE_CLINIC))
        {
            $user_id = ClinicDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $doctorsIds = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
            ))->latest()->with('user')->where('clinic_id',$user_id->id)->pluck('id');
       
            $patients = PatientDetails::select(array(
                'id','user_id','clinic_id','doctor_id','address','admit_date','gender','prescription','allergies','illness','exercise',
                'alchohol_consumption','created_at'
            ))->latest()->with('user')->where('clinic_id',$user_id->id)->orWhere('receptionist_id',$user_id->id)->orWhereIn('doctor_id',$doctorsIds)->get();          
          
        }

        elseif (Auth::user()->hasRole(User::ROLE_DOCTOR))
        {
            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $doctorIds=DoctorDetails::select('id','user_id','clinic_id')->where('clinic_id',$user_id->clinic_id)->pluck('id');         
            $patients=PatientDetails::select(array(
         'id','user_id','clinic_id','created_at','doctor_id','address','admit_date','gender','prescription','allergies','illness','exercise',
         'alchohol_consumption','created_at'
            ))->latest()->with('user')->where('clinic_id',$user_id->clinic_id)->orWhereIn('doctor_id',$doctorIds)->orderByDesc('created_at')->get();
        }


      elseif(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)) {

           $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
           $doctorsIds = DoctorDetails::select(array(
               'id','user_id','clinic_id','status','created_at'
           ))->latest()->with('user')->where('clinic_id',$user_id->clinic_id)->pluck('id');
       
           
           $patients = PatientDetails::select(array(
           'id','user_id','clinic_id','doctor_id','address','admit_date','gender','prescription','allergies','illness','exercise',
           'alchohol_consumption','created_at'
          ))->latest()->with('user')->where('clinic_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->orWhereIn('doctor_id',$doctorsIds)->get();
        }

       
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id','First Name','Gender','Email','Contact No.','Address','Admit Date','Disease Name','Prescription','Allergies','Illness','Exercise','Alcohol Consumption');
        $callback = function() use($patients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($patients as $patient) {
                $row['Id']  = $patient->id;
                $row['First Name']  = $patient->user->first_name;
                $row['Gender']  = $patient->gender;
                $row['Email']  = $patient->user->email;
                $row['Contact No.']  = $patient->user->phone_no;
                $row['Address']  = $patient->address;
                $row['Admit Date']  = $patient->admit_date;
                $row['Disease Name']  = $patient->disease_name;
                $row['Prescription']  = $patient->prescription;
                $row['Allergies']  = $patient->allergies ? $patient->allergies : 'N/A';
                $row['Illness']  = $patient->illness;
                $row['Exercise']  = $patient->exercise;
                $row['Alcohol Consumption']  = $patient->alchohol_consumption;
                 

                fputcsv($file, array($row['Id'],$row['First Name'],$row['Gender'],$row['Email'],$row['Contact No.'],$row['Address'],$row['Admit Date'],$row['Disease Name'],$row['Prescription'],$row['Allergies'],$row['Illness'],$row['Exercise'],$row['Alcohol Consumption']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function fetchDoctors(Request $request)
    {
        $clinic_id = ClinicDetails::where('user_id',$request->clinic_id)->first();
        $data['doctors'] = DoctorDetails::where('clinic_id',$clinic_id?->id)->with('user')->get();
        return response()->json($data);
    }
}
