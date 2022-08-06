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

class UserController extends Controller 
{
     public function __construct()
    {
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','save']]);
         $this->middleware('permission:user-create', ['only' => ['add','save']]);
         $this->middleware('permission:user-edit', ['only' => ['updatePassword','changePassword']]);
    }
    
    // User list page
    
     public function index()
    {
         
        return view('admin.user.list')
        ->with('title', __('User List'))
        ->with('userListArray', Admin::where('id','!=',Auth::user()->id)->orderBy('created_at', 'desc')->get())
        ;
    }
    
   /*
     * User Add Form
     */
    public function add()
    {
        $role_id = auth()->user()->role_id;
        return view('admin.user.add')
        ->with('title', __('Adding New User'))
        ->with('roleListArray', Role::where('status','ACTIVE')->where('id','!=',$role_id)->orderBy('id', 'desc')->get())
        ;
    } 
    
    // save category
     public function save(Request $request)
    {
        
        DB::beginTransaction();
        
        $name = $request->input('name');
        $this->validate(request(), [
            'name' => 'bail|required',
            'password' => 'bail|required',
            'role' => 'bail|required',
             'email' => 'bail|required|unique:users',
         ]);
        try{
        
            $password = $request->input('password');
            $newuser = new Admin;
            $newuser->name = $name;
            if(!empty($request->input('mobile'))){
                $newuser->mobile = $request->input('mobile');
            }
            $newuser->email = $request->input('email');
            $newuser->password = Hash::make($password);
             $newuser->role_id = $request->input('role'); 
               

            if($newuser->save())
            {
                Log::debug(__CLASS__."::".__FUNCTION__." User details saved successfully for User :: $name and Password : $password");
                    session()->put("success",__('User details saved successfully for User :: :name and Password :: :password',['name'=>$name,'password'=>$password]));
                    
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." User details saving failed for User :: $name");
                session()->put("error",__(':data details saving failed for :column :: :name',['data'=>'User','column'=>'User','name'=>$name]));
                

            }
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__." Exception :: ".$e->getMessage());
            session()->put("error","__('Exception While Data Storing :data for :column :: :name Please try again',['data'=>'in User table','column'=>'User','name'=>$name])");
           
            return Redirect::back();
        }
        DB::commit();
        
        
        return Redirect::back();
    }
    
    public function changePassword() {
         return view('admin.user.changePassword')
        ->with('title', 'Change Password')
        ->with('userListArray', Admin::where('id','!=',Auth::user()->id)->orderBy('created_at', 'desc')->get())
        ;
    }
    
    public function updatePassword(Request $request) {
        DB::beginTransaction();
        
        
        $id = $request->input('user_id');
         $userData = Admin::find($id);
         $name = $userData->name;
        $this->validate(request(), [
            'user_id' => 'bail|required',
            'password' => 'bail|required',
             
         ]);
        try{
        
            $password = $request->input('password');
           
            
            $userData->password = Hash::make($password);
            

            if($userData->save())
            {
                Log::debug(__CLASS__."::".__FUNCTION__." User Password Updated successfully for User :: $name and Password : $password");
                    session()->put("success",__('User Password Updated successfully for User :: :name and Password :: :password',['name'=>$name,'password'=>$password]));
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." User Password saving failed for User :: $name");
                session()->put("error",__(':data Updting failed for :column :: :name',['data'=>'User Password','column'=>'User','name'=>$name]));

            }
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__." Exception :: ".$e->getMessage());
            session()->put("error",__('Exception While Data Storing :data for :column :: :name Please try again',['data'=>'Password','column'=>'User','name'=>$name]));
            return Redirect::back();
        }
        DB::commit();
        
        
        return Redirect::back();
    }
    
    
    
}
