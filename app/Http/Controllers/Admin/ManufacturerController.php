<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Manufacturer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Services\Admin\ManufacturerService;
class ManufacturerController extends Controller
{
   public function __construct()
    {
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
        $title = __('Manufacturer');
        $data = Manufacturer::where('status', '!=', 'DELETED')->orderBy('id','desc')->get();

        return view('admin.manufacturer.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    ############################
    # Class Add
    ############################

    public function add() {
        $title = __('Manufacturer Add');

        return view('admin.manufacturer.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            
        ]);
        ManufacturerService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'name' => 'required',
            
        ]);
        ManufacturerService::update($request);
        return redirect()->back();
    }

    ############################
    # Class View
    ############################

    public function edit($id) {
        $title = __('Manufacturer Edit');
        $data = Manufacturer::find($id);

        return view('admin.manufacturer.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }
    
    
}
