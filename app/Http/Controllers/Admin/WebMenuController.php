<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WebMenu;
use App\Services\Admin\WebMenuService;
use App\Models\WebPage;
use App\Models\Category;
use App\Models\PostCategory;
class WebMenuController extends Controller
{
    //
     public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
        $this->middleware('permission:web_menu-list|web_menu-create|web_menu-edit|web_menu-delete', ['only' => ['index','save']]);
         $this->middleware('permission:web_menu-create', ['only' => ['add','save']]);
         $this->middleware('permission:web_menu-edit', ['only' => ['edit','update','menuposition']]);
         $this->middleware('permission:web_menu-delete', ['only' => ['delete']]);
    
    }
    
    
    ############################
    # Tc Management View
    ############################

    public function index() {
        $title = __('Web Menu');
        $data = WebMenuService::recursiveMenu();

        return view('admin.web_menus.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }
    
    
    ############################
    # Web Page Add
    ############################

    public function add() {
        $title = __('Web Menu Add');
        $menus = WebMenu::where('status','ACTIVE')->orderBy('id','desc')->get();
        $pages = WebPage::where('status','ACTIVE')->orderBy('id','desc')->where('type','PAGE')->get();
        $category = Category::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.web_menus.add')
                        ->with('title', $title)
                        ->with('menus', $menus)
                        ->with('pages', $pages)
                        ->with('category', $category)
        ;
    }
    
     public function save(Request $request) {
        $this->validate(request(), [
            'type' => 'required',
            'link' => 'nullable',
            'page_id' => 'nullable',
            'external_link' => 'nullable',
            'status' => 'required',
            'name' => 'required',
            
        ]);
        WebMenuService::save($request);
        return redirect()->back();
    }
    
    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'type' => 'required',
            'link' => 'nullable',
            'page_id' => 'nullable',
            'external_link' => 'nullable',
            'status' => 'required',
            'name' => 'required',
            
        ]);
        WebMenuService::update($request);
        return redirect()->back();
    }

    ############################
    # Web Page View
    ############################

    public function edit($id) {
        $title = __('Web Menu Edit');
        $data = WebMenu::find($id);
        $menus = WebMenu::where('status','ACTIVE')->get();
        $pages = WebPage::where('status','ACTIVE')->where('type','PAGE')->get();
        $category = Category::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.web_menus.edit')
                        ->with('title', $title)
                        ->with('data', $data)
                        ->with('menus', $menus)
                        ->with('pages', $pages)
                        ->with('category', $category)
        ;
    }
    

     public function menuposition(Request $request)
    {
        return WebMenuService::savePosition($request);
       
    }
     public function delete(Request $request)
    {
        WebMenuService::deletemenu($request);
       return redirect()->back();
    }
    
    
}
