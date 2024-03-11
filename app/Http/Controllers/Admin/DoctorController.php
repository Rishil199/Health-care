<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorDetails;
use App\Models\PatientDetails;
use App\Models\ReceptionistDetails;
use App\Models\DoctorAppointmentDetails;
use App\Models\User;
use DataTables;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use App\Models\ClinicDetails;
use Auth;

class DoctorController extends Controller
{
    /**
     * Use: Display listing of Doctors.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        
    
        if ($request->ajax()) {
            
            $doctors = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
            ))->latest()->with(['user','clinic'])->get();

            if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
        
                $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();

                $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
               
                $doctors = DoctorDetails::with('user')->where('clinic_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
         
            }
   

            if(Auth::user()->hasRole(User::ROLE_CLINIC)){
                $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
                $doctors = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
                 ))->latest()->with('user')->where('clinic_id',$user_id->id)->get();
                 
            }


            return Datatables::of($doctors)
                ->editColumn('status',function($row){
                    if($row->status == 1){
                        $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" checked></label></div>';
                    }
                    else{
                        $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"></label></div>';
                    }
                    return $status;
                })
                ->editColumn('created_at', function($row) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('dS F, Y h:i A');
                    return $formatedDate;
                })
                ->addColumn('fullname', function($row) {
                    
                    return  '<span class="text-wrap">'. $row->user->first_name.' '.$row->user->last_name.  '<div class="mb-0"></div>' .
                    '<a href="mailto:' . $row->user->email . '?">' . $row->user->email . '</a>'.
                    '</span>';
                })
                ->addColumn('email', function($row) {
                  return $row->clinic? $row->clinic->user->first_name:'';
       
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
                                               <a class="dropdown-item doctor-view" href="javascript:void(0)" data-url="'. route('doctors.view',$row->id) .'" data-id="'. $row->id .'" data-bs-toggle="viewmodal" data-bs-target="#myViewModal" title="View">
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item edit-doctor" href="javascript:void(0)" data-url="'. route('doctors.edit', $row->id) .'" data-id="'. $row->id .'" title="Edit">
                                                  <span class="svg-text">Edit</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="btn btn-delete" title="Delete" >
                                                      <span class="svg-text">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action','status','fullname','email'])
                ->make(true);
        }

        $this->data = array(
            'title' => 'Doctors',
        );

        return view('admin.doctors.index', $this->data);
    }

    /**
     * Use: Insert record for doctor 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request) {

        $clinics = ClinicDetails::select('user_id','id')->where('is_main_branch',1)->with('user')->get();

        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            $receptionist_details = ReceptionistDetails::select('user_id','id','clinic_id')->where('user_id',Auth::user()->id)->with('user')->first();
            $clinics = ClinicDetails::select('user_id','id')->where('is_main_branch',1)->where('id',$receptionist_details->clinic_id)->with('user')->get();
        }

        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New Doctor',
                'clinics'=>$clinics,
            );
            $view = view('admin.doctors.create', $this->data)->render();
            
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
     * Use: store data of doctor 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store( StoreDoctorRequest $request ) {

        $role = Role::where(['name' => 'Doctor'])->first();
        $post_data = $request->validated();
        $clinic_id = 0;
        $latitude = 0;
        $logitude = 0;

        $doctor = new DoctorDetails;
        $users = new User;
       
        //Store user details and assign role
        $users->first_name = $request['first_name'];
        $users->last_name = $request['last_name'];
        $users->email = $request['email'];
        $users->phone_no = $request['phone_no'];
        $users->name = $role->name;
        $users->assignRole(Role::findOrFail($role->id));
        $users->save();

        //Store doctor details
        $doctor->address = $post_data['address'];
        $doctor->status = $request['status'];
        $doctor->gender = $request['gender'];
        $doctor->birth_date = Carbon::createFromFormat('d/m/Y',$request['birth_date']);
        $doctor->degree = $request['degree'];
        $doctor->experience = $request['experience'];
        $doctor->expertice = $post_data['expertice'];
        $doctor->user_id = $users['id'];

         if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            $clinic_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            // $doctor->receptionist_id = $request->receptionist_id ?? Auth::user()->id;
            $doctor->clinic_id = $request['clinic_id'] ? $request['clinic_id'] : $clinic_id->clinic_id;
        }
        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            $clinic_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->pluck('id')->first();

            $doctor->clinic_id = $clinic_id;
    
        }


        if(Auth::user()->hasAnyRole([ User::ROLE_DOCTOR ,User::ROLE_SUPER_ADMIN ,User::ROLE_CLINIC ])){
            $doctor->clinic_id = $request['clinic_id'] ? $request['clinic_id'] : $clinic_id;
        }
        $doctor->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $doctor->logitude = $request['logitude'] ? $request['logitude'] : $logitude;

        $doctor->save();
        
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
               'message' => 'New Doctor has been created!'
            ]
        );
    }

    /**
     * Use: Display doctors details 
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function show(Request $request, $id) {
        if($id) {
            $doctor = DoctorDetails::select('id','clinic_id','user_id','status','address','created_at','birth_date','degree','experience','gender','expertice')->where('id',$id)->with('user')->first();
                if ( $request->ajax() ) {
                    $this->data = array(
                        'title' => 'View Doctor Details',
                        'id' => $id,
                        'doctor' => $doctor,
                    );
                    $view = view('admin.doctors.view', $this->data)->render();
                    
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
        }
        

    /**
     * Use: Edit form for doctor's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        $doctor = DoctorDetails::with('user')->findOrFail($id);
        $clinics = ClinicDetails::select('id','user_id')->with('user')->where('is_main_branch',1)->get();
        $this->data = array(
            'doctor' => $doctor,
            'clinics' => $clinics,
        );

        $view = view('admin.doctors.edit', $this->data)->render();
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }
       
    
     /**
     * Use: Update doctor's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateDoctorRequest $request, $id)
    {

        $clinic_id = 0;
        $user_id = 0;
        $latitude = 0;
        $logitude = 0;
       
        $doctor = DoctorDetails::with('user')->findOrFail($id);
      
        $doctor->address = $request->validated()['address'];
        $doctor->gender = $request['gender'];
        $doctor->birth_date = Carbon::createFromFormat('d/m/Y',$request['birth_date']);
        $doctor->degree = $request->validated()['degree'];
        $doctor->experience = $request->validated()['experience'];
        $doctor->expertice = $request->validated()['expertice'];
        // $doctor->clinic_id = $request['clinic_id'] ? $request['clinic_id'] : $clinic_id;
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            // $doctor->receptionist_id = $request->receptionist_id ?? Auth::user()->id;
        }
        $doctor->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $doctor->logitude = $request['logitude'] ? $request['logitude'] : $logitude;
        $doctor->save();
        try {
            $doctor->user()->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
            'phone_no' => $request['phone_no']],
        );
       
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return "Duplicate entry";
            }
        }
        return response()->json(
             [
               'status' => true,
               'message' => 'Doctor has been updated.'
             ]
        );
        return response()->json($response);
    }

    /**
     * Use: Delete doctor's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request)
    {
        if($request->id){
            $delete_doctor = DoctorDetails::where('id',$request->id)->first();

            if ($delete_doctor->delete()) {
                $delete_doctoruser = User::where('id',$delete_doctor->user_id)->first();
                $delete_doctoruser->delete();
                return response()->json([
                    'status' => 'Doctor has been deleted!'
                ]);
            }
            return response()->json([
                'error' => 'Something went wrong!  Role not found!'
            ]);
        }
       
        
  
    }

     /**
     * Use: Change status of doctor whether it is active or deactive
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $request){
        $doctors_status = DoctorDetails::with('user')->findOrFail($request->doctors_id);
        $doctors_status->status = $request->status;
        $doctors_status->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
       
    
     /**
     * Use: Get the data of doctors in CSV file
     * By: DKP
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(Request $request)
    {
        $fileName = 'Doctor.csv';
        $doctors = DoctorDetails::with('user')->orderByDesc('created_at')->get();
         
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id','First Name','Last Name','Gender','Email','Contact No.','Status','Address','Birth Date','Qualification','Experience','Expertice','Clinic Name');
        
        $clinic_name = DoctorDetails::with('user')->select('clinic_id','id','user_id')->get();
          
        $callback = function() use($doctors, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($doctors as $doctor) {                
                $row['Id']  = $doctor->id;
                $row['First Name']  = $doctor->user->first_name;
                $row['Last Name']  = $doctor->user->last_name;
                $row['Gender']  = $doctor->gender;
                $row['Email']  = $doctor->user->email;
                $row['Contact No.']  = $doctor->user->phone_no;
                $row['Status']  = $doctor->status == 0 ? 'In Active' : 'Active';
                $row['Address']  = $doctor->address;
                $row['Birth Date']  = $doctor->birth_date;
                $row['Qualification']  = $doctor->degree;
                $row['Experience']  = $doctor->experience;
                $row['Expertice']  = $doctor->expertice;
                $row['Clinic Name']  = $doctor->clinic_id;

                fputcsv($file, array($row['Id'],$row['First Name'],$row['Last Name'],$row['Gender'],$row['Email'],$row['Contact No.'],$row['Status'],$row['Address'],$row['Birth Date'],$row['Qualification'],$row['Experience'],$row['Expertice'],$row['Clinic Name']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function doctorsListing(Request $request){

         if ($request->ajax()) {
            
            $authUser= Auth::user();
            $doctors= DoctorAppointmentDetails::select('id','user_id','doctor_id','clinic_id')->where('patient_id',$authUser->id)
            ->pluck('doctor_id');

            if($doctors){
                $doctordetails=DoctorDetails::select('id','user_id')->whereIn('id',$doctors->all())->with('user')->get();             
            }
;
           
            // }
            
            // $doctors = DoctorDetails::select(array(
            //     'id','user_id','clinic_id','status','created_at'
            // ))->latest()->with('user')->get();
            return Datatables::of($doctordetails)
                    ->editColumn('action',function($row){
                        $action = '<a href="javascript:void(0)" class="dropdown-item doctor-view" data-url="' . route('doctors.view',['id' => $row->id]) . '" data-id="' . $row->id . '" data-bs-toggle="viewmodal" data-bs-target="#myViewModal">
                        <i class="bi bi-eye-fill bi-lg" style="color:black;"></i>
                    </a>';
  
                     
                            return $action;
                        })->rawColumns(['action'])->make(true);
        }

        $this->data = array(
            'title' => 'Doctors',
        );

        return view('admin.doctors.index-patient', $this->data);
    }

    public function clinicsListing(Request $request){
         if ($request->ajax()) {
            
            $clinics = ClinicDetails::select(array(
                'id','user_id','clinic_id','status','created_at','is_main_branch','address'
            ))->latest()->with('user')->where([['is_main_branch',1],['status',1]])->get();

            return Datatables::of($clinics)
                    ->editColumn('status',function($row){
                            if($row->status == 1){
                                $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" checked disabled></label></div>';
                            }
                            else{
                                $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" disabled></label></div>';
                            }
                            return $status;
                        })->rawColumns(['status'])->make(true);
        }

        $this->data = array(
            'title' => 'Hospitals',
        );

        return view('admin.patients.index-clinic', $this->data);
    }
}
