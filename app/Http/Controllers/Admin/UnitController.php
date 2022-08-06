<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Services\Admin\UnitService;
class UnitController extends Controller
{
   public function __construct()
    {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','save']]);
         $this->middleware('permission:product-create', ['only' => ['add','save']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
    }
    
    ############################
    # Class View
    ############################

    public function index() {
        $title = __('Unit');
        $data = Unit::where('status', '!=', 'DELETED')->orderBy('id','desc')->get();

        return view('admin.unit.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    ############################
    # Class Add
    ############################

    public function add() {
        $title = __('Unit Add');

        return view('admin.unit.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            'short_name' => 'required',
            
        ]);
        UnitService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'name' => 'required',
            'short_name' => 'required',
            
        ]);
        UnitService::update($request);
        return redirect()->back();
    }

    ############################
    # Class View
    ############################

    public function edit($id) {
        $title = __('Unit Edit');
        $data = Unit::find($id);

        return view('admin.unit.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }
    
    
}
