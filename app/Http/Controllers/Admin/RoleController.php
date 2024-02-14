<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Carbon\Carbon;
use DataTables;

class RoleController extends Controller
{
    /**
     * Use: Display listing of Roles.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        $permissions = Permission::select('id','name')->get();

        $role_name = User::ROLE_SUPER_ADMIN;
        
        if ($request->ajax()) {
            $roles = Role::select(array(
                'id','name', 'created_at'
            ))->whereNotIn('name',[$role_name])->latest()->get();

            return Datatables::of($roles)
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
                                               <a class="dropdown-item edit-role" href="javascript:void(0)" data-url="'. route('roles.edit', $row->id) .'" data-id="'. $row->id .'"  data-toggle="editmodal" data-target="#myEditModal">
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
            'title' => 'Roles',
            'permission' => $permissions,
        );
        return view('admin.roles.index', $this->data);
    }

    /**
     * Use: Insert record for role 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function create() {

        $permissions = Permission::select('id','name')->get();
        
        $this->data = array(
            'title' => 'Roles',
            'permission' => $permissions,
        );
        
        $view = view('admin.roles.add', $this->data)->render();
        
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );

        return response()->json($response);
    }

    /**
     * Use: store data of role 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store(StoreRoleRequest $request) {   
        
        $role = Role::create([
            'name' => ucfirst($request->validated()['name']),

        ]);
        $role->syncPermissions($request->validated()['permission']);
        return response()->json(
             [
               'status' => true,
               'message' => 'Role added successfully'
             ]
        );
    }

    /**
     * Use: Edit form for role's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        
        $role = Role::findOrFail($id);
        $permissions = Permission::select('id','name')->get();

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        $this->data = array(
            'role' => $role,
            'permission' => $permissions,
            'rolePermissions' => $rolePermissions,
        );

        $view = view('admin.roles.edit', $this->data)->render();
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

    /**
     * Use: Update role's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = ucfirst($request->validated()['name']);
        $role->save();

        $role->syncPermissions($request->validated()['permission']);

        return response()->json(
             [
               'status' => true,
               'message' => 'Role has been updated.'
             ]
        );
        return response()->json($response);
    }

    /**
     * Use: Delete role's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request)
    {
        $delete_role = Role::where('id',$request->id)->first();

        if ($delete_role->delete()) {

            return response()->json([
                'status' => 'Role has been deleted!'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong!  Role not found!'
        ]);
    }
}
