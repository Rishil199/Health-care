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
        if ($request->ajax()) {
           
            $receptionist = ReceptionistDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
            ))->latest()->with('user')->get();

           

            if(Auth::user()->hasRole(User::ROLE_CLINIC)){
                $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
                $receptionist = ReceptionistDetails::select(array(
                'id','user_id','clinic_id','status','created_at'
                 ))->latest()->with('user')->where('clinic_id',$user_id->id)->get();

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
                    return '<div class="text-center mt-5 ">' .
                    $row->user->first_name . ' ' . $row->user->last_name . '<br>' .
                    '<a href="mailto:' . $row->user->email . '" class="small">' . $row->user->email . '</a>' .
                    '</div>';
                })
                ->addColumn('email', function($row) {
                   return '<div class="text-center">'.
                   ($row->clinic? $row->clinic->user->first_name:'').
                   '</div>'
                   ;
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
                                               <a class="dropdown-item receptionists-view" href="javascript:void(0)" data-url="'. route('receptionists.view',$row->id) .'" data-id="'. $row->id .'" data-bs-toggle="viewmodal" data-bs-target="#myViewModal" title="View">
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item edit-receptionists" href="javascript:void(0)" data-url="'. route('receptionists.edit', $row->id) .'" data-id="'. $row->id .'" title="Edit">
                                                  <span class="svg-text">Edit</span>
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
        $role = Role::where(['name' => User::ROLE_RECEPTIONIST])->first();
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
        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $receptionist->clinic_id = $user_id->id;
        }
        if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)){
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
             $request->user()->sendEmailVerificationNotification();
        }

        return response()->json(
            [
               'status' => true,
               'message' => 'New Staff has been created!'
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
        // $receptionist->status = $request['status'];
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
               'message' => 'Staff has been updated.'
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
                'status' => 'Staff has been deleted!'
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
