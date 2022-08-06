<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of AppointmentService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AppointmentHistory;
use App\Models\Appointment;
class AppointmentService {
    //put your code here
    
    public static function update($request) {

        $appointment_date = $request->input('appointment_date');
        $appointment_start_time = $request->input('appointment_start_time');
        $appointment_end_time = $request->input('appointment_end_time');
        $id = $request->input('id');
        
        try{
             DB::beginTransaction();
            
            $newService = Appointment::find($id);
          
                $newService->appointment_date = $appointment_date;
            
            $newService->appointment_start_time = $appointment_start_time;
            $newService->appointment_end_time = $appointment_end_time;
            
            
            $newService->updated_by = auth()->user()->email;
            if($newService->save()){
                
             session()->put('success',"Data Updated Successfully .");
             DB::commit();
             return true;
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured while Updating Service");
            
            session()->put('error',"Error Occured While Data Updating . Please try again !");
            return false;
            }
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            
            session()->put('error',"Exception While Data Updating, Please try again !");
            return false;
        }



        return false;
    }
    
    public static function insertAppointmentHistory($appoint_id,$status,$description=null){
        try{
            $history = new AppointmentHistory;
            $history->appointment_id = $appoint_id;
            $history->description = $description;
            $history->status = $status;
            $history->created_by = auth()->user()->email;
            if($history->save()){
                Log::debug(__CLASS__."::".__FUNCTION__." Inserted Appointment History for appointment $appoint_id ");
                return true;
            }
            
        } catch (\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__." Error Ocurred ".$e->getTraceAsString());
            return false;
        }
         return false;
    }


    
}
