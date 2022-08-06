<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Controllers\Controller;
use App\Services\Admin\CustomerService;
use App\Models\Customer;
use App\Models\State;
class CustomerController extends Controller
{
     public function __construct()
    {
        //Check Auth
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','save']]);
         $this->middleware('permission:customer-create', ['only' => ['add','save']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
    }
    
    public function index() {
        $customerList = Customer::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.customer.list')
            ->with('title', 'Customers List')
            ->with('customerList', $customerList);
    }
    public function add() {
        $states = State::where('country_id',101)->get();
        return view('admin.customer.add')
            ->with('title', 'Add Customer')
            ->with('stateList', $states)
                ;
    }
   
    
    public function save(Request $request) {
       
        $this->validate(request(), [
            'name' => 'bail|required',
            'gstin' => 'nullable',
            'mobile' => 'bail|required',
            'address' => 'bail|required',
            'pin_code' => 'bail|required',
            'state_id' => 'bail|required',
        ]);
        CustomerService::save($request);
        return Redirect::back();
        
    }
    
    public function update(Request $request) {
        $this->validate(request(), [
            'name' => 'bail|required',
            'mobile' => 'bail|required',
            'id' => 'bail|required',
        ]);
        CustomerService::update($request);
        return Redirect::route('admin.customer');
        
        
    }
    
     public function edit($id) {
        $data = Customer::find($id);
        
        $states = State::where('country_id',101)->get();
        return view('admin.customer.edit')
            ->with('title', "Edit Customer | $data->name")
            ->with('stateList', $states)
                 ->with('data', $data)
                ;
    }
}
