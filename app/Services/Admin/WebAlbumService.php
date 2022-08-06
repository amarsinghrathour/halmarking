<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of WebAlbumService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WebAlbum;

class WebAlbumService {
    //put your code here
    public static function save($request) {
        
        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = htmlspecialchars(strip_tags($request->input('description')));
        $url = self::create_slug($title);
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));
        
        $imageDb = '';
        try{
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'gallery','gallery');
            }
            
            if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
                return false;
            }
            
            $newAlbum = new WebAlbum;
            $newAlbum->title = $title;
            $newAlbum->url = $url;
            $newAlbum->description = $description;
            $newAlbum->sort_order = $sort_order;
            
                $newAlbum->image = $imageDb;
            $newAlbum->created_by = auth()->user()->email;
            if($newAlbum->save()){
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
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));
        
        $imageDb = '';
        $oldImageDb = '';
        try{
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'gallery','gallery');
            }
            
            
            $newAlbum = WebAlbum::find($id);
            $newAlbum->title = $title;
           if($newAlbum->title != $title){
              $newAlbum->url = self::create_slug($title);  
            }
            $newAlbum->description = $description;
            $newAlbum->sort_order = $sort_order;
            if(!empty($imageDb)){
                $oldImageDb = $newAlbum->image;
                $newAlbum->image = $imageDb;
            }
            $newAlbum->updated_by = auth()->user()->email;
            if($newAlbum->save()){
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
    
    protected static function create_slug($string){
        $slug = "";
        do{
            //$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
           $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
            $data = WebAlbum::where('url',$slug)->count();
            if($data > 0){
               $string = $slug.'-'.$data; 
            }
        }
        while ($data > 0);
   
   
   return $slug;
}
    
}
