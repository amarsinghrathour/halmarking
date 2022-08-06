<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Services\Admin\TaxService;
class TaxController extends Controller
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
        $title = __('Tax');
        $data = Tax::where('status', '!=', 'DELETED')->orderBy('id','desc')->get();

        return view('admin.tax.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    ############################
    # Class Add
    ############################

    public function add() {
        $title = __('Tax Add');

        return view('admin.tax.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            'percentage' => 'required',
            
        ]);
        TaxService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'name' => 'required',
            'percentage' => 'required',
            
        ]);
        TaxService::update($request);
        return redirect()->back();
    }

    ############################
    # Class View
    ############################

    public function edit($id) {
        $title = __('Tax Edit');
        $data = Tax::find($id);

        return view('admin.tax.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }
    
    
}
