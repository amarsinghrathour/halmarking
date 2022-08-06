<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Controllers\Controller;
class CategoryController extends Controller
{
     public function __construct()
    {
        //Check Auth
        $this->middleware('auth:admin');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
         // $this->middleware('session');
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','save']]);
         $this->middleware('permission:category-create', ['only' => ['add','save']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update','updateIsTop','updateSortOrder']]);
    
         
    }
    
    public function index() {
        $categoryData = Category::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.category.list')
            ->with('title', 'Category List')
            ->with('categoryList', $categoryData);
    }
    public function add() {
        $categoryData = Category::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.category.add')
            ->with('title', 'Add Category')
            ->with('categoryList', $categoryData);
    }
    public function edit($id) {
        $categoryData = Category::where('status','!=','DELETED')->orderBy('id','desc')->get();
        $categoryDeatils = Category::find($id);
        return view('admin.category.edit')
            ->with('title', 'Edit Category')
            ->with('categoryList', $categoryData)
            ->with('data', $categoryDeatils)
                ;
    }
    
    public function save(Request $request) {
        DB::beginTransaction();
        $this->validate(request(), [
            'title' => 'bail|required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:5000000',
        ]);
        $category = htmlspecialchars(strip_tags($request->input('title')));
        $parent_id = htmlspecialchars(strip_tags($request->input('parent_id')));
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));
        $description = htmlspecialchars(strip_tags($request->input('description')));
        $slug = $this->create_slug($category);
        $imageDb = '';
        try{
            
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'category','category');
            }
            if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
               return Redirect::back();
            }
            $newCategory = new Category;
            $newCategory->title = $category;
            $newCategory->description = $description;
            if(!empty($imageDb)){
                $newCategory->image = $imageDb;
            }
            
            $newCategory->slug = $slug;
            $newCategory->parent_id = $parent_id;
            $newCategory->sort_order = $sort_order;
            $newCategory->created_by = auth()->user()->email;
            if($newCategory->save()){
             session()->put('success',"Data Saved Successfully For Category :: $category.");
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Storing For Category :: $category. Please try again !");
            return Redirect::back();
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Storing For Category :: $category. Please try again !");
            return Redirect::back();
        }
        
        
        DB::commit();
        return Redirect::back();
        
    }
    
    public function update(Request $request) {
        DB::beginTransaction();
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
        $this->validate(request(), [
            'title' => 'bail|required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:5000000',
            'id' => 'bail|required',
        ]);
        $category = $request->input('title');
        $description = $request->input('description');
        $id = $request->input('id');
        $parent_id = htmlspecialchars(strip_tags($request->input('parent_id')));
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));
        $imageDb = '';
        try{
            
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'),'category','category');
                if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
               return Redirect::back();
            }
            }
            $oldPath = '';
            $newCategory = Category::find($id);
            if($newCategory->title != $category){
                $newCategory->title = $category;
              $newCategory->slug = $this->create_slug($category);  
            }
            $newCategory->description = $description;
            if(!empty($imageDb)){
                $oldPath = $newCategory->image;
                $newCategory->image = $imageDb;
                
            }
            
            $newCategory->parent_id = $parent_id;
            $newCategory->sort_order = $sort_order;
            $newCategory->updated_by = auth()->user()->email;
            if($newCategory->save()){
                if(!empty($oldPath)){
                unlink(public_path().'/'.$oldPath);
                }
             session()->put('success',"Data Updated Successfully For Category :: $category.");
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured while Updating Category");
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Updating For Category :: $category. Please try again !");
            return Redirect::back();
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Updating For Category :: $category. Please try again !");
            return Redirect::back();
        }
        
        
        DB::commit();
        return Redirect::back();
        
    }
    
    protected function create_slug($string){
        $slug = "";
        do{
            //$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
           $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
            $data = Category::where('slug',$slug)->count();
            if($data > 0){
               $string = $slug.'-'.$data; 
            }
        }
        while ($data > 0);
   
   
   return $slug;
}
    
function updateIsTop(Request $request) {
    $id = $request->post('id');
        $is_top = $request->post('is_top');
       
        $data = array();
        if(!empty($id) and !empty($is_top)){
            
            $category = Category::find($id);
            $category->is_top = $is_top;
            $category->updated_by = auth()->user()->email;
            
            if($category->save()){
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Your data has been updated';
                session()->put('succsess',"Your data has been updated Successfully");
            }
            else
            {
                $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
                session()->put('error',"Data updating failed Please try again !");
            }
        } else {
            Log::debug("Empty Data");
            $data['code'] = 201;
            $data['status'] = 'error';
            $data['message'] = 'Data updating failed ! Empty';
            session()->put('error',"Category Id Is Required Please try again !");
        }
        return response()->json($data);
}
function updateSortOrder(Request $request) {
    $id = $request->post('id');
        $sort_order = $request->post('sort_order');
       
        $data = array();
        if(!empty($id)){
            
            $category = Category::find($id);
            $category->sort_order = $sort_order;
            $category->updated_by = auth()->user()->email;
            
            if($category->save()){
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Your data has been updated';
                session()->put('succsess',"Your data has been updated Successfully");
            }
            else
            {
                $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
                session()->put('error',"Data updating failed Please try again !");
            }
        } else {
            Log::debug("Empty Data");
            $data['code'] = 201;
            $data['status'] = 'error';
            $data['message'] = 'Data updating failed ! Empty';
            session()->put('error',"Category Id Is Required Please try again !");
        }
        return response()->json($data);
}

    
}
