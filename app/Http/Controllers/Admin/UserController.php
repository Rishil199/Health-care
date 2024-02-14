<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscriptions;
use App\Models\DoctorDetails;
use App\Models\ClinicDetails;
use App\Models\PatientDetails;
use App\Models\ReceptionistDetails;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use DataTables;
use App\Models\DoctorAppointmentDetails;
use Illuminate\Support\Facades\Password;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Use: Call main dashboard
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function dashboard() {
        $clinicCount = count(ClinicDetails::get());

        $clinics=ClinicDetails::where('user_id',Auth::user()->id)->get();
 
    $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();

    $dct = DoctorDetails::select('clinic_id','user_id')->where('user_id',Auth::user()->id)->first();

        if (Auth::user()->hasRole(User::ROLE_DOCTOR)){
            $doctors = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
                 ))->latest()->with('user')->where('clinic_id',$dct->id)->get();
        }
        if (Auth::user()->hasRole(User::ROLE_CLINIC)){
            $doctors = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
                 ))->latest()->with('user')->where('clinic_id',$user_id->id)->get();
        }
   
     
        if(Auth::user()->hasAnyRole([User::ROLE_DOCTOR,User::ROLE_RECEPTIONIST,User::ROLE_CLINIC]))
        {
            if (Auth::user()->hasRole(User::ROLE_CLINIC)){
            $receptionistCount = count(ReceptionistDetails::where('clinic_id',$user_id->id)->get());
            }
            if (Auth::user()->hasRole(User::ROLE_DOCTOR)){
                $receptionistCount = count(ReceptionistDetails::where('clinic_id',$dct->id)->get());
                }
          
            $receptionistCount = count(ReceptionistDetails::get());
        }

        $clinic_details = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
        $rct = ReceptionistDetails::select('clinic_id','user_id')->where('clinic_id',@$clinic_details->id)->first();
        $rt = ReceptionistDetails::select('clinic_id','user_id')->where('clinic_id',Auth::user()->id)->first();
               
        $appointmentsCount = count(DoctorAppointmentDetails::withTrashed()->get());  
        
        
        $date = today()->format('Y-m-d');
          
        $todays_appointment = count(DoctorAppointmentDetails::where('appointment_date','=',$date)->where('is_complete','=','0')->withTrashed()->get());

        $upcoming_appointment = count(DoctorAppointmentDetails::where('appointment_date','>',$date)->withTrashed()->get());
        
        $past_appointment = count(DoctorAppointmentDetails::where('is_complete','=','1')->withTrashed()->get());

        if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)) {

            $appointments = DoctorAppointmentDetails::with('user')->latest()->get();
        
            $patients = PatientDetails::select(array(
                'id','user_id','created_at'
            ))->latest()->with('user')->get();
   
            $doctors = DoctorDetails::select(array(
                'id','user_id','created_at'
            ))->latest()->with('user')->get();
 
            $receptionistCount = count(ReceptionistDetails::get());
        }

      
        if(Auth::user()->hasRole(User::ROLE_DOCTOR)){
            $user=(Auth::user());

            $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',$user->id)->first();
          
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
           
            $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at','doctor_id'
                 ))->latest()->with('user')->where('doctor_id',$user_id->id)->get();
               
            $appointments = DoctorAppointmentDetails::with('user')->where('doctor_id',$user_id->id)->latest()->get();
         
            $appointmentsCount = count(DoctorAppointmentDetails::where('doctor_id',$user_id->id)->withTrashed()->get()); 
          
            $todays_appointment = DoctorAppointmentDetails::where('appointment_date','=',$date)->where('is_complete','=','0')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id);
                })->get()->count();
           
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id);
                })->get()->count();
           
            $past_appointment = DoctorAppointmentDetails::where('is_complete','=','1')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('doctor_id',$user_id->id);
                })
                ->where('disease_name','!=','')->get()->count();
        }

        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
         
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
            $patients = PatientDetails::select(array(
                'id','user_id','created_at','doctor_id'
            ))->latest()->with('user')->where('clinic_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
            // $patients = PatientDetails::select(array(
            //     'id','user_id','created_at','doctor_id'
            // ))->latest()->with('user')->where('clinic_id',$user_id->id)->get();
    
            $appointments = DoctorAppointmentDetails::with('user')->where('receptionist_id',$user_id->id)->orWhere('clinic_id',@$clinic_user_id->clinic_id)->latest()->get();
            $appointmentsCount = count(DoctorAppointmentDetails::where('receptionist_id',$user_id->id)->orWhere('clinic_id',@$clinic_user_id->clinic_id)->withTrashed()->get());
            $todays_appointment = DoctorAppointmentDetails::where('appointment_date','=',$date)->where('is_complete','=','0')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })->get()->count();  
           
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })->get()->count();
 
            $past_appointment = DoctorAppointmentDetails::where('is_complete','=','1')->with('user')->withTrashed()
                ->where(function ( $query ) use ($clinic_user_id, $user_id) {
                    $query->where('receptionist_id',$user_id->id)
                        ->orWhere('clinic_id', @$clinic_user_id->clinic_id);
                })
                ->where('disease_name','!=','')->get()->count();

            $doctors = DoctorDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
            ))->latest()->with('user')->where('clinic_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
        }
     

        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            
            // $doctors = DoctorDetails::select(array(
            //     'id','user_id','clinic_id','status','created_at'
            // ))->latest()->with('user')->where('cliic_id',$user_id->id)->get();
       
            
            $patients = PatientDetails::select(array(
                'id','user_id','created_at','doctor_id'
            ))->latest()->with('user')->where('clinic_id',$user_id->id)->get();
            
            $receptionistCount = count(ReceptionistDetails::where('clinic_id',$user_id->id)->get());
          
            
            $appointments = DoctorAppointmentDetails::with('user')->where('clinic_id',$user_id->id)->latest()->get();
            $appointmentsCount = count(DoctorAppointmentDetails::where('clinic_id',$user_id->id)->withTrashed()->get());
            $todays_appointment = count(DoctorAppointmentDetails::where('appointment_date','=',$date)->where('is_complete','=','0')->where('clinic_id',$user_id->id)->withTrashed()->get());
            $upcoming_appointment = count(DoctorAppointmentDetails::where('appointment_date','>',$date)->where('clinic_id',$user_id->id)->withTrashed()->get());
            $past_appointment = count(DoctorAppointmentDetails::where('is_complete','=','1')->where('clinic_id',$user_id->id)->withTrashed()->get());
        }

      
         if(Auth::user()->hasRole(User::ROLE_PATIENT)){

            $user_id = PatientDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $patients = PatientDetails::select(array(
                'id','user_id','created_at','doctor_id'
            ))->latest()->with('user')->where('id',$user_id->id)->get();
        
            // $doctors = DoctorDetails::select(array(
            //     'id','user_id','created_at','clinic_id'
            // ))->latest()->with('user')->where('id',$user_id->id)->get();
            // $doctors = DoctorDetails::select(array(
            //     'id','user_id','clinic_id','status','created_at'
            // ))->latest()->with('user')->get();
          
            $authUser= Auth::user();        
            $doctordetails= DoctorAppointmentDetails::select('id','user_id','doctor_id','clinic_id')->where('patient_id',$authUser->id)
            ->pluck('doctor_id');
           
            if($doctordetails){
                $doctors=DoctorDetails::select('id','user_id')->whereIn('id',$doctordetails->all())->with('user')->get();   
      
            }


            $appointments = DoctorAppointmentDetails::with('user')->withTrashed()->where('patient_id',Auth::user()->id)->get();
            
            $appointmentsCount = DoctorAppointmentDetails::with('user')->withTrashed()->where('patient_id',Auth::user()->id)->count();
            
            $todays_appointment = DoctorAppointmentDetails::where('appointment_date','=',$date)->with('user')->withTrashed()->where('patient_id',Auth::user()->id)->where('is_complete','=','0')->count();
            
            $upcoming_appointment = DoctorAppointmentDetails::where('appointment_date','>',$date)->withTrashed()->where('is_complete','=','0')->with('user')->where('patient_id',Auth::user()->id)->count();
            
            $past_appointment = DoctorAppointmentDetails::where('is_complete', 1)->withTrashed()->with('user')->where('patient_id',Auth::user()->id)->count();
        }


        if(Auth::user()->hasRole(User::ROLE_PATIENT)){
          $this->data = array(
                'title' => 'Dashboard',
                'doctors' => $doctors,
                'appointments' => $appointments,
                'appointmentsCount' => $appointmentsCount,
                'todays_appointment' => $todays_appointment,
                'upcoming_appointment' => $upcoming_appointment,
                'past_appointment' => $past_appointment,
            );   
        }

    
                if(Auth::user()->hasAnyRole([User::ROLE_SUPER_ADMIN,User::ROLE_DOCTOR,User::ROLE_RECEPTIONIST,User::ROLE_CLINIC])){
                 $this->data = array(
                'title' => 'Dashboard',
                'clinicCount' => $clinicCount,
                'clinics'=>$clinics,
                'patients' => $patients,
                'receptionistCount' => $receptionistCount,
                'doctors' => $doctors,
                'appointments' => $appointments,
                'appointmentsCount' => $appointmentsCount,
                'todays_appointment' => $todays_appointment,
                'upcoming_appointment' => $upcoming_appointment,
                'past_appointment' => $past_appointment,
                 ); 
    
                }
                return view('admin.dashboard',$this->data);
      


    }

     /**
     * Use: Display listing of Users.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        $role_name = User::ROLE_SUPER_ADMIN;

        if ($request->ajax()) {
            $users = User::select('id','first_name','last_name','name','email','created_at')->whereNotIn('name',[$role_name])->latest()->get();
            $role = Role::select('id','name')->get();
            
            return Datatables::of($users)
                ->editColumn('name', function($data){ 
                    $role_name =   Role::select('id','name')->where('id',$data->name)->first();
                    return $role_name['name']; 
                })
                ->editColumn('created_at', function($data){ 
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format(' dS F, Y h:i A'); return $formatedDate; 
                })
                ->editColumn('first_name', function($data){ 
                    $fullname = $data->first_name.' '.$data->last_name; return $fullname; 
                })
                ->addColumn('action', function($row){
                    $actionBtn =    '<div class="dropable-btn dropleft">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                               <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <li>
                                               <a class="dropdown-item edit-user" href="javascript:void(0)" data-url="'. route('users.edit', $row->id) .'" data-id="'. $row->id .'"  data-toggle="editmodal" data-target="#myEditModal">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Edit</span>
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
                                                      <span class="svg-text">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                            return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $this->data = array(
            'title' => 'Users',
        );

        return view('admin.users.index',$this->data);
    }

    /**
     * Use: Insert record for user 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function createUser(Request $request) {
        $role_name = User::ROLE_SUPER_ADMIN;
        $roles = Role::whereNotIn('name',[$role_name])->get();

        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New User',
                'roles' => $roles,
            );
            $view = view('admin.users.add-user', $this->data)->render();
            
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
     * Use: Store data of user
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store( StoreUserRequest $request) {
        $store_data = $request->validated();

        $store_data['name'] = $store_data['roles_type'];
       
        $token = $request->_token;

        $user = User::create($store_data);

        $user->assignRole(Role::findOrFail($request->roles_type));
   
        if($user) {
            // Mail::to($user['email'])->send(new WelcomeMail($user,$request));

            Password::sendResetLink(
                $request->only('email')
            );
        }

        return response()->json(
            [
               'status' => true,
               'message' => 'User has been created!'
            ]
        );
    }

     /**
     * Use: Edit form for user's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        $users = User::findfindOrFail($id);

        $role_name = User::ROLE_SUPER_ADMIN;
        
        $roles = Role::whereNotIn('name',[$role_name])->get();
            
        $view = view('admin.users.edit', compact(['users','roles']))->render();
        
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

    /**
     * Use: Update uers's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateUserRequest $request, $id) {
        $users = User::findfindOrFail($id);

        $users['name'] = $request->validated()['roles_type'];
        $users['first_name'] = $request->validated()['first_name'];
        $users['last_name'] = $request->validated()['last_name'];
        $users['email'] = $request->validated()['email'];
            
        $users->save();

        $users->assignRole(Role::findfindOrFail($request->roles_type));

        return response()->json(
             [
               'status' => true,
               'message' => 'User has been updated.'
             ]
        );
        return response()->json($response);
    }

    /**
     * Use: Delete uers's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request)
    {
        $delete_role = User::where('id',$request->id)->first();

        if ($delete_role->delete()) {

            return response()->json([
                'status' => 'User has been deleted!'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong!  Role not found!'
        ]);
  
    }

    /**
     * Use: change password for a role
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function changePassword(Request $request)
    {
        return view('change-password');
    }

    /**
     * Use: update password for a role
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function changeProfile(Request $request)
    {
        $users = User::where('id',Auth::user()->id)->first();

        return view('change-profile',compact('users'));
    }

    /**
     * Use: update password for a role
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function updateProfile(Request $request)
    {

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'] ? $request['last_name'] : '',
            'email' => $request['email'],
            'phone_no' => $request['phone_no'],

        ]);

        return back()->with("status", "Profile Updated successfully!");
    }

    public function subscriptionStore(Request $request) {
        $validatedData = $request->validate([
          'email' => 'required|unique:subscriptions,email',
        ]);
        $subscription = new Subscriptions;
        $subscription->email = $request['email'];
        $subscription->contact_date = $request['contact_date'];
        
        if($subscription->save()){
            return redirect()->back()->with('success','Subscription set successfully!');
        }else{
            return redirect()->back()->with('error','Subscription not set successfully');
        } 

    }
}
