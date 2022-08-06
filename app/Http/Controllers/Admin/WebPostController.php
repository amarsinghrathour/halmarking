<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebPost;
use App\Models\Category;
use App\Services\Admin\WebPostService;

class WebPostController extends Controller
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
        $this->middleware('permission:web_post-list|web_post-create|web_post-edit|web_post-delete', ['only' => ['index','get_sub_category_ajax']]);
         $this->middleware('permission:web_post-create', ['only' => ['add','save']]);
         $this->middleware('permission:web_post-edit', ['only' => ['edit','update']]);
    
    }
    
     ############################
    # Web Post View
    ############################

    public function index() {
        $title = __('Web Post');
        $data = WebPost::where('status', '!=', 'DELETED')->where('type','BLOG')->orderBy('id','desc')->get();

        return view('admin.web_post.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }
    
    ############################
    # Web Post Add
    ############################

    public function add() {
        $title = __('Web Post Add');
         $category = Category::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.web_post.add')
                        ->with('title', $title)
                ->with('categoryList', $category)
        ;
    }
    
     public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'category' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebPostService::save($request);
        return redirect()->back();
    }
    
    
    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebPostService::update($request);
        return redirect()->back();
    }

    ############################
    # Web Post View
    ############################

    public function edit($id) {
        $title = __('Web Post Edit');
        $data = WebPost::find($id);
$category = Category::where('status','ACTIVE')->orderBy('id','desc')->get();
$subCategoryList = Category::where('status','ACTIVE')->where('parent_id',$data->category_id)->orderBy('id','desc')->get();
        return view('admin.web_post.edit')
                        ->with('title', $title)
                        ->with('data', $data)
                ->with('categoryList', $category)
                ->with('subCategoryList', $subCategoryList)
        ;
    }
    
     public function get_sub_category_ajax(Request $request) {
        $id = $request->input('id');
        return Category::where('parent_id',$id)->get();
    }
    
}
