<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of FacultyService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Faculty;
use App\Models\ProductInventory;
use App\Models\Product;
use App\Models\Unit;
class ProductService {
    //put your code here
    public static function save($request) {

        $product = htmlspecialchars(strip_tags($request->input('name')));
        $hsn_code = htmlspecialchars(strip_tags($request->input('hsn_code')));
        $description = htmlspecialchars(strip_tags($request->input('description')));
        $cost_price = htmlspecialchars(strip_tags($request->input('cost_price')));
        $mrp = htmlspecialchars(strip_tags($request->input('mrp')));
        $unit_id = htmlspecialchars(strip_tags($request->input('unit_id')));
        $slug = self::create_slug($product);
        $product_id = self::generateProductId();
        if(empty($product_id)){
          session()->put('error',"Error While generating  slug For Product :: $product!");
            return Redirect::back();  
        }
        if(empty($slug)){
            session()->put('error',"Error While generating  product id For Product :: $product!");
            return Redirect::back();
        }
        $imageDb = '';
        try{
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'product','product');
            }
            
            $newProduct = new Product;
            $newProduct->name = $product;
            $newProduct->product_id = $product_id;
            $newProduct->unit_id = $unit_id;
            $newProduct->description = $description;
            if(!empty($imageDb)){
                $newProduct->image = $imageDb;
            }
            $newProduct->slug = $slug;
            $newProduct->cost_price = $cost_price;
            $newProduct->mrp = $mrp;
            $newProduct->hsn_code = $hsn_code;
            $newProduct->created_by = auth()->user()->email;
            if($newProduct->save()){
                
                if($request->hasfile('image_id'))
                {
                    $gallerydata = [];$gallerImages = [];
                   foreach($request->file('image_id') as $file)
                   {
                       $galleryImage = uploadImage($file, 'product','product');
                       
                       if(!$galleryImage)
                        {
                            session()->put("error","Product Gallery Image uploading failed. please try again.");
                            return Redirect::back();
                        }
                      $gallerydata[] = [
                                        'product_id' => $newProduct->id,
                                        'image' => $galleryImage,
                                        'created_by' => auth()->user()->email,
                                        'status' => 'ACTIVE',
                                         ]; 
                       $gallerImages[] = $galleryImage;
                   }
                  if(!ProductGallery::insert($gallerydata)){
                      for($i=0;$i<count($galleryImage);$i++){
                          $path = public_path().$galleryImage[$i];
                            if (File::exists($path)) 
                            {
                              File::delete($path);
                            }
                      }
                      session()->put("error","Product Gallery Image inserting failed. please try again.");
                            return false;
                  }
                }
                
                 DB::commit();
             session()->put('success',"Data Saved Successfully For Product :: $product.");
             return true;
            }else{
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error',"Error Occured While Data Storing For Product :: $product. Please try again !");
            return false;
            }
            
        }catch(\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error',"Exception While Data Storing For Product :: $product. Please try again !");
            return false;
        }
        return false;
    }

    public static function update($request) {

        $product = htmlspecialchars(strip_tags($request->input('name')));
        $id = htmlspecialchars(strip_tags($request->input('id')));
       $hsn_code = htmlspecialchars(strip_tags($request->input('hsn_code')));
        $description = htmlspecialchars(strip_tags($request->input('description')));
        $cost_price = htmlspecialchars(strip_tags($request->input('cost_price')));
        $mrp = htmlspecialchars(strip_tags($request->input('mrp')));
        $unit_id = htmlspecialchars(strip_tags($request->input('unit_id')));
        $imageDb = '';$similar_ids = '';
         
        try{
            DB::beginTransaction();
            $newProduct = Product::find($id);
            if($newProduct->name != $product){
              $newProduct->slug = $this->create_slug($product);  
            }
            if($request->hasFile('image')){
               // $imageDb = uploadImage($request->file('image'), 'product');
                $imageDb = uploadImage($request->file('image'), 'product','product','product');
            }
            $oldPath = '';
            
            $newProduct->name = $product;
            $newProduct->unit_id = $unit_id;
            $newProduct->description = $description;
            
            $newProduct->cost_price = $cost_price;
            $newProduct->mrp = $mrp;
            $newProduct->hsn_code = $hsn_code;
            if(!empty($imageDb)){
                $oldPath = $newProduct->image;
                $newProduct->image = $imageDb;
                
            }
            
            $newProduct->updated_by = auth()->user()->email;
            if($newProduct->save()){
                if(!empty($oldPath)){
                unlink(public_path().$oldPath);
                }
                if($request->hasfile('image_id'))
                {
                    $gallerydata = [];$gallerImages = [];
                   foreach($request->file('image_id') as $file)
                   {
                       //$galleryImage = uploadImage($file,'product');
                       $galleryImage = uploadImage($file, 'product','product');
                       
                       if(!$galleryImage)
                        {
                            session()->put("error","Product Gallery Image uploading failed. please try again.");
                            return Redirect::route('product.edit',['id'=>$id]);
                        }
                      $gallerydata[] = [
                                        'product_id' => $newProduct->id,
                                        'image' => $galleryImage,
                                        'created_by' => auth()->user()->email,
                                        'status' => 'ACTIVE',
                                         ]; 
                       $gallerImages[] = $galleryImage;
                   }
                  if(!ProductGallery::insert($gallerydata)){
                      for($i=0;$i<count($galleryImage);$i++){
                          $path = public_path().$galleryImage[$i];
                            if (File::exists($path)) 
                            {
                              File::delete($path);
                            }
                      }
                      session()->put("error","Product Gallery Image inserting failed. please try again.");
                           return false;
                  }
                }
             session()->put('success',"Data Updated Successfully For Product :: $product.");
             DB::commit();
             return true;
            }else{
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured while Updating Product");
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error',"Error Occured While Data Updating For Product :: $product. Please try again !");
            return false;
            }
            
        }catch(\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error',"Exception While Data Updating For Product :: $product. Please try again !");
            return false;
        }
        
        
        


        return false;
    }
    
    protected static function create_slug($string){
        $slug = ""; 
        do{
            //$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
           $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
            $data = Product::where('slug',$slug)->count();
            if($data > 0){
               $string = $slug.'-'.$data; 
            }
        }
        while ($data > 0);
        
   
   
   return $slug;
}
protected static function generateProductId() {
        $code = "";
        do {
            $code = substr(uniqid(mt_rand(), true) , 0, 10);
            $data = Product::where('product_id', $code)->get();
        } while ($data->count() > 0);
        return $code;
    }
    
    
    public static function refill($request) {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $description = $request->input('description');
        try{
            DB::beginTransaction();
             $refillproduct = new ProductInventory;
            $refillproduct->product_id = $product_id;
            $refillproduct->quantity = $quantity;
            $refillproduct->description = $description;
            
            $refillproduct->created_by = auth()->user()->email;
            

            if($refillproduct->save())
            {
               $updateQty = Product::where('id',$product_id)->increment('quantity',$quantity);
               if(!$updateQty){
                   Log::error(__CLASS__."::".__FUNCTION__."Product Quantity Update failed for Product ");
                session()->put("error","Product Quantity Update Failed for Product ");
               }else{ 
                   Log::debug(__CLASS__."::".__FUNCTION__." Product Refilled successfully In Product ");
                    session()->put("success","Product Refilled successfully In Product ");
                    DB::commit();
                    return true;
               }
               
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." Product Refilling failed for Product ");
                session()->put("error","Product Refilling failed for Product ");
                return false;
            } 
           
            
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__." Exception :: ".$e->getMessage());
            session()->put("error","Exception while Product Refilling for Product Please try again");
            
            return false;
        }
        
        return false;
    }
    
    
}
