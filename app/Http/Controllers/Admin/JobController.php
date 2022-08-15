<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Job;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\JobService;
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
       
        return view('admin.job.add')
        ->with('title', __('Adding New  Job'))
       
        ;
    } 
    /*
     * Job edit Form
     */
    public function edit($id)
    {
        
        $jobData= Job::find($id);
        return view('admin.job.edit')
        ->with('title', __('Edit Job'))
        ->with('data', $jobData)
        ;
    } 
    
    
    
   
    
    public function save(Request $request) {
        Log::debug(__CLASS__."::".__FUNCTION__." called");
        
        $this->validate(request(), [
            'job_number' => 'bail|required|unique:jobs,job_no',
            'product_type' => 'bail|required',
            'product_purity' => 'bail|required',
            'no_of_product' => 'bail|required',
            'product_lot' => 'bail|required',
            
        ]);
        
        JobService::save($request);
        
        
        return Redirect::back();
        
    }
    //update job data
    public function update(Request $request) {
        
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
           $id = htmlspecialchars(strip_tags($request->input('id')));
        $this->validate(request(), [
            'job_number' => 'bail|required|unique:jobs,job_no,' . $id,
            'product_type' => 'bail|required',
            'product_purity' => 'bail|required',
            'no_of_product' => 'bail|required',
            'product_lot' => 'bail|required',
            'id' => 'bail|required',
            
        ]);
       
        JobService::update($request);
        return Redirect::route('admin.job.edit',['id'=>$id]);
        
    }
    
}
