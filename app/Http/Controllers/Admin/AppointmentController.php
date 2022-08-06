<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Services\Admin\AppointmentService;
class AppointmentController extends Controller
{
    public function __construct()
    {
        //Check Auth
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:appointment-list|appointment-create|appointment-edit|appointment-delete', ['only' => ['index','save']]);
         $this->middleware('permission:appointment-create', ['only' => ['add','save']]);
         $this->middleware('permission:appointment-edit', ['only' => ['edit','update']]);
    }
    public function index() {
        $data = Appointment::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.appointment.list')
            ->with('title', 'Appointment List')
             ->with('dataArray', $data)
                ;
    }
    
    
    public function update(Request $request) {
        $this->validate(request(), [
            'appointment_date' => 'bail|required|date',
            'appointment_start_time' => 'bail|required',
            'appointment_end_time' => 'bail|required',
            'id' => 'bail|required',
        ]);
        AppointmentService::update($request);
        return Redirect::route('admin.appointment');
        
        
    }
    
     public function edit($id) {
        $data = Appointment::find($id);
        
        return view('admin.appointment.edit')
            ->with('title', "Edit Appointment")
                 ->with('data', $data)
                ;
    }
     public function view($id) {
        $data = Appointment::find($id);
        
        return view('admin.appointment.view')
            ->with('title', "Appointment")
                 ->with('data', $data)
                ;
    }
}
