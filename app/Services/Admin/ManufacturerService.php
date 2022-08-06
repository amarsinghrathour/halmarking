<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of StudentClassService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Manufacturer;
class ManufacturerService {
    //put your code here
    public static function save($request) {

        $name = htmlspecialchars(strip_tags($request->input('name')));
        $url = htmlspecialchars(strip_tags($request->input('url')));
        $imageDb = '';
        try {
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'manufacturer','manufacturer');
                if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
                return false;
            }
            }
            
            


            $course = new Manufacturer;
            $course->name = $name;
            $course->url = $url;
             if(!$imageDb){
             $course->image = $imageDb;
             }
            $course->created_by = auth()->user()->email;
            if ($course->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                
                session()->put('error', "Error Occured While Data Storing Please try again !");
                if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                    unlink(public_path().'/'.$imageDb);
                }
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                    unlink(public_path().'/'.$imageDb);
                }
            return false;
        }



        return false;
    }

    public static function update($request) {

        $id = $request->input('id');
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $url = htmlspecialchars(strip_tags($request->input('url')));
 $imageDb = '';
        $oldImageDb = '';
        try {
            DB::beginTransaction();
            if($request->hasFile('image')){
                $imageDb = uploadImage($request->file('image'), 'manufacturer','manufacturer');
                if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
                return false;
            }
            }


            $course = Manufacturer::find($id);
            $course->name = $name;
            $course->url = $url;
             if(!empty($imageDb)){
                $oldImageDb = $course->image;
                $course->image = $imageDb;
            }
            $course->updated_by = auth()->user()->email;
            if ($course->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
               if(!empty($oldImageDb) && file_exists(public_path().'/'.$oldImageDb)){
                unlink(public_path().'/'.$oldImageDb);
            }
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
               
                session()->put('error', "Error Occured While Data Storing Please try again !");
                if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
           
            session()->put('error', "Exception While Data Storing Please try again !");
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            return false;
        }



        return false;
    }
}
