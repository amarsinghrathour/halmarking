<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of WebPageService
 *
 * @author singh
 */
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class OurService {
    //put your code here
    
     public static function save($request) {

      $category = htmlspecialchars(strip_tags($request->input('title')));
        
        $description = $request->input('description');
        $price_range = htmlspecialchars(strip_tags($request->input('price_range')));
        $slug = self::create_slug($category);
        $imageDb = '';
        try{
             DB::beginTransaction();
            if($request->hasFile('icon')){
                $imageDb = uploadImage($request->file('icon'), 'service','icon');
            }
            if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
              return false;
            }
            $newService = new Service;
            $newService->title = $category;
            $newService->description = $description;
            $newService->price_range = $price_range;
            if(!empty($imageDb)){
                $newService->icon = $imageDb;
            }
            
            $newService->url = $slug;
            
            $newService->created_by = auth()->user()->email;
            if($newService->save()){
             session()->put('success',"Data Saved Successfully For Service :: $category.");
             DB::commit();
             return true;
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Storing For Service :: $category. Please try again !");
           return false;
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Storing For Service :: $category. Please try again !");
           return false;
        }
        
        

        return false;
    }
    
    public static function update($request) {

        $category = $request->input('title');
        $description = $request->input('description');
        $price_range = htmlspecialchars(strip_tags($request->input('price_range')));
        $id = $request->input('id');
        $imageDb = '';
        try{
             DB::beginTransaction();
            if($request->hasFile('icon')){
                $imageDb = uploadImage($request->file('icon'),'service','icon');
                if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
               return false;
            }
            }
            $oldPath = '';
            $newService = Service::find($id);
            if($newService->title != $category){
                $newService->title = $category;
              $newService->url = self::create_slug($category);  
            }
            $newService->description = $description;
            $newService->price_range = $price_range;
            if(!empty($imageDb)){
                $oldPath = $newService->icon;
                $newService->icon = $imageDb;
                
            }
            
            $newService->updated_by = auth()->user()->email;
            if($newService->save()){
                if(!empty($oldPath)){
                unlink(public_path().'/'.$oldPath);
                }
             session()->put('success',"Data Updated Successfully For Service :: $category.");
             DB::commit();
             return true;
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured while Updating Service");
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Updating For Service :: $category. Please try again !");
            return false;
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Updating For Service :: $category. Please try again !");
            return false;
        }



        return false;
    }
    
    
    protected static function create_slug($string){
        $slug = ""; 
        do{
            //$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
           $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
            $data = Service::where('url',$slug)->count();
            if($data > 0){
               $string = $slug.'-'.$data; 
            }
        }
        while ($data > 0);
        
   
   
   return $slug;
}

}
