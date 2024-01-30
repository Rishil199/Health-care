<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Use: Display listing of Permissions.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        // dd("dd");
        if ($request->ajax()) {
            $permissions = Permission::select('id','name','created_at')->latest()->get();
            return Datatables::of($permissions)
                ->editColumn('created_at', function($data){
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format(' dS F, Y h:i A');
                    return $formatedDate;
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
                                               <a class="dropdown-item edit-permission" href="javascript:void(0)" data-url="'. route('permissions.edit', $row->id) .'" data-id="'. $row->id .'" data-toggle="editmodal" data-target="#myEditModal">
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
            'title' => 'Permissions',
        );

        return view('admin.permissions.index',$this->data);
    }

    /**
     * Use: Insert record for permission 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function create() {

        $this->data = array(
            'title' => 'Permissions',
        );
        $view = view('admin.permissions.add', $this->data)->render();
        
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );

        return response()->json($response);
    }

    /**
     * Use: store data of permission 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store(StorePermissionRequest $request) {   
       
        Permission::create($request->validated());
        
        return response()->json(
             [
               'status' => true,
               'message' => 'New Permission has been created!'
             ]
        );
    }

    /**
     * Use: Edit form for permission's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        $permission = Permission::findOrFail($id);
        $view = view('admin.permissions.edit', compact('permission'))->render();
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

    /**
     * Use: Update permission's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePermissionRequest $request, $id) {
        $permission = Permission::findOrFail($id);
        $permission->name = $request->validated()['name'];
        $permission->save();

        return response()->json(
             [
               'status' => true,
               'message' => 'Permission has been updated.'
             ]
        );
        
        return response()->json($response);
    }

    /**
     * Use: Delete permission's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request) {

        $permission = Permission::findOrFail($request->id);
        $rolePermissions = $permission->roles;
        
        if ( !$rolePermissions->count() ) {
            $permission->delete();
            return response()->json([
                'status' => true,
                'message' => 'Permission has been deleted.',
            ]);
        }
        
        return response()->json([
            'status' => false,
            'message' => 'You can not delete this permission as it is assigned with some role.  ',
        ]);
    }
}
