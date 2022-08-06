<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Controllers\Controller;
use App\Services\Admin\OurService;
class ServiceController extends Controller
{
     public function __construct()
    {
        //Check Auth
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
         // $this->middleware('session');
        $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','save']]);
         $this->middleware('permission:service-create', ['only' => ['add','save']]);
         $this->middleware('permission:service-edit', ['only' => ['edit','update','updateIsHome']]);
    
         
    }
    
    public function index() {
        $serviceListData = Service::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.service.list')
            ->with('title', 'Service List')
            ->with('serviceList', $serviceListData);
    }
    
    public function add() {
        return view('admin.service.add')
            ->with('title', 'Add Service');
    }
    
    public function edit($id) {
        $serviceDeatils = Service::find($id);
        return view('admin.service.edit')
            ->with('title', 'Edit Service')
            ->with('data', $serviceDeatils)
                ;
    }
    
    public function save(Request $request) {
       
        $this->validate(request(), [
            'title' => 'bail|required',
            'price_range' => 'bail|required',
            'description' => 'nullable',
            'icon' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:5000000',
        ]);
        
        
        
        OurService::save($request);
        return Redirect::back();
        
    }
    
    public function update(Request $request) {
        
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
        $this->validate(request(), [
            'title' => 'bail|required',
            'description' => 'nullable',
            'icon' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:5000000',
            'id' => 'bail|required',
            'price_range' => 'bail|required',
        ]);
        if(OurService::update($request)){
            return Redirect::route('admin.service.list');
        }
        return Redirect::back();
        
    }
    
   
    
function updateIsTop(Request $request) {
    $id = $request->post('id');
        $is_show_on_home = $request->post('is_show_on_home');
       
        $data = array();
        if(!empty($id) and !empty($is_show_on_home)){
            
            $category = Service::find($id);
            $category->is_show_on_home = $is_show_on_home;
            $category->updated_by = auth()->user()->email;
            
            if($category->save()){
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Your data has been updated';
                session()->put('succsess',"Your data has been updated Successfully");
            }
            else
            {
                $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
                session()->put('error',"Data updating failed Please try again !");
            }
        } else {
            Log::debug("Empty Data");
            $data['code'] = 201;
            $data['status'] = 'error';
            $data['message'] = 'Data updating failed ! Empty';
            session()->put('error',"Service Id Is Required Please try again !");
        }
        return response()->json($data);
}
    
}
