<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
class JobController extends Controller
{
   public function __construct()
    {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
         $this->middleware('permission:job-list|job-create|job-edit|job-delete', ['only' => ['index','save']]);
         $this->middleware('permission:job-create', ['only' => ['add','save']]);
         $this->middleware('permission:job-edit', ['only' => ['edit','update','refill']]);
    }
    
    
     public function index() {
        $jobData = Job::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.job.list')
            ->with('title', 'Job List')
            ->with('jobList', $jobData);
    }
    
    /*
     * Job Add Form
     */
    public function add()
    {
        $unitList = Unit::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.job.add')
        ->with('title', __('Adding New  Job'))
        ->with('unitList', $unitList)
        ;
    } 
    /*
     * Job edit Form
     */
    public function edit($id)
    {
        
        $jobData= Job::find($id);
        $unitList = Unit::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.job.edit')
        ->with('title', __('Edit Job'))
        ->with('jobData', $jobData)
        ->with('unitList', $unitList)
        ;
    } 
    
    
    
   
    
    public function save(Request $request) {
        Log::debug(__CLASS__."::".__FUNCTION__." called");
        
        $this->validate(request(), [
            'name' => 'bail|required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:500000',
            'cost_price' => 'bail|required|numeric|gt:0',
            'mrp' => 'bail|required|numeric|gt:0',
            'unit_id' => 'bail|required',
            'hsn_code' => 'nullable',
        ]);
        
        JobService::save($request);
        
        
        return Redirect::back();
        
    }
    //update job data
    public function update(Request $request) {
        
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
        $this->validate(request(), [
            'name' => 'bail|required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:500000',
            'cost_price' => 'bail|required|numeric|gt:0',
            'mrp' => 'bail|required|numeric|gt:0',
            'unit_id' => 'bail|required',
            'hsn_code' => 'nullable',
            'id' => 'bail|required',
            
        ]);
        $id = htmlspecialchars(strip_tags($request->input('id')));
        JobService::update($request);
        return Redirect::route('admin.job.edit',['id'=>$id]);
        
    }
    
}
