<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClinicDetails;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use Illuminate\Support\Facades\Password;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use DataTables;
use DB;
use Auth;
class ClinicController extends Controller
{
    
    /**
     * Use: Display listing of clinic's.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        
        if ($request->ajax()) {
            
            $clinics = ClinicDetails::select(array(
                'id','user_id','clinic_id','status','created_at','is_main_branch'
            ))->latest()->where('is_main_branch',1)->with('user')->get();
           
            
            return Datatables::of($clinics)
                ->editColumn('status',function($row){
                    // if($row->user->email_verified_at==null)
                    // {
                    //     $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id=' . $row->id . '" class="toggle-class form-check-input cursor-pointer" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" disabled></label></div>';
                    // }
                     if($row->status == 1){
                        $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input cursor-pointer" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" checked></label></div>';
                    }
                    else{
                        $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input cursor-pointer" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"></label></div>';
                    }
                    return $status;
                })
                ->editColumn('created_at', function($row) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('dS F, Y h:i A');
                    return $formatedDate;
                })
                ->addColumn('fullname', function($row) {
                    return $row?->user?->first_name . ' ' . $row?->user?->last_name;
                })
                ->addColumn('slug', function($row) {
                    return $row?->user?->slug;
                })
                ->addColumn('email', function($row) {
                    return '<a href="mailto:' . $row->user->email . '">' . $row->user->email . '</a>';
                })
                ->addColumn('action', function($row) {
                    $actionBtn =    '<div class="dropable-btn">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                               <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <li>
                                               <a class="dropdown-item view-clinic" href="'. route('clinics.view', $row->user->slug) .'" title="View">
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item add-branch" href="javascript:void(0)" data-url="'. route('clinics.createBranch',$row->id) .'" data-id="'. $row->id .'" data-toggle="addmodal" data-target="#myAddModal" title="Add" 
                                               id="listing-add-branch">
                                                  <span class="svg-text">Add New Branch</span>
                                               </a>
                                            </li>
                                             <li>
                                               <a class="dropdown-item edit-branch" href="javascript:void(0)" data-url="'. route('clinics.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="addmodal" data-target="#myAddModal"  title="Edit">
                                                  <span class="svg-text">Edit</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item" href="javascript:delete_main_record(' . $row->id . ');"  title="Delete">
                                                      <span class="svg-text">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action','status', 'fullname','email'])
                ->make(true);
        }

        $this->data = array(
            'title' => 'Hospitals',
        );
        return view('admin.clinics.index', $this->data);
    }

    /**
     * Use: Insert record for main branch 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function createMainBranch(Request $request) {
        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add Main Branch',
            );
            $view = view('admin.clinics.add-main-branch', $this->data)->render();
            
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
     * Use: Insert record for sub branch 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function createBranch(Request $request, $id) {
        if($id)
        {
            $clinic = ClinicDetails::select('id','user_id','clinic_id','status','address','created_at')->where('id',$id)->with('user')->first();
           
       
        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New Branch',
                'id' => $id,
                'clinic'=>$clinic,
            );
            
            
            $view = view('admin.clinics.add-branch', $this->data)->render();
            
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
     * Use: Display sub branch details 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function viewBranch(Request $request, $id) {
        
        if($id) {
              $clinic = ClinicDetails::select('id','user_id','clinic_id','status','address','created_at')->where('id',$id)->with('user')->first();
             
            if ( $request->ajax() ) {
                $this->data = array(
                    'title' => 'View Branch Details',
                    'id' => $id,
                    'clinic' => $clinic,
                );
                $view = view('admin.clinics.view-branch', $this->data)->render();
                
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
     * Use: store data of clinic 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store( StoreClinicRequest $request ) {

        $role = Role::where(['name' => 'Hospital'])->first();
        $post_data = $request->validated();
        $clinic_id = 0;
        $latitude = 0;
        $logitude = 0;

        $clinic = new ClinicDetails;
        $users = new User;
        
        //Store user details and assign role
        $users->first_name = $request['first_name'];
        $users->last_name = $request['last_name'] ? $request['last_name'] : '';
        $users->email = $request['email'];
        $users->phone_no = $request['phone_no'];
        $users->name = $role->name;
        $users->assignRole(Role::findOrFail($role->id));
        $users->slug=Str::slug( $request['first_name']);
        $users->save();
        $uid=$users->id;
        
        //store clinic details
        $clinic->address = $post_data['address'];
        $clinic->status = $request['status'];
        $clinic->user_id = $users['id'];
        $clinic->is_main_branch = $request['clinic_id'] ? 0 : 1;
        $clinic->clinic_id = $request['clinic_id'] ? $request['clinic_id'] : $clinic_id;
        $clinic->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $clinic->logitude = $request['logitude'] ? $request['logitude'] : $logitude;
        $clinic->save();
       
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
               'message' => 'New Clinic has been created!'
            ]
        );
    }

     /**
     * Use: Display main branch details and the listing of sub-branches
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function show($slug='', Request $request) {
  
        $user = User::where('slug', $slug)->firstOrFail();
        
        if ($request->ajax()) {
            if($slug) {
                $clinics = ClinicDetails::select(array(
                'id','user_id','clinic_id','address','status','created_at','is_main_branch'
            ))->with('user')->where('user_id',$user->id)->latest()->first();

            $branches= ClinicDetails::select(
                'id','clinic_id','user_id','address','status','created_at','is_main_branch'
             )->where('clinic_id',$clinics->id)->with('user')->orderByDesc('created_at')->get();
             
         
            return Datatables::of($branches)
                ->addColumn('fullname', function($row) {
                    return $row?->user?->first_name . ' ' . $row?->user?->last_name;
                })
                ->addColumn('email', function($row) {
                    return '<a href="mailto:' . $row->user->email . '">' . $row->user->email . '</a>';
                })
                ->addColumn('address', function($row) {
                    return $row->address;
                })
                // ->editColumn('status',function($row){
                //     if($row->status == 1){
                //         $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" checked></label></div>';
                //     }
                //     else{
                //         $status = '<div class="form-check form-switch form-switch-md"><label class="switch"><input data-id='. $row->id .'" class="toggle-class form-check-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"></label></div>';
                //     }
                //     return $status;
                // })
                ->editColumn('created_at', function($row) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('dS F, Y h:i A');
                    return $formatedDate;
                })
                ->addColumn('action', function($row) {
                    $actionBtn =    '<div class="dropable-btn">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                               <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                            </button>
                                            <ul class="dropdown-menu">';
                                            if (Auth::user()->hasAnyRole([User::ROLE_SUPER_ADMIN,User::ROLE_PATIENT])) 
                                            $actionBtn .= '<li>
                                            <a class="dropdown-item add-branch" href="javascript:void(0)" data-url="'. route('clinics.viewBranch',$row->id) .'" data-id="'. $row->id .'" data-toggle="viewmodal" data-target="#myViewModal">
                                                <span class="svg-text">View</span>
                                            </a>
                                        </li>'; // Add this closing li tag
                                        
                                            if (Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))
                                            $actionBtn .= '<li>
                                               <a class="dropdown-item edit-branch" href="javascript:void(0)" data-url="'. route('clinics.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="addmodal" data-target="#myAddModal">
                                                  <span class="svg-text">Edit</span>
                                               </a>
                                            </li>
                                           <li>
                                               <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="btn btn-delete" title="Delete">
                                                      <span class="svg-text">Delete</span>
                                                    </a>
                                                    </li>';
                                                    // if (Auth::user()->hasRole(User::ROLE_PATIENT))
                                        //               $actionBtn .= '<li>
                                        //               <a class="dropdown-item" href="javascript:void(0)" data-url="'. route('patient.BookClinic',$row->id) .'" data-id="'. $row->id .'">
                                        //               <svg width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 409.6 409.6" style="enable-background:new 0 0 409.6 409.6;" xml:space="preserve">
                                        //               <g>
                                        //                   <path d="M410.4,292.8c-2,4-5.3,5-9.6,5c-20.3-0.1-40.5-0.1-60.8-0.1c-1.4,0-2.9,0-4.8,0c0,1.8,0,3.2,0,4.6
                                        //                   c0,15.9,0,31.7,0,47.6c0,7.1-2.2,9.3-9.4,9.3c-80.1,0-160.2,0-240.4,0c-7.4,0-9.6-2.1-9.6-9.5c0-15.7,0-31.5,0-47.2
                                        //                   c0-1.4,0-2.9,0-4.8c-1.8,0-3.2,0-4.6,0c-20.4,0-40.8,0-61.2,0c-7.2,0-9.3-2.2-9.3-9.3c0-11.9-0.1-23.7,0-35.6
                                        //                   c0.4-42.6,19.2-74.2,56.8-94.4c0.7-0.4,1.4-0.8,1.7-0.9c-3.9-6.1-8.4-11.8-11.5-18.1C29.8,102.6,54,58.1,94.6,52.7
                                        //                   c14-1.9,27,0.8,39.3,7.6c4,2.2,5.4,5.8,3.7,9.3c-1.7,3.6-5.7,5-9.8,2.8c-10.2-5.4-20.8-7.8-32.4-6.1c-22,3.3-39.1,22.8-40,45.9
                                        //                   C54.6,134.5,71,155.6,92.6,160c7.6,1.5,15.1,1.5,22.6-0.3c5-1.2,8.6,0.6,9.6,4.5c1,4.2-1.5,7.4-6.6,8.6c-14.7,3.5-28.8,2-42.3-4.7
                                        //                   c-1.6-0.8-4.2-0.9-5.9-0.1c-34.2,14.9-52.8,41.1-55.3,78.3c-0.8,12.3-0.1,24.7-0.1,37.4c20.7,0,41.3,0,61.9,0
                                        //                   c6.7-47.9,31.9-82.4,75.3-104.2c-17.6-19.4-24.8-41.9-19.7-67.7c3.5-17.7,12.6-32.5,27-43.6c30.8-23.8,72.4-21.2,99.5,5.7
                                        //                   c26.7,26.5,31.6,72.7,0.9,105.6c43.2,21.6,68.3,56.3,75.2,104.3c20.4,0,40.9,0,61.5,0c0.1-0.1,0.5-0.3,0.5-0.5
                                        //                   c-0.4-19.6,2.3-39.5-3.7-58.8c-8.4-26.9-25.7-45.9-51.9-56.6c-1.6-0.6-4-0.5-5.5,0.2c-13.7,6.8-27.9,8.3-42.7,4.7
                                        //                   c-4.9-1.2-7.3-4.3-6.4-8.4c0.8-4,4.5-5.9,9.4-4.8c26.9,5.6,50.4-7.8,58-33c5.4-17.8-0.6-37.9-15.3-49.8
                                        //                   c-15.7-12.6-33-14.5-51.3-6.3c-1.7,0.8-3.3,1.7-5.1,2.4c-3.5,1.3-6.9,0-8.5-3.1c-1.6-3.1-0.9-7,2.5-8.7c5.3-2.7,10.8-5.4,16.5-6.9
                                        //                   c27.1-7,53.8,4.2,68.3,28.3c13.7,22.7,10.6,51.9-7.8,72.3c-0.6,0.7-1.2,1.4-1.5,1.8c7,4.7,14.3,8.8,20.8,14
                                        //                   c21.6,17.5,33.9,40.3,37.2,67.9c0.1,1,0.5,2,0.7,3C410.4,258.7,410.4,275.7,410.4,292.8z M321.5,345.4c0.1-1.1,0.1-2,0.1-2.9
                                        //                   c0-15.2,0.5-30.4-0.1-45.6c-2-49.6-25.8-85-70.9-105.9c-2.4-1.1-4.3-1.1-6.6,0.3c-9,5.8-18.9,9.1-29.5,10.3
                                        //                   c-17,2-32.8-1.4-47.5-10.2c-1.3-0.8-3.4-1.4-4.6-0.9c-15.3,6-28.9,14.9-40.2,26.8c-22.2,23.3-32.8,51.2-32.6,83.3
                                        //                   c0.1,13.5,0,26.9,0,40.4c0,1.4,0,2.9,0,4.5C167,345.4,244,345.4,321.5,345.4z M205.1,188.5c33.2,0.7,61.3-26.8,62-60.7
                                        //                   c0.7-33.3-26.7-61.5-60.6-62.1c-33.7-0.7-61.6,26.6-62.4,60.7C143.4,159.8,170.8,187.8,205.1,188.5z" fill="#545a6d"></path>
                                        //               </g>
                                        //           </svg>
                                        //             <span class="svg-text cursor-pointer"> Book Appointment</span>
                                        //             </a>
                                        //             </li>
                                        //     </ul>
                                        // </div>
                                    // </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action','status','address','fullname', 'email'])
                ->make(true);

            }
            
        }


        $main_clinic = ClinicDetails::select(
                'id','clinic_id','user_id','address','status','created_at','is_main_branch'
             )->where('user_id',$user->id)->with('user')->first();
            
         

        $this->data = array(
            'title' => 'View Branch Details',
            'slug' => $slug,
            'main_clinic' => $main_clinic,

        );
        
        return view('admin.clinics.view', $this->data);
    }

     /**
     * Use: Edit form for clinic's data for main and sub branch
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $id) {
        $clinic = ClinicDetails::with('user')->findOrFail($id);

        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New Branch',
                'id' => $id,
                'clinic' => $clinic,
            );
            $view = view('admin.clinics.edit-branch', $this->data)->render();
            
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
     * Use: Update clinic's data for main and sub branch
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateClinicRequest $request, $id){

        $clinic = ClinicDetails::with('user')->findOrFail($id);
        $sub_branch = ClinicDetails::select('id','clinic_id','user_id')->where('clinic_id',$clinic->clinic_id)->with('user')->get();

        $main_branch = ClinicDetails::select('id','clinic_id','is_main_branch','user_id')->where('id',$clinic->clinic_id)->with('user')->first();

        if($request->branch_type == 1) {
            $main_branch->is_main_branch = 0;
            $main_branch->clinic_id = $clinic->id;
            $main_branch->save();
            foreach($sub_branch as $sub_branches) {                
                $update_branch = ClinicDetails::where('clinic_id',$sub_branches->clinic_id)->where('clinic_id','!=',$id)->with('user')->first();
               
                 if($id){
                    $update_branch->clinic_id = 0;                
                    $update_branch->is_main_branch = 1;    
                    $update_branch->save();            
                }
                
                if($update_branch->id != $id){
                    $update_branch->is_main_branch = 0;
                    $update_branch->clinic_id = $clinic->id;
                    $update_branch->save();
                }
            }
        }

        $post_data = $request->validated();
        $clinic->address = $post_data['address'];
        // $clinic->status = $post_data['status'];
        $clinic->save();

        $clinic->user()->update([
            'first_name' => $request['first_name'] ?? '',
            'last_name' => $request['last_name'] ?? '',
            'email' => $request['email'],
            'phone_no' => $request['phone_no']],
        );

        
        return response()->json(
             [
               'status' => true,
               'message' => 'Clinic has been updated.'
             ]
        );

        return response()->json($response);
    }

    /**
     * Use: Delete main and related sub-branches
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request) {
        if($request->id) {
            $delete_clinic = ClinicDetails::select('id','user_id')->where('id',$request->id)->first();

            $delete_branch = ClinicDetails::select('id','user_id')->where('clinic_id',$delete_clinic->id)->get();

            foreach($delete_branch as $dlt_brnch) {
                $id = $dlt_brnch->id;
                $user_id = $dlt_brnch->user_id;
                
                $delete = ClinicDetails::whereIn('id',[$id])->delete();
                
                if ($delete) {
                    $delete_user = User::whereIn('id',[$user_id])->delete();
                }
            }
            
            if ($delete_clinic->delete()) {
                $delete_clinicuser = User::where('id',$delete_clinic->user_id)->first();
                $delete_clinicuser->delete();
                return response()->json([
                    'status' => 'Clinic has been deleted!'
                ]);
            }
            
            return response()->json([
                'error' => 'Something went wrong!  Clinic not found!'
            ]);    
        }
        }
        

    /**
     * Use: Delete single sub-branch
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroyBranch(Request $request) {

        $delete_clinic = ClinicDetails::where('id',$request->id)->first();

        if ($delete_clinic->delete()) {
            $delete_clinicuser = User::where('id',$delete_clinic->user_id)->first();
            $delete_clinicuser->delete();
            return response()->json([
                'status' => 'Clinic has been deleted!'
            ]);
        }

        return response()->json([
            'error' => 'Something went wrong!  Role not found!'
        ]);
    }

     /**
     * Use: Change status of clinic whether it is active or deactive
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function changeStatus(Request $request){
        $clinic_status = ClinicDetails::findOrFail($request->clinic_id);
        $clinic_status->status = $request->status;
        $clinic_status->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }

     /**
     * Use: Get the data of clinics in CSV file
     * By: DKP
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(Request $request)
    {
        $fileName = 'Clinic.csv';
        $clinics = ClinicDetails::with('user')->orderByDesc('created_at')->get();
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id','Name','Email','Contact No.','Status','Address','Branch Type');

        $callback = function() use($clinics, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($clinics as $clinic) {
                $row['Id']  = $clinic?->id;
                $row['Name']  = $clinic?->user?->first_name;
                $row['Email']  = $clinic?->user?->email;
                $row['Contact No.']  = $clinic?->user?->phone_no;
                $row['Status'] =  $clinic?->status == 0 ? 'In Active' : 'Active';
                $row['Address']  = $clinic?->address;
                $row['Branch Type']  = $clinic?->is_main_branch == 0 ? 'Sub Branch' : 'Main Branch' ;

                fputcsv($file, array($row['Id'],$row['Name'],$row['Email'],$row['Contact No.'],$row['Status'],$row['Address'],$row['Branch Type']));
            }            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    
}