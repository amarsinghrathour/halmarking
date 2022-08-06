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
use App\Models\Customer;
class CustomerService {
    //put your code here
    public static function save($request) {

        $name = htmlspecialchars(strip_tags($request->input('name')));
        $mobile = $request->input('mobile');
        $state_id = $request->input('state_id');
        $gstin = $request->input('gstin');
        $address = $request->input('address');
        $pin_code = $request->input('pin_code');
        
        Log::debug(__CLASS__ . "::" . __FUNCTION__ . "Called");
       
        if(!empty($gstin)){
            $gstExits = Customer::where('gstin',$gstin)->count();
            if($gstExits > 0){
                session()->put('error', "GSTIN Already Taken");
                return false;
            }
        }
        
        try {
            DB::beginTransaction();
            

            $customerNew = new Customer;
            $customerNew->name = $name;
            $customerNew->mobile = $mobile;
            $customerNew->gstin = $gstin;
            $customerNew->address = $address;
            $customerNew->state_id = $state_id;
            $customerNew->pin_code = $pin_code;
            
            
            
            $customerNew->created_by = auth()->user()->email;
            if ($customerNew->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
            } else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }

    public static function update($request) {

        $id = $request->input('id');
        
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $mobile = $request->input('mobile');
        
        Log::debug(__CLASS__ . "::" . __FUNCTION__ . "Called");
        /*
       if(!empty($gstin)){
            $gstExits = Customer::where('gstin',$gstin)->count();
            if($gstExits > 1){
                session()->put('error', "GSTIN Already Taken");
                return false;
            }
        }
        */
        try {
            DB::beginTransaction();
            

            $customerNew = Customer::find($id);
            $customerNew->name = $name;
            $customerNew->mobile = $mobile;
            
            
            
            $customerNew->updated_by = auth()->user()->email;
            if ($customerNew->save()) {
                session()->put('success', "Data Update Successfully");
                DB::commit();
                return true;
            } else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                session()->put('error', "Error Occured While Data Updating Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            session()->put('error', "Exception While Data Updating Please try again !");
            return false;
        }




        return false;
    }
    
}
