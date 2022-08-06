<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    //
    public function __construct()
    {
        //Check Auth
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:enquiry-list|enquiry-create|enquiry-edit|enquiry-delete', ['only' => ['index','save']]);
         $this->middleware('permission:enquiry-create', ['only' => ['add','save']]);
         $this->middleware('permission:enquiry-edit', ['only' => ['edit','update']]);
    }
    
    ############################
    # Board View
    ############################

    public function index() {
        $title = __('Enquiry');
        $data = Enquiry::where('status', '!=', 'DELETED')->orderBy('id','desc')->get();

        return view('admin.enquiry.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    
}
