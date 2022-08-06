<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Models\Admin\Admin;
use App\Services\Admin\AdminService;
class AdminController extends Controller
{
    
    public function __construct()
    {
         $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','save']]);
         $this->middleware('permission:user-create', ['only' => ['add','save']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update','updatePassword','changePassword']]);
         //$this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.user.list')
        ->with('title', __('User List'))
        ->with('userListArray', Admin::where('id','!=',auth()->user()->id)->orderBy('created_at', 'desc')->get())
        ;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $role_id = auth()->user()->role_id;
         
        return view('admin.user.add')
        ->with('title', __('Adding New User'))
        ->with('roleListArray', Role::where('status','ACTIVE')->where('id','!=',$role_id)->orderBy('id', 'desc')->get())
        ;
    } 
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // save category
     public function save(Request $request)
    {
        
        
        
       
        $this->validate(request(), [
            'name' => 'bail|required',
            'password' => 'bail|required|same:confirm-password',
            'role' => 'bail|required',
            'mobile' => 'nullable',
            'email' => 'bail|required|unique:admins',
         ]);
        
         AdminService::save($request);
        
        return Redirect::back();
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Admin::find($id);
        return view('user.show',compact('user'))->with('title', __('Show User'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Admin::find($id);
        $role_id = auth()->user()->role_id;
    
        return view('admin.user.edit',compact('user'))
                ->with('title', __('Edit User'))
                ->with('roleListArray', Role::where('status','ACTIVE')->where('id','!=',$role_id)->orderBy('id', 'desc')->get());
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'role' => 'required',
            'mobile' => 'nullable',
        ]);
        AdminService::update($request);
        
        return redirect()->route('admin.user')
                        ;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect()->route('user.index')
                        ->with('success','User deleted successfully');
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
