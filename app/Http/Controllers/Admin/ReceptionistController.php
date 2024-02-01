<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceptionistDetails;
use App\Models\User;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreReceptionistRequest;
use App\Http\Requests\UpdateReceptionistRequest;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use Auth;
use App\Models\ClinicDetails;

class ReceptionistController extends Controller
{
    /**
     * Use: Display listing of receptionist.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
    // dd("dd");
        if ($request->ajax()) {
           
            $receptionist = ReceptionistDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
            ))->latest()->with('user')->get();
            // dd($receptionist);

            if(Auth::user()->hasRole(['Hospital'])){
                $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
                // dd($user_id);
                $receptionist = ReceptionistDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
                 ))->latest()->with('user')->where('clinic_id',$user_id->id)->get();
                //  dd($receptionist);
            }

            return Datatables::of($receptionist)
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
                                               <a class="dropdown-item receptionists-view" href="javascript:void(0)" data-url="'. route('receptionists.view',$row->id) .'" data-id="'. $row->id .'" data-bs-toggle="viewmodal" data-bs-target="#myViewModal">
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
                                               <a class="dropdown-item edit-receptionists" href="javascript:void(0)" data-url="'. route('receptionists.edit', $row->id) .'" data-id="'. $row->id .'">
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
                ->rawColumns(['action','status','fullname','email'])
                ->make(true);
        }

        $this->data = array(
            'title' => 'Staff',
        );

        return view('admin.receptionist.index', $this->data);
    }

    /**
     * Use: Insert record for receptionist 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request) {

        $clinics = ClinicDetails::select('user_id','id')->where('is_main_branch',1)->with('user')->get();

        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New Receptionist',
                'clinics'=>$clinics,
            );
            $view = view('admin.receptionist.create', $this->data)->render();
            
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
     * Use: store data of receptionist 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store( StoreReceptionistRequest $request ) {
        $role = Role::where(['name' => 'Receptionist'])->first();
        $post_data = $request->validated();
        $clinic_id = 0;
        $latitude = 0;
        $logitude = 0;

        $receptionist = new ReceptionistDetails;
        $users = new User;
        $users->first_name = $request['first_name'];
        $users->last_name = $request['last_name'];
        $users->email = $request['email'];
        $users->phone_no = $request['phone_no'];
        $users->name = $role->name;
        $users->assignRole(Role::findOrFail($role->id));
        $users->save();
        $receptionist->status = $request['status'];
        $receptionist->gender = $request['gender'];
        $receptionist->birth_date = Carbon::parse($request['birth_date'])->format('Y-m-d h:i');
        $receptionist->qualification = $request['qualification'];
        $receptionist->experience = $request['experience'];
        $receptionist->user_id = $users['id'];
        if(Auth::user()->hasRole(['Hospital'])){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $receptionist->clinic_id = $user_id->id;
        }
        if(Auth::user()->hasRole(['Super Admin'])){
           $receptionist->clinic_id = $request->clinic_id;
        }
        $receptionist->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $receptionist->logitude = $request['logitude'] ? $request['logitude'] : $logitude;

        $receptionist->save();
        $token = $request->_token;

        if($receptionist) {
            // Mail::to($users['email'])->send(new WelcomeMail($users,$request));
            Password::sendResetLink(
                $request->only('email')
            );
        }

        return response()->json(
            [
               'status' => true,
               'message' => 'New receptionist has been created!'
            ]
        );
    }

    /**
     * Use: Display receptionist details 
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function show(Request $request, $id) {
        $receptionist = ReceptionistDetails::select('id','clinic_id','user_id','status','created_at','birth_date','qualification','experience','gender')->where('id',$id)->with('user')->first();
        
        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'View Receptionist Details',
                'id' => $id,
                'receptionist' => $receptionist,
            );
            $view = view('admin.receptionist.view', $this->data)->render();
            
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
     * Use: Edit form for receptionist's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        
        $receptionist = ReceptionistDetails::with('user')->findOrFail($id);
        $clinics = ClinicDetails::select('id','user_id')->where('is_main_branch',1)->with('user')->get();
        
        $this->data = array(
            'receptionist' => $receptionist,
            'clinics' => $clinics,
        );

        $view = view('admin.receptionist.edit', $this->data)->render();
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

     /**
     * Use: Update receptionist's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateReceptionistRequest $request, $id)
    {
        $clinic_id = 0;
        $user_id = 0;
        $latitude = 0;
        $logitude = 0;

        $receptionist = ReceptionistDetails::with('user')->findOrFail($id);
        $receptionist->status = $request['status'];
        $receptionist->gender = $request['gender'];
        $receptionist->birth_date = Carbon::parse($request->validated()['birth_date'])->format('Y-m-d h:i');
        $receptionist->qualification = $request->validated()['qualification'];
        $receptionist->experience = $request->validated()['experience'];
        $receptionist->clinic_id = $request['clinic_id'] ? $request['clinic_id'] : $clinic_id;
        $receptionist->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $receptionist->logitude = $request['logitude'] ? $request['logitude'] : $logitude;

        $receptionist->save();
        $receptionist->user()->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone_no' => $request['phone_no']],
        );

        return response()->json(
             [
               'status' => true,
               'message' => 'Receptionist has been updated.'
             ]
        );
        return response()->json($response);
    }

    /**
     * Use: Delete receptionist's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request)
    {
        $delete_receptionist = ReceptionistDetails::where('id',$request->id)->with('user')->first();
       
        if ($delete_receptionist->delete()) {
            $delete_receptionistuser = User::where('id',$delete_receptionist->user_id)->first();
            $delete_receptionistuser->delete();
            return response()->json([
                'status' => 'Receptionist has been deleted!'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong!  Role not found!'
        ]);
  
    }

     /**
     * Use: Change status of receptionist whether it is active or deactive
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $request){
        $receptionist_status = ReceptionistDetails::with('user')->findOrFail($request->receptionist_id);
        $receptionist_status->status = $request->status;
        $receptionist_status->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }

     /**
     * Use: Get the data of receptionist in CSV file
     * By: DKP
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(Request $request)
    {
        $fileName = 'Receptionists.csv';
        $receptionists = ReceptionistDetails::with('user')->get();
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id','First Name','Last Name','Gender','Email','Contact No.','Status','Birth Date','Qualification','Experience');

        $callback = function() use($receptionists, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($receptionists as $receptionist) {
                $row['Id']  = $receptionist->id;
                $row['First Name']  = $receptionist->user->first_name;
                $row['Last Name']  = $receptionist->user->last_name;
                $row['Gender']  = $receptionist->gender;
                $row['Email']  = $receptionist->user->email;
                $row['Contact No.']  = $receptionist->user->phone_no;
                $row['Status']  = $receptionist->status == 1 ? 'Active' : 'In Active';
                $row['Birth Date']  = $receptionist->birth_date;
                $row['Qualification']  = $receptionist->qualification;
                $row['Experience']  = $receptionist->experience;

                fputcsv($file, array($row['Id'],$row['First Name'],$row['Last Name'],$row['Gender'],$row['Email'],$row['Contact No.'],$row['Status'],$row['Birth Date'],$row['Qualification'],$row['Experience']));
            }

            fclose($file);
        };

          return response()->stream($callback, 200, $headers);
        }
}
