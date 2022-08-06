<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\SettingService;
use App\Models\State;
class SettingController extends Controller
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
        $this->middleware('permission:settings-list', ['only' => ['index','update']]);
        
    }
    
    ############################
    # Settings View
    ############################
     public function index() 
    {
          $title = __('Settings');
          $states = State::where('country_id',101)->get();
      return view('admin.setting.list')
         ->with('title', $title)
         ->with('stateList', $states)
         ;

    }
    ############################
    # Update or create settings language wise
    ############################
     public function update(Request $request)
    {
        return SettingService::update($request);
        
    }
  
    
    
    
 ###################################################################################EOD####################################################################################################
 
      ################################################################################################################################################################
}
