<?php

namespace App\Http\Controllers\Admin;
use App\Http\Models\MenuModel;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Enquiry;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role_id = Auth::user()->role_id;$user_id = Auth::user()->id;
       
        
         // $enquiry =  Enquiry::where('status','!=','DELETED')->orderBy('id','desc')->limit(10)->get();
            
            return view('admin.dashboard.admin')
            ->with('title', 'Home')
           // ->with('enquiryArray', $enquiry)
           
            ;
        
       
    }
}
