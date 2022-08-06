<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\ProductGallery;
use App\Models\ProductInventory;
use File;
use App\Models\Unit;
use App\Models\Category;
use App\Services\Admin\ProductService;
class ProductController extends Controller
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
         $this->middleware('permission:product-edit', ['only' => ['edit','update','refill']]);
    }
    public function index() {
        $productData = Product::where('status','!=','DELETED')->orderBy('id','desc')->get();
        return view('admin.product.list')
            ->with('title', 'Product List')
            ->with('productList', $productData);
    }
    
    /*
     * Product Add Form
     */
    public function add()
    {
        $unitList = Unit::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.product.add')
        ->with('title', __('Adding New  Product'))
        ->with('unitList', $unitList)
        ;
    } 
    /*
     * Product edit Form
     */
    public function edit($id)
    {
        
        $productData= Product::find($id);
        $unitList = Unit::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.product.edit')
        ->with('title', __('Edit Product'))
        ->with('productData', $productData)
        ->with('unitList', $unitList)
        ;
    } 
    
    
    
   
    
    public function save(Request $request) {
        Log::debug(__CLASS__."::".__FUNCTION__." called");
        
        $this->validate(request(), [
            'name' => 'bail|required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:500000',
            'cost_price' => 'bail|required|numeric|gt:0',
            'mrp' => 'bail|required|numeric|gt:0',
            'unit_id' => 'bail|required',
            'hsn_code' => 'nullable',
        ]);
        
        ProductService::save($request);
        
        
        return Redirect::back();
        
    }
    //update product data
    public function update(Request $request) {
        
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
        $this->validate(request(), [
            'name' => 'bail|required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:500000',
            'cost_price' => 'bail|required|numeric|gt:0',
            'mrp' => 'bail|required|numeric|gt:0',
            'unit_id' => 'bail|required',
            'hsn_code' => 'nullable',
            'id' => 'bail|required',
            
        ]);
        $id = htmlspecialchars(strip_tags($request->input('id')));
        ProductService::update($request);
        return Redirect::route('admin.product.edit',['id'=>$id]);
        
    }
    //update product gallery image by id
    public function updateImage(Request $request) {
        DB::beginTransaction();
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
        $this->validate(request(), [
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:5000000',
            'id' => 'bail|required',
        ]);
        $id = htmlspecialchars(strip_tags($request->input('id')));
        $imageDb = '';
        $product_id = '';
        try{
            $newProduct = ProductGallery::find($id);
            $product_id = $newProduct->product_id;
            $productData = Product::where('status','!=','DELETED')->where('id',$product_id)->first();
            if($request->hasFile('image')){
                //$imageDb = uploadImage($request->file('image'), 'product');
                $imageDb = uploadImage($request->file('image'), 'product','product');
            }
            $oldPath = '';
            
            if(!empty($imageDb)){
                $oldPath = $newProduct->image;
                $newProduct->image = $imageDb;
                
            }
            
            if($newProduct->save()){
                if(!empty($oldPath)){
                unlink(public_path().$oldPath);
                }
             session()->put('success',"Data Updated Successfully For Product Image.");
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured while Updating Product Image");
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error',"Error Occured While Data Updating For Product :: Image. Please try again !");
            return Redirect::route('product.edit',['id'=>$product_id]);
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error',"Exception While Data Updating For Product :: Image. Please try again !");
            return Redirect::route('product.edit',['id'=>$product_id]);
        }
        
        
        DB::commit();
        return Redirect::route('product.edit',['id'=>$product_id]);
        
    }
    //delete product gallery image by id
    public function deleteImage(Request $request) {
        
        Log::debug(__CLASS__.'::'.__FUNCTION__."called");
        $this->validate(request(), [
            'id' => 'bail|required',
        ]);
        $id = htmlspecialchars(strip_tags($request->input('id')));
        $product_id = '';$data = array();
        try{
            DB::beginTransaction();
            
            $oldPath = '';
            $newProduct = ProductGallery::find($id);
            $product_id = $newProduct->product_id;
                $oldPath = $newProduct->image;
                
            
            if($newProduct->delete()){
                if(!empty($oldPath)){
                unlink(public_path().$oldPath);
                }
             session()->put('success',"Image deleted Successfully For Product.");
             $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Image deleted Successfully';
            }else{
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured while Deleting Product Image");
            session()->put('error',"Error Occured While Data Deleting For Product :: Image. Please try again !");
            $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
            }
            
        }catch(\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            session()->put('error',"Exception While Data Deleting Image For Product. Please try again !");
            $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Exception While Data Deleting Image !';
        }
        
        
        DB::commit();
        return response()->json($data);
        
    }
    //refill product quantity
     public function refill(Request $request)
    {
         
        
        
        $this->validate(request(), [
           'product_id' => 'bail|required',
           'quantity' => 'bail|required',
        ]); 
        ProductService::refill($request);
        return Redirect::back();
    }
    
    public function viewRefill(Request $request) {
        $this->validate(request(), [
           'product_id' => 'bail|required',
        ]); 
        $product_id = $request->input('product_id');
        $productData = Product::where('status','!=','DELETED')->where('id',$product_id)->first();
        $refillHistory = ProductInventory::where('product_id',$product_id)->get();
        return view('admin..product.viewRefill')
            ->with('title', 'Product Refill History')
            ->with('productData', $productData)
            ->with('refillList', $refillHistory)
                ;
    }
    
    
    
}
