<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Services\Admin\SizeService;
class SizeController extends Controller
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
        $title = __('Size');
        $data = Size::where('status', '!=', 'DELETED')->orderBy('id','desc')->get();

        return view('admin.size.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    ############################
    # Class Add
    ############################

    public function add() {
        $title = __('Size Add');

        return view('admin.size.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            
        ]);
        SizeService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'name' => 'required',
            
        ]);
        SizeService::update($request);
        return redirect()->back();
    }

    ############################
    # Class View
    ############################

    public function edit($id) {
        $title = __('Size Edit');
        $data = Size::find($id);

        return view('admin.size.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }
    
    
}
