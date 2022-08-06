<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebPage;
use App\Services\Admin\WebPageService;

class WebPageController extends Controller
{
    //
     //
    public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
        $this->middleware('permission:web_page-list|web_page-create|web_page-edit|web_page-delete', ['only' => ['index','save']]);
         $this->middleware('permission:web_page-create', ['only' => ['add','save']]);
         $this->middleware('permission:web_page-edit', ['only' => ['edit','update']]);
    
    }
    
     ############################
    # Web Page View
    ############################

    public function index() {
        $title = __('Web Page');
        $data = WebPage::where('status', '!=', 'DELETED')->where('type','PAGE')->orderBy('id','desc')->get();

        return view('admin.web_page.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }
    
    ############################
    # Web Page Add
    ############################

    public function add() {
        $title = __('Web Page Add');

        return view('admin.web_page.add')
                        ->with('title', $title)
        ;
    }
    
     public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'template' => 'bail|required',
            'sidebar.*' => 'nullable',
            
        ]);
        WebPageService::save($request);
        return redirect()->back();
    }
    
    
    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'template' => 'bail|required',
            'sidebar.*' => 'nullable',
            
        ]);
        WebPageService::update($request);
        return redirect()->back();
    }

    ############################
    # Web Page View
    ############################

    public function edit($id) {
        $title = __('Web Page Edit');
        $data = WebPage::find($id);

        return view('admin.web_page.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }
    
}
