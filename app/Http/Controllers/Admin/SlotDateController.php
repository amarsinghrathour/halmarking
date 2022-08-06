<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SlotDate;
use App\Models\SlotTime;
use App\Services\Admin\SlotService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
class SlotDateController extends Controller
{
   public function __construct()
    {
        //Check Auth
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:slot-list|slot-create|slot-edit|slot-delete', ['only' => ['index','save']]);
         $this->middleware('permission:slot-create', ['only' => ['add','save']]);
         $this->middleware('permission:slot-edit', ['only' => ['edit','update']]);
    }
    public function index() {
        $slotList = SlotDate::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.slot.list')
            ->with('title', 'Appointment Slot List')
            ->with('slotList', $slotList);
    }
    public function add() {
        return view('admin.slot.add')
            ->with('title', 'Add Slot')
            
                ;
    }
   
    
    public function save(Request $request) {
       
        $this->validate(request(), [
            'slot_date' => 'bail|required|date|unique:slot_dates',
            'interval' => 'bail|required',
            'start_time' => 'bail|required|date_format:H:i',
            'end_time' => 'bail|required|date_format:H:i|after:start_time',
        ]);
        SlotService::save($request);
        return Redirect::back();
        
    }
    
    public function update(Request $request) {
        $this->validate(request(), [
            'slot_date' => 'bail|required|date|unique:slot_dates,slot_date,'.$request->id.',id',
            'slot_time_id.*' => 'bail|required',
            'start_time.*' => 'bail|required',
            'end_time.*' => 'bail|required',
            'slot_status.*' => 'bail|required',
            'id' => 'bail|required',
        ]);
        SlotService::update($request);
        return Redirect::route('admin.slot');
        
        
    }
    
     public function edit($id) {
        $data = SlotDate::find($id);
        
        return view('admin.slot.edit')
            ->with('title', "Edit Slots | $data->slot_date")
                 ->with('data', $data)
                ;
    }
}
