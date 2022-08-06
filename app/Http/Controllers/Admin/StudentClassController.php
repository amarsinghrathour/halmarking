<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\StudentClassService;
use App\Models\StudentClass;

class StudentClassController extends Controller
{
    //
    public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
    }
    
    ############################
    # Class View
    ############################

    public function index() {
        $title = __('Class');
        $data = StudentClass::where('status', '!=', 'DELETED')->orderBy('id','desc')->get();

        return view('admin.student_class.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    ############################
    # Class Add
    ############################

    public function add() {
        $title = __('Class Add');

        return view('admin.student_class.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            
        ]);
        StudentClassService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'name' => 'required',
            
        ]);
        StudentClassService::update($request);
        return redirect()->back();
    }

    ############################
    # Class View
    ############################

    public function edit($id) {
        $title = __('Class Edit');
        $data = StudentClass::find($id);

        return view('admin.student_class.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }
    
    
}
