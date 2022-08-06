<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
/**
 * Description of UserController
 *
 * @author singh
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Admin\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Services\Admin\RoleService;
class RoleController extends Controller 
{
     public function __construct()
    {
         $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','save']]);
         $this->middleware('permission:role-create', ['only' => ['add','save']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         //$this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    // User list page
    
     public function index()
    {
         
         
         $roles = Role::where('id','!=',Auth::user()->role_id)->orderBy('created_at', 'desc')->get();
         
        return view('admin.role.list')
        ->with('title', __('Role List'))
        ->with('userListArray', $roles)
        ;
    }
    
   /*
     * User Add Form
     */
    public function add()
    {
        $permission = Permission::get();
        return view('admin.role.add')
        ->with('title', __('Adding New User'))
        ->with('permissionListArray', $permission)
        ;
    } 
    
    // save category
     public function save(Request $request)
    {
        
        
        
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        
        RoleService::save($request);
        
        
        return Redirect::back();
    }
    
   public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
       return view('admin.role.edit')
        ->with('title', __('Edit Role'))
        ->with('permission', $permission)
        ->with('rolePermissions', $rolePermissions)
        ->with('role', $role)
        ;
    }
    
     public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        RoleService::update($request);
    
        return redirect()->route('admin.roles');
                        
    }
    
     public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('admin.role.show',compact('role','rolePermissions'))->with('title', __('Show Role'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('admin.roles')
                        ->with('success','Role deleted successfully');
    }
    
}
