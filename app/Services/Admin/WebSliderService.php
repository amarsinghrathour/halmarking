<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of WebSliderService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WebSlider;
class WebSliderService {
    //put your code here
    
    public static function save($request) {
        
        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = htmlspecialchars(strip_tags($request->input('description')));
        $sub_title = htmlspecialchars(strip_tags($request->input('sub_title')));
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));
        
        $imageDb = '';
        try{
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'slider','slider');
            }
            
            if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
                return false;
            }
            
            $newSlider = new WebSlider;
            $newSlider->title = $title;
            $newSlider->sub_title = $sub_title;
            $newSlider->description = $description;
            $newSlider->sort_order = $sort_order;
            
                $newSlider->image = $imageDb;
            $newSlider->created_by = auth()->user()->email;
            if($newSlider->save()){
             session()->put('success',"Data Saved Successfully");
              DB::commit();
              return true;
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Storing Please try again !");
            return false;
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Storing Please try again !");
            return false;
        }
        
        
       
        return false;
        
    }
    
    public static function update($request) {
        
        $id = $request->input('id');
        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = htmlspecialchars(strip_tags($request->input('description')));
        $sub_title = htmlspecialchars(strip_tags($request->input('sub_title')));
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));
        
        $imageDb = '';
        $oldImageDb = '';
        try{
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'slider','slider');
            }
            
            
            $newSlider = WebSlider::find($id);
            $newSlider->title = $title;
            $newSlider->sub_title = $sub_title;
            $newSlider->description = $description;
            $newSlider->sort_order = $sort_order;
            if(!empty($imageDb)){
                $oldImageDb = $newSlider->image;
                $newSlider->image = $imageDb;
            }
            $newSlider->updated_by = auth()->user()->email;
            if($newSlider->save()){
             session()->put('success',"Data Saved Successfully");
              DB::commit();
              if(!empty($oldImageDb) && file_exists(public_path().'/'.$oldImageDb)){
                unlink(public_path().'/'.$oldImageDb);
            }
              return true;
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Storing Please try again !");
            return false;
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Storing Please try again !");
            return false;
        }
        
        
       
        return false;
        
    }
}
