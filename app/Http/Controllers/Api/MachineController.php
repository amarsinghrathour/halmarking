<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

/**
 * Description of MachineController
 *
 * @author singh
 */
use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Models\MachineModel;
use App\Machine;
use App\Http\Models\CategoryModel;
use App\Http\Models\MachineCategoryModel;
use App\Http\Models\MachineProductModel;
use App\Http\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class MachineController extends Controller
{
    protected $user;
    
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        if(!$this->user){
            return response()->json([
                    'code' => '406',
                    'response' => 'Invalid',
                    'message' => 'Credentials Not Acceptable',
                ], Response::HTTP_UNAUTHORIZED);
        }
    }
    
    public function getCategory() {
     
        $machine_data = auth()->user(); 
        $data = [];
        $dataCategory = MachineCategoryModel::where('machine_id',$machine_data->id)->where('status','ACTIVE')->get();
        
        if(count($dataCategory) > 0){
            foreach ($dataCategory as $value) {
                $categorydata = CategoryModel::find($value->category_id);
                if($categorydata->status == 'ACTIVE'){
                    $data[] = ['category_id'=>$value->category_id,'name' => $categorydata->name,'image'=>$categorydata->image];
                }
                
            }
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Category Not Found',
            
            
        ]); 
        }
        
        return response()->json([
            'code' => '200',
            'response' => 'Found',
            'message' => 'Category List',
            'data' => $data
            
        ]);
        
    }
    
   // Product list by category
    
    public function getProduct(Request $request) {
     
        $machine_data = auth()->user(); 
        $data = [];
        $category_id = $request->input('category_id');
        
        if(empty($category_id)){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Category Id',
           ]); 
        }
        $dataProduct_ids = DB::table('machine_product')->distinct('product_id')->where('machine_id',$machine_data->id)->where('category_id',$category_id)->whereNotNull('arduino_id')->where('status','ACTIVE')->where('quantity','>',0)->pluck('product_id');
        
        if(count($dataProduct_ids) > 0){
            foreach ($dataProduct_ids as $value) {
                 $productdata = ProductModel::find($value);
                 $MachineProductData = DB::table('machine_product')->where('machine_id',$machine_data->id)->where('category_id',$category_id)->where('product_id',$value)->whereNotNull('arduino_id')->where('status','ACTIVE')->where('quantity','>',0)->orderBy('quantity', 'desc')->first();
                if($MachineProductData->quantity > 0 && $productdata->status == 'ACTIVE'){
                     $price = $MachineProductData->price;
                    $special_price=0;$sale_price=0;$discounted_price=0;
                    if(!empty($MachineProductData->special_price) && $MachineProductData->special_price != 0.00){
                    $date = Carbon::now();
                  $from =  Carbon::parse($MachineProductData->special_price_from)->format('Y-m-d');
                  $to =  Carbon::parse($MachineProductData->special_price_to)->format('Y-m-d');
                  $today =  Carbon::parse($date)->format('Y-m-d');
                    if($from <= $today && $today <= $to){
                       $special_price = $MachineProductData->price*$MachineProductData->special_price/100;
                    }
                  }
                  
                  if(!empty ($MachineProductData->discount_value)){
                        if($MachineProductData->discount_type == 'AMT'){
                            $discounted_price = $MachineProductData->discount_value;
                        }
                        if($MachineProductData->discount_type == 'PER'){
                            $discounted_price = $MachineProductData->price*$MachineProductData->discount_value/100;
                        }
                    }
                    
                    if(!empty($special_price) && !empty($discounted_price)){
                        
                            $sale_price =  $MachineProductData->price - ($special_price + $discounted_price);
                        
                    }elseif(!empty ($special_price)){
                        $sale_price = $MachineProductData->price - $special_price; 
                    }elseif(!empty ($discounted_price)){
                        $sale_price = $MachineProductData->price - $discounted_price; 
                    }else{
                        $sale_price = $price;
                    }
                  
                    $data[] = [
                    'category_id' => $category_id,
                    'product_id' => $MachineProductData->id,
                    'name' => $productdata->name,
                    'image' => $productdata->image,
                    'arduino_id' => $MachineProductData->arduino_id,
                    'price' => $MachineProductData->price,
                    'sale_price' => $sale_price,
                    'special_price' => $special_price,
                    'special_price_to' => $MachineProductData->special_price_to,
                    'special_price_from' => $MachineProductData->special_price_from,
                    'discount_type' => $MachineProductData->discount_type,
                    'discount_value' => $discounted_price,
                    'quantity' => $MachineProductData->quantity,
                        ];
                }else{
                   return response()->json([
                        'code' => '404',
                        'response' => 'Not Available',
                        'message' => 'Product Not Available',


                    ]); 
                }
                
            }
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Product Not Found',
            
            
        ]); 
        }
        
        if(count($data) > 0){
            return response()->json([
              'code' => '200',
              'response' => 'Found',
              'message' => 'Product List',
              'data' => $data

          ]);  
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Available',
            'message' => 'Error Products Not Available',
            
            
        ]);  
        }
        
        
        
    }
    
    // product detail
    public function productDetail(Request $request) {
     
        $machine_data = auth()->user(); 
        $data = [];
        $product_id = $request->input('product_id');
        
        if(empty($product_id)){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Product Id',
           ]); 
        }
        $dataProduct = MachineProductModel::where('machine_id',$machine_data->id)->where('id',$product_id)->whereNotNull('arduino_id')->where('status','ACTIVE')->where('quantity','>',0)->first();
        $productdetail = ProductModel::find($dataProduct->product_id);
        $productGallery = ProductModel::find($dataProduct->product_id)->productGallery()->where('status','ACTIVE')->orderBy('created_date', 'desc')->get();
        if(count($productGallery) > 0){
            foreach ($productGallery as $value) {
                 
                    $data[] = [
                    'image' => $value->image,
                        ];
                
                
            }
        }
        
        if($dataProduct){
            $category_data = CategoryModel::find($dataProduct->category_id);
            $price = $dataProduct->price;
            $special_price=0;$sale_price=0;$discounted_price=0;
            
              
                  if(!empty($dataProduct->special_price) && $dataProduct->special_price != 0.00){
                    $date = Carbon::now();
                  $from =  Carbon::parse($dataProduct->special_price_from)->format('Y-m-d');
                  $to =  Carbon::parse($dataProduct->special_price_to)->format('Y-m-d');
                  $today =  Carbon::parse($date)->format('Y-m-d');
                    if($from <= $today && $today <= $to){
                       $special_price = $dataProduct->price*$dataProduct->special_price/100;
                    }
                  }
                    if(!empty($dataProduct->discount_value)){
                        if($dataProduct->discount_type == 'AMT'){
                            $discounted_price = $dataProduct->discount_value;
                        }
                        if($dataProduct->discount_type == 'PER'){
                            $discounted_price = $dataProduct->price*$dataProduct->discount_value/100;
                        }
                    }
                    
                    if(!empty($special_price) && !empty($discounted_price)){
                        
                            $sale_price =  $dataProduct->price - ($special_price + $discounted_price);
                        
                    }elseif(!empty ($special_price)){
                        $sale_price = $dataProduct->price - $special_price; 
                    }elseif(!empty ($discounted_price)){
                        $sale_price = $dataProduct->price - $discounted_price; 
                    }else{
                        $sale_price = $price;
                    }
                    
            
            
            return response()->json([
              'code' => '200',
              'response' => 'Found',
              'message' => 'Product Detail',
              'machine_id' => $dataProduct->machine_id,
              'category_id' => $dataProduct->category_id,
              'category_name' => $category_data->name,
              'category_image' => $category_data->image,
              'product_id' => $product_id,
              'product_name' => $productdetail->name,
              'product_image' => $productdetail->image,
              'arduino_id' => $dataProduct->arduino_id,
              'description' => $dataProduct->description,
                    'price' => $dataProduct->price,
                    'special_price' => $special_price,
                    'sale_price' => $sale_price,
                    'special_price_to' => $dataProduct->special_price_to,
                    'special_price_from' => $dataProduct->special_price_from,
                    'discount_type' => $dataProduct->discount_type,
                    'discount_value' => $discounted_price,
                    'quantity' => $dataProduct->quantity,
              'productGallery' => $data,

          ]);  
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Available',
            'message' => 'Error Product Detail Not Available',
            
            
        ]);  
        }
        
        
        
    }
    
}
