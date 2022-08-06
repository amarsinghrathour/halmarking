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
use App\Models\Size;
class SizeService {
    //put your code here
    public static function save($request) {

        $name = htmlspecialchars(strip_tags($request->input('name')));
        
        try {
            DB::beginTransaction();
            


            $course = new Size;
            $course->name = $name;

            
            $course->created_by = auth()->user()->email;
            if ($course->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }

    public static function update($request) {

        $id = $request->input('id');
        $name = htmlspecialchars(strip_tags($request->input('name')));

        try {
            DB::beginTransaction();
            


            $course = Size::find($id);
            $course->name = $name;
            
            $course->updated_by = auth()->user()->email;
            if ($course->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
               
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
               
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
           
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }
}
