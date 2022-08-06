<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

/**
 * Description of CartController
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
use App\Http\Models\MachineProductSoldModel;
use App\Http\Controllers\Api\Models\CartModel;
use App\Http\Controllers\Api\Models\CartTokenModel;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use paytm\paytmchecksum\PaytmChecksum;
use Illuminate\Support\Facades\Log;
class CartController extends Controller
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
    
    
     public function getCartToken() {
     
        $machine_data = auth()->user(); 
        
        $cartToken = $this->generateCartToken();
        
        if($cartToken){
            $newToken = new CartTokenModel;
            $newToken->machine_id = $machine_data->id;
            $newToken->token = $cartToken;
            $newToken->created_by = $machine_data->id;
            

            if(!$newToken->save())
            {
                        return response()->json([
                     'code' => '500',
                     'response' => 'Not Activated',
                     'message' => 'Error Try Again',


                 ]); 
            }
        }else{
           return response()->json([
            'code' => '500',
            'response' => 'Not Activated',
            'message' => 'Error Try Again',
            
            
        ]); 
        }
        
        return response()->json([
            'code' => '200',
            'response' => 'Activated',
            'message' => 'Cart Token',
            'cartToken' => $cartToken
            
        ]);
        
    }
    
     public function addToCart(Request $request) {
     
         $this->validate(request(), [
           'cart_token' => 'bail|required',
           'product_id' => 'bail|required',
           'quantity' => 'bail|required',
        ]);
         
        $machine_data = auth()->user(); 
        
        $cartToken = $request->input('cart_token');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Valid Cart Token',
           ]); 
        }
        
       
        try{
             $product_data = MachineProductModel::where('machine_id',$machine_data->id)->where('id',$product_id)->where('status','ACTIVE')->whereNotNull('arduino_id')->where('quantity','>',0)->first();
       
            if($product_data->product_id){
            
            $price = $product_data->price;
            $special_price=0;$sale_price=0;$discounted_price=0;
            if(CartModel::where('token',$cartToken)->count() > 0 && CartModel::where('token',$cartToken)->where('machine_product_core_id',$product_data->id)->where('status','ACTIVE')->exists()){
                
              $updateCart = CartModel::where('token',$cartToken)->where('product_id',$product_data->product_id)->where('status','ACTIVE')->first();
               $updateQuantity = $updateCart->quantity + $quantity;
              if($updateQuantity > $product_data->quantity){
                    return response()->json([
                    'code' => '404',
                    'response' => 'Quantity Not Available',
                    'message' => 'Product Quantity Is less',
                   ]); 
                }
              $updateCart->quantity = $updateQuantity;
              $updateCart->amount = $updateCart->price * $updateQuantity;
              $updateCart->payable_amount = $updateCart->sale_price * $updateQuantity;
              if($updateCart->sale_price > 0){
                $updateCart->discount = ($updateCart->price * $updateQuantity) - ($updateCart->sale_price * $updateQuantity);  
              }else{
                  $updateCart->discount = 0.00;
              }
              
              $updateCart->updated_by = $machine_data->id;
              if(!$updateCart->save())
                {
                            return response()->json([
                         'code' => '500',
                         'response' => 'Not Updated',
                         'message' => 'Error Product Quantity Not Updated',


                     ]); 
                }
            }else{
                if($quantity > $product_data->quantity){
                    return response()->json([
                    'code' => '404',
                    'response' => 'Quantity Not Available',
                    'message' => 'Product Quantity Is less',
                   ]); 
                }

                    
                  if(!empty($product_data->special_price) && $product_data->special_price != 0.00){
                    $date = Carbon::now();
                  $from =  Carbon::parse($product_data->special_price_from)->format('Y-m-d');
                  $to =  Carbon::parse($product_data->special_price_to)->format('Y-m-d');
                  $today =  Carbon::parse($date)->format('Y-m-d');
                    if($from <= $today && $today <= $to){
                       $special_price = $product_data->price*$product_data->special_price/100;
                    }
                  }
                    if(!empty ($product_data->discount_value)){
                        if($product_data->discount_type == 'AMT'){
                            $discounted_price = $product_data->discount_value;
                        }
                        if($product_data->discount_type == 'PER'){
                            $discounted_price = $product_data->price*$product_data->discount_value/100;
                        }
                    }
                    
                    if(!empty($special_price) && !empty($discounted_price)){
                        
                            $sale_price =  $product_data->price - ($special_price + $discounted_price);
                        
                    }elseif(!empty ($special_price)){
                        $sale_price = $product_data->price - $special_price; 
                    }elseif(!empty ($discounted_price)){
                        $sale_price = $product_data->price - $discounted_price; 
                    }else{
                        $sale_price = $price;
                    }
                    
                    
                    
                 $newcart = new CartModel; 
                  $newcart->machine_id = $machine_data->id;
                  $newcart->token = $cartToken;
                  $newcart->product_id = $product_data->product_id;
                  $newcart->arduino_id = $product_data->arduino_id;
                  $newcart->machine_product_core_id = $product_data->id;
                  $newcart->quantity = $quantity;
                  $newcart->price = $price;
                  $newcart->sale_price = $sale_price;
                  $newcart->amount = $price * $quantity;
                  $newcart->payable_amount = $sale_price * $quantity;
                  if($sale_price > 0){
                   $newcart->discount = ($price * $quantity) - ($sale_price * $quantity);   
                  }else{
                     $newcart->discount = 0.00; 
                  }
                  
                  $newcart->created_by = $machine_data->id;

                if(!$newcart->save())
                {
                            return response()->json([
                         'code' => '500',
                         'response' => 'Not Added',
                         'message' => 'Error Try Again',


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
        }catch (\Exception $e) {
            return response()->json([
                'response' => 'Error Exception',
                'message' => $e,
               
            ], 500);
        }
        
        
        
        $data = $this->cartList($cartToken);
        if($data && count($data) > 0){
            return response()->json([
              'code' => '200',
              'response' => 'Successfully Added To Cart',
              'message' => 'Cart Product List',
              'data' => $data

          ]);  
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'No Products In Cart',
            
            
        ]);  
        }
        
        
        
    }
    
    
    // decrement product quantity from cart
    
    public function decrementFromCart(Request $request) {
        $this->validate(request(), [
           'cart_token' => 'bail|required',
           'product_id' => 'bail|required',
           'quantity' => 'bail|required',
        ]);
         
        $machine_data = auth()->user(); 
        
        $cartToken = $request->input('cart_token');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Cart Token',
           ]); 
        }
        
         try{
             $product_data = MachineProductModel::where('machine_id',$machine_data->id)->where('id',$product_id)->where('status','ACTIVE')->whereNotNull('arduino_id')->where('quantity','>',0)->first();
       
            if($product_data->product_id){
            
            if(CartModel::where('token',$cartToken)->count() > 0 && CartModel::where('token',$cartToken)->where('machine_product_core_id',$product_id)->where('status','ACTIVE')->exists()){
                
              $updateCart = CartModel::where('token',$cartToken)->where('machine_product_core_id',$product_id)->first();
               $updateQuantity = $updateCart->quantity - $quantity;
              if($updateQuantity == 0){
                    
                      $deleteCart = CartModel::where('token',$cartToken)->where('machine_product_core_id',$product_id)->where('status','ACTIVE')->delete();
                    if(!$deleteCart)
                      {
                                  return response()->json([
                               'code' => '500',
                               'response' => 'Not Removed',
                               'message' => 'Error Product Not Removed',


                           ]); 
                      }
                }else{
                   $updateCart->quantity = $updateQuantity;
                    $updateCart->amount = $updateCart->price * $updateQuantity;
                    $updateCart->payable_amount = $updateCart->sale_price * $updateQuantity;
                    $updateCart->discount = ($updateCart->price * $updateQuantity) - ($updateCart->sale_price * $updateQuantity);
                    $updateCart->updated_by = $machine_data->id;
                    if(!$updateCart->save())
                      {
                                  return response()->json([
                               'code' => '500',
                               'response' => 'Not Updated',
                               'message' => 'Error Product Quantity Not Updated',


                           ]); 
                      } 
                }
              
            }else{
                return response()->json([
                 'code' => '404',
                 'response' => 'Not Found',
                 'message' => 'No Products In Cart',


             ]);  
             }
        }else{
             return response()->json([
                         'code' => '404',
                         'response' => 'Not Found',
                         'message' => 'Error Product Not Found',


                     ]); 
        }
        }catch (\Exception $e) {
            return response()->json([
                'response' => 'Error Exception',
                'message' => $e,
               
            ], 500);
        }
        
        
        
        $data = $this->cartList($cartToken);
        if($data && count($data) > 0){
            return response()->json([
              'code' => '200',
              'response' => 'Successfully Decremented From Cart',
              'message' => 'Cart Product List',
              'data' => $data

          ]);  
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'No Products In Cart',
            
            
        ]);  
        }
        
        
    }
    
    // Remove from cart
    
    public function removeFromCart(Request $request) {
        $this->validate(request(), [
           'cart_token' => 'bail|required',
           'product_id' => 'bail|required',
           
        ]);
         
        $machine_data = auth()->user(); 
        
        $cartToken = $request->input('cart_token');
        $product_id = $request->input('product_id');
        
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Cart Token',
           ]); 
        }
        
        try{
             $product_data = MachineProductModel::where('machine_id',$machine_data->id)->where('id',$product_id)->where('status','ACTIVE')->whereNotNull('arduino_id')->where('quantity','>',0)->first();
       
            if($product_data->product_id){
            
            
            if(CartModel::where('token',$cartToken)->count() > 0 && CartModel::where('token',$cartToken)->where('machine_product_core_id',$product_id)->where('status','ACTIVE')->exists()){
                
                    $deleteCart = CartModel::where('token',$cartToken)->where('machine_product_core_id',$product_id)->where('status','ACTIVE')->delete();
                    if(!$deleteCart)
                      {
                                  return response()->json([
                               'code' => '500',
                               'response' => 'Not Removed',
                               'message' => 'Error Product Not Removed',


                           ]); 
                      }
                
              
            }
            else{
             return response()->json([
                         'code' => '404',
                         'response' => 'Not Found',
                         'message' => 'Error Product Not Found',


                     ]); 
        }
        }else{
             return response()->json([
                         'code' => '404',
                         'response' => 'Not Found',
                         'message' => 'Error Product Not Found',


                     ]); 
        }
        }catch (\Exception $e) {
            return response()->json([
                'response' => 'Error Exception',
                'message' => $e,
               
            ], 500);
        }
        
        
        
        $data = $this->cartList($cartToken);
        if($data && count($data) > 0){
            return response()->json([
              'code' => '200',
              'response' => 'Successfully Removed From Cart',
              'message' => 'Cart Product List',
              'data' => $data

          ]);  
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'No Products In Cart',
            
            
        ]);  
        }
        
        
    }
    
    // clear Cart
    public function clearCart(Request $request) {
         $this->validate(request(), [
           'cart_token' => 'bail|required',
           
        ]);
        $cartToken = $request->input('cart_token');
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Cart Token',
           ]); 
        }
        $machine_data = auth()->user(); 
         try{
       
            
            if(CartModel::where('token',$cartToken)->count() > 0){
                
                    $clearCart = CartModel::where('token',$cartToken)->where('status','ACTIVE')->update(['status' => 'DELETED', "updated_by" => $machine_data->id, "updated_date" => now()]);
                    if(!$clearCart)
                      {
                                  return response()->json([
                               'code' => '500',
                               'response' => 'Not Removed',
                               'message' => 'Error Product Not Removed',


                           ]); 
                      }
                
              
            }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'No Products In Cart',
            
            
        ]);  
        }
        
        }catch (\Exception $e) {
            return response()->json([
                'response' => 'Error Exception',
                'message' => $e,
               
            ], 500);
        }
        
        return response()->json([
                               'code' => '200',
                               'response' => 'Success',
                               'message' => 'Cart Cleared',

                           ]); 
        
        
    }
    
    
    public function checkout(Request $request) 
    {
        $this->validate(request(), [
           'cart_token' => 'bail|required',
           
        ]);
         
        $cartToken = $request->input('cart_token');
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Cart Token',
           ]); 
        }
        $data = CartModel::where('token',$cartToken)->where('status','ACTIVE')->get();
        $cartList = $this->cartList($cartToken);
        if($data && count($data) > 0 && $cartList){
            return response()->json([
              'code' => '200',
              'response' => 'Data Found',
              'message' => 'Cart Product List',
              'data' => $cartList,
              'total_Quantity' => $data->sum('quantity'),
              'sub_total' => $data->sum('amount'),
              'discount' => $data->sum('discount'),
              'total' => $data->sum('payable_amount'),
          ]);  
        }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'No Products In Cart',
            
            
        ]);  
        }
        
    }
    
    
    // generate dynamic qr code to take payment
    
    
    public function generateDynamicQr(Request $request) {
         $this->validate(request(), [
           'cart_token' => 'bail|required',
           'payable_amount' => 'bail|required',
        ]);
        $cartToken = $request->input('cart_token');
        $payable_amount = $request->input('payable_amount');
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Valid Cart Token',
           ]); 
        }
        $machine_data = auth()->user(); 
        $response = "";
         try{
       
            
            if(CartModel::where('token',$cartToken)->count() > 0){
                $data = CartModel::where('token',$cartToken)->where('status','ACTIVE')->get();
                
                if($payable_amount == $data->sum('payable_amount')){
                
                $paytmParams = array();

                $paytmParams["body"] = array(
                    "mid"           => env('PAYTM_MID'),
                    "orderId"       => $cartToken,
                    "amount"        => $payable_amount,
                    "businessType"  => "UPI_QR_CODE", //Type of QR code to be created
                    "posId"         => $machine_data->id
                );
                
                $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), env('PAYTM_MERCHANT_KEY'));
               
                 $paytmParams["head"] = array(
                    "clientId"	        => env('PAYTM_clientId'),
                    "version"	        => env('PAYTM_API_VERSION'),
                    "signature"         => $checksum,
                );
                 
                $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
                /* for Staging */
                $url = "https://securegw-stage.paytm.in/paymentservices/qr/create";
                
                /* for Production */
                // $url = "https://securegw.paytm.in/paymentservices/qr/create";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                $response = curl_exec($ch);
                
                
                
                }else{
                    return response()->json([
                        'code' => '404',
                        'response' => 'Miss Match',
                        'message' => 'Payable Amount Not Matched',

                       ]);  
                }
            }else{
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'No Products In Cart',
            
            
        ]);  
        }
        
        }catch (\Exception $e) {
            return response()->json([
                'response' => 'Error Exception',
                'message' => $e->getMessage(),
               
            ], 500);
        }
        $result = json_decode($response,true);
       
        if($result){
        return response()->json([
                               'code' => $result['body']['resultInfo']['resultCode'],
                               'response' => $result['body']['resultInfo']['resultStatus'],
                               'message' => $result['body']['resultInfo']['resultMsg'],
                                'data' => $result
                           ]); 
        }
        
    }
    
    
    // Placeing Order
    
    public function placeOrder(Request $request) {
        $this->validate(request(), [
           'cart_token' => 'bail|required',
           
        ]);
        $cartToken = $request->input('cart_token');
        $machine_data = auth()->user(); 
        $cartTokenData = CartTokenModel::where('token',$cartToken)->first();
        if($cartTokenData->status != 'ACTIVE'){
           return response()->json([
            'code' => '404',
            'response' => 'Not Found',
            'message' => 'Error Request With Cart Token',
           ]); 
        }
        DB::beginTransaction();
        $cartData = CartModel::where('token',$cartToken)->where('status','ACTIVE')->get();
        $data = [];
        try{
            
            if(count($cartData) > 0){
                
                foreach ($cartData as $value) {
                    $product_data = MachineProductModel::where('machine_id',$value->machine_id)->where('id',$value->machine_product_core_id)->where('status','ACTIVE')->whereNotNull('arduino_id')->where('quantity','>',0)->first();
                    if($product_data->quantity >= $value->quantity){
                        
                        $productdetails = ProductModel::find($value->product_id);
                        $decrementQty = $product_data->quantity - $value->quantity;
                        
                        $newMachineProductSold = new MachineProductSoldModel;
                        $newMachineProductSold->cart_token = $cartToken;
                        $newMachineProductSold->machine_id = $value->machine_id;
                        $newMachineProductSold->product_id = $value->product_id;
                        $newMachineProductSold->category_id = $product_data->category_id;
                        $newMachineProductSold->quantity = $value->quantity;
                        $newMachineProductSold->status = 'DISPENSED';
                        $newMachineProductSold->created_by = $value->machine_id;
                        if($newMachineProductSold->save()){
                            $decrement = MachineProductModel::where('machine_id',$value->machine_id)->where('id',$value->machine_product_core_id)->where('status','ACTIVE')->update(["quantity" => $decrementQty, "updated_by" => $value->machine_id, "updated_date" => now()]);
                            if(!$decrement){
                                 return response()->json([
                                    'response' => 'Error Decrementing Quantity',
                                    'message' => 'Quantity Not Decremented',

                                ], 500);
                            }
                            $data[] = [
                                'category_id' => $product_data->category_id,
                                'product_id' => $value->machine_product_core_id,
                                'machine_id' => $value->machine_id,
                                'token' => $value->token,
                                'name' => $productdetails->name,
                                'image' => $productdetails->image,
                                'arduino_id' => $product_data->arduino_id,
                                'quantity' => $value->quantity,
                                'price' => $value->price,
                                'sale_price' => $value->sale_price,
                                    ];
                            
                        }
                    }else{
                      return response()->json([
                        'code' => '404',
                        'response' => 'Not Found',
                        'message' => 'Product Not Available',


                    ]);    
                    }
                }
                // marking token as used
                $tokenUsed =  $cartTokenData = CartTokenModel::where('token',$cartToken)->where('status','ACTIVE')->update(["status" => 'USED', "updated_by" => $machine_data->id, "updated_date" => now()]);
                if(!$tokenUsed){
                                 return response()->json([
                                    'response' => 'Error Marking Token',
                                    'message' => 'Unable To Mark As Used',

                                ], 500);
                            }
                // marking cart data as DISPENSED
                $cartDispensed = CartModel::where('token',$cartToken)->where('status','ACTIVE')->update(["status" => 'DISPENSED', "updated_by" => $machine_data->id, "updated_date" => now()]);
             if(!$cartDispensed){
                                 return response()->json([
                                    'response' => 'Error Marking Cart',
                                    'message' => 'Unable To Mark cart As DISPENSED',

                                ], 500);
                            }
            }else{
               return response()->json([
                'code' => '404',
                'response' => 'Not Found',
                'message' => 'No Products In Cart',


            ]);  
            }
            
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'response' => 'Error Exception',
                'message' => $e,
               
            ], 500);
        }
        
         DB::commit();
        
       if($data && count($data) > 0){
            return response()->json([
              'code' => '200',
              'response' => 'Order Placed',
              'message' => 'Product Dispense List',
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
    
    
    
    // generating Unique Access Code for Machine
    protected function generateCartToken() {
        $code="";
        do {
        $code = Str::random(10);
        $data = CartTokenModel::where('token',$code)->get();
       }
    while ($data->count()>0);
    return $code;
    }
    
    protected function cartList($token) {
        $data = [];
        $cartData = CartModel::where('token',$token)->where('status','ACTIVE')->get();
        
        if(count($cartData) > 0){
                
                foreach ($cartData as $value) {
                  $product_data = MachineProductModel::where('machine_id',$value->machine_id)->where('id',$value->machine_product_core_id)->where('status','ACTIVE')->whereNotNull('arduino_id')->where('quantity','>',0)->first();
                  $productdetails = ProductModel::find($value->product_id);  
                  if($product_data->id && $productdetails->status == 'ACTIVE'){
                      $data[] = [
                                'category_id' => $product_data->category_id,
                                'product_id' => $value->machine_product_core_id,
                                'machine_id' => $value->machine_id,
                                'token' => $value->token,
                                'name' => $productdetails->name,
                                'image' => $productdetails->image,
                                'arduino_id' => $value->arduino_id,
                                'quantity' => $value->quantity,
                                'price' => $value->price,
                                'sale_price' => $value->sale_price,
                                'amount' => $value->amount,
                                'payable_amount' => $value->payable_amount,
                                'discount' => $value->discount,
                                    ];
                  }
                }
        }else{
            return false;
        }
        return $data;
    }
    
    
}
