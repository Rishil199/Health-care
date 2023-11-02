<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClinicDetails;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use Illuminate\Support\Facades\Password;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use DataTables;
use DB;

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
                    return $row?->user?->first_name . ' ' . $row?->user?->last_name;
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
                                               <a class="dropdown-item view-clinic" href="'. route('clinics.view', $row->id) .'">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item add-branch" href="javascript:void(0)" data-url="'. route('clinics.createBranch',$row->id) .'" data-id="'. $row->id .'" data-toggle="addmodal" data-target="#myAddModal">
                                                  <span class="svg-icon">
                                                     <svg fill="#000000" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 591.6 591.6" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M581.4,244.8H346.8V10.2c0-5.712-4.488-10.2-10.2-10.2H255c-5.712,0-10.2,4.488-10.2,10.2v234.6H10.2 C4.488,244.8,0,249.288,0,255v81.6c0,5.712,4.488,10.2,10.2,10.2h234.6v234.6c0,5.712,4.488,10.2,10.2,10.2h81.6 c5.712,0,10.2-4.488,10.2-10.2V346.8h234.6c5.712,0,10.2-4.488,10.2-10.2V255C591.6,249.288,587.112,244.8,581.4,244.8z M571.2,326.4H336.6c-5.712,0-10.2,4.488-10.2,10.2v234.6h-61.2V336.6c0-5.712-4.488-10.2-10.2-10.2H20.4v-61.2H255 c5.712,0,10.2-4.488,10.2-10.2V20.4h61.2V255c0,5.712,4.488,10.2,10.2,10.2h234.6V326.4z"></path> <path d="M303.96,33.66h-20.4c-2.856,0-5.1,2.244-5.1,5.1v204c0,2.856,2.244,5.1,5.1,5.1s5.1-2.244,5.1-5.1V43.86h15.3 c2.856,0,5.1-2.244,5.1-5.1S306.816,33.66,303.96,33.66z"></path> </g> </g> </g></svg>
                                                  </span>
                                                  <span class="svg-text">Add New Branch</span>
                                               </a>
                                            </li>
                                             <li>
                                               <a class="dropdown-item edit-branch" href="javascript:void(0)" data-url="'. route('clinics.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="addmodal" data-target="#myAddModal">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Edit</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item" href="javascript:delete_main_record(' . $row->id . ');" class="btn btn-delete" title="Delete">
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
                ->rawColumns(['action','status', 'fullname','email'])
                ->make(true);
        }

        $this->data = array(
            'title' => 'Clinics',
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
        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New Branch',
                'id' => $id,
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

        $role = Role::where(['name' => 'Clinic'])->first();
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
        $users->save();
        
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
            Mail::to($users['email'])->send(new WelcomeMail($users,$request));

            Password::sendResetLink(
                $request->only('email')
            );
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

    public function show($id, Request $request) {

        if ($request->ajax()) {

            if($id) {
                $clinics = ClinicDetails::select(array(
                'id','user_id','clinic_id','address','status','created_at','is_main_branch'
            ))->with('user')->where('clinic_id',$id)->latest()->get();

            return Datatables::of($clinics)
                ->addColumn('fullname', function($row) {
                    return $row?->user?->first_name . ' ' . $row?->user?->last_name;
                })
                ->addColumn('email', function($row) {
                    return '<a href="mailto:' . $row->user->email . '">' . $row->user->email . '</a>';
                })
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
                                               <a class="dropdown-item add-branch" href="javascript:void(0)" data-url="'. route('clinics.viewBranch',$row->id) .'" data-id="'. $row->id .'" data-toggle="viewmodal" data-target="#myViewModal">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item edit-branch" href="javascript:void(0)" data-url="'. route('clinics.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="addmodal" data-target="#myAddModal">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Edit</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="btn btn-delete" title="Delete">
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
                ->rawColumns(['action','status', 'fullname', 'email'])
                ->make(true);

            }
            
        }

        $main_clinic = ClinicDetails::select(
                'id','clinic_id','user_id','address','status','created_at','is_main_branch'
             )->where('id',$id)->with('user')->first();

        $this->data = array(
            'title' => 'View Branch Details',
            'id' => $id,
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
        $clinic->status = $post_data['status'];
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
        $clinics = ClinicDetails::with('user')->get();
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
                $row['Id']  = @$clinic->id;
                $row['Name']  = @$clinic->user->first_name;
                $row['Email']  = @$clinic->user->email;
                $row['Contact No.']  = @$clinic->user->phone_no;
                $row['Status'] =  $clinic->status == 0 ? 'In Active' : 'Active';
                $row['Address']  = $clinic->address;
                $row['Branch Type']  = $clinic->is_main_branch == 0 ? 'Sub Branch' : 'Main Branch' ;

                fputcsv($file, array($row['Id'],$row['Name'],$row['Email'],$row['Contact No.'],$row['Status'],$row['Address'],$row['Branch Type']));
            }            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}