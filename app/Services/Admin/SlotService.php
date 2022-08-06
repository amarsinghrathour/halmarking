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
use App\Models\SlotDate;
use App\Models\SlotTime;
use DateTime;
class SlotService {
    //put your code here
    public static function save($request) {

        $slot_date = htmlspecialchars(strip_tags($request->input('slot_date')));
        $sometimeOut = htmlspecialchars(strip_tags($request->input('interval')));
        $start_time = htmlspecialchars(strip_tags($request->input('start_time')));
        $end_time = htmlspecialchars(strip_tags($request->input('end_time')));
        $proceed = 'NO';
        try {
            DB::beginTransaction();
            


            $slot = new SlotDate;
            $slot->slot_date = $slot_date;
            

            
            $slot->created_by = auth()->user()->email;
            
            if ($slot->save()) {
                $proceed = 'YES';
               $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $BeginTimeStemp = $start->format('H:i'); // Get time Format in Hour and minutes
        $lastTimeStemp = $end->format('H:i');
        $i=0;
                while(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                    $start = $BeginTimeStemp;
                    $end = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $BeginTimeStemp = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $i++;
                    if(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                        $slot_time = new SlotTime;
                        $slot_time->slot_date_id = $slot->id;
                        $slot_time->start_time = $start;
                        $slot_time->end_time = $end;
                        $slot_time->created_by = auth()->user()->email;
                        if (!$slot_time->save()) {
                            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured while slot time creation");
                            $proceed = 'NO';
                session()->put('error', "Error Occured While Slot Creation Please try again !");
                        }
                    }
                }
            } else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                $proceed = 'NO';
                session()->put('error', "Error Occured While Data Storing Please try again !");
            }
            if($proceed == 'YES'){
                 session()->put('success', "Slot Saved Successfully");
                DB::commit();
                return true;
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
        $slot_date = htmlspecialchars(strip_tags($request->input('slot_date')));
        $slot_time_id = $request->input('slot_time_id');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $slot_status = $request->input('slot_status');
        $proceed = 'NO';
        try {
            DB::beginTransaction();
            


            $slot = SlotDate::find($id);
            $slot->slot_date = $slot_date;
            

            
            $slot->updated_by = auth()->user()->email;
            
            if ($slot->save()) {
                $proceed = 'YES';
                for($i=0;$i<count($slot_time_id);$i++){
                    $slot_ids = $slot_time_id[$i];
                    $start = $start_time[$slot_ids];
                    $end = $end_time[$slot_ids];
                    if($start < $end){
                        $slot_time = SlotTime::find($slot_ids);
                        $slot_time->slot_date_id = $id;
                        $slot_time->start_time = $start;
                        $slot_time->end_time = $end;
                        $slot_time->status = $slot_status[$slot_ids];
                        $slot_time->updated_by = auth()->user()->email;
                        if (!$slot_time->save()) {
                            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured while slot time creation");
                            $proceed = 'NO';
                session()->put('error', "Error Occured While Slot Creation Please try again !");
                        }
                    }else{
                        Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured due slot time start < end time");
                            $proceed = 'NO';
                session()->put('error', "Error Occured  Slot time is not correctly entered at row $slot_ids !");
                    }
                }
            } else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                $proceed = 'NO';
                session()->put('error', "Error Occured While Data Storing Please try again !");
            }
            if($proceed == 'YES'){
                 session()->put('success', "Slot Updated Successfully");
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }
    
    function getTimeSlot($sometimeOut, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $BeginTimeStemp = $start->format('H:i'); // Get time Format in Hour and minutes
    $lastTimeStemp = $end->format('H:i');
    $i=0;
    while(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
        $start = $BeginTimeStemp;
        $end = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
        $BeginTimeStemp = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
        $i++;
        if(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
            $time[$i]['start'] = $start;
            $time[$i]['end'] = $end;
        }
    }
    return $time;
}
    
}
