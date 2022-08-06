<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of AddmissionService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admission;
class AdmissionService {
    //put your code here
    
    public static function update($request) {

        $id = $request->input('id');
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $class = htmlspecialchars(strip_tags($request->input('class')));
        $session = htmlspecialchars(strip_tags($request->input('session')));
        $reservation_category = htmlspecialchars(strip_tags($request->input('reservation_category')));
        $dob = htmlspecialchars(strip_tags($request->input('dob')));
        $gender = htmlspecialchars(strip_tags($request->input('gender')));
        $aadhar_no = htmlspecialchars(strip_tags($request->input('aadhar_no')));
        $father_name = htmlspecialchars(strip_tags($request->input('father_name')));
        $father_occupation = htmlspecialchars(strip_tags($request->input('father_occupation')));
        $mother_name = htmlspecialchars(strip_tags($request->input('mother_name')));
        $mother_occupation = htmlspecialchars(strip_tags($request->input('mother_occupation')));
        $permanent_address = htmlspecialchars(strip_tags($request->input('permanent_address')));
        $permanent_address_district = htmlspecialchars(strip_tags($request->input('permanent_address_district')));
        $permanent_address_state = htmlspecialchars(strip_tags($request->input('permanent_address_state')));
        $permanent_address_pincode = htmlspecialchars(strip_tags($request->input('permanent_address_pincode')));
        $is_same_correspondance = htmlspecialchars(strip_tags($request->input('is_same_correspondance')));
        $corresspondance_address = htmlspecialchars(strip_tags($request->input('corresspondance_address')));
        $correspondence_address_district = htmlspecialchars(strip_tags($request->input('correspondence_address_district')));
        $correspondence_address_state = htmlspecialchars(strip_tags($request->input('correspondence_address_state')));
        $correspondence_address_pincode = htmlspecialchars(strip_tags($request->input('correspondence_address_pincode')));
        $mobile = htmlspecialchars(strip_tags($request->input('mobile')));
        $whatsapp_no = htmlspecialchars(strip_tags($request->input('whatsapp_no')));
        $email = htmlspecialchars(strip_tags($request->input('email')));
        $is_guardian = htmlspecialchars(strip_tags($request->input('is_guardian')));
        $guardian_name = htmlspecialchars(strip_tags($request->input('guardian_name')));
        $guardian_address = htmlspecialchars(strip_tags($request->input('guardian_address')));
        $guardian_address_district = htmlspecialchars(strip_tags($request->input('guardian_address_district')));
        $guardian_address_state = htmlspecialchars(strip_tags($request->input('guardian_address_state')));
        $guardian_address_pincode = htmlspecialchars(strip_tags($request->input('guardian_address_pincode')));
        $guardian_mobile = htmlspecialchars(strip_tags($request->input('guardian_mobile')));
        $guardian_whatsapp_no = htmlspecialchars(strip_tags($request->input('guardian_whatsapp_no')));
        $guardian_email = htmlspecialchars(strip_tags($request->input('guardian_email')));
        $previous_school_name = htmlspecialchars(strip_tags($request->input('previous_school_name')));
        $previous_school_address = htmlspecialchars(strip_tags($request->input('previous_school_address')));
        if(empty($is_guardian)){
            $is_guardian = 'N';
        }else{
            if(empty($guardian_name) || empty($guardian_address) || empty($guardian_address_district) || empty($guardian_address_state) || empty($guardian_address_pincode)){
                session()->put('error', "Guardian address details are manadatory !");
               
                return false;
            }
            if(empty($guardian_mobile) || empty($guardian_whatsapp_no) || empty($guardian_email)){
                session()->put('error', "Guardian contact details are manadatory !");
               
                return false;
            }
        }
        
        if(empty($is_same_correspondance)){
            $is_same_correspondance = 'N';
        }
        
         $imageDb = '';
        $oldImageDb = '';
        try {
            DB::beginTransaction();
            
            if ($request->hasFile('image')) {
                            $imageDb = uploadImage($request->file('image'), 'admission', 'admission');
                        }

            $admission = Admission::find($id);
            $admission->name = $name;
            $admission->class = $class;
            $admission->session = $session;
            $admission->reservation_category = $reservation_category;
            $admission->dob = $dob;
            $admission->gender = $gender;
            $admission->aadhar_no = $aadhar_no;
            $admission->father_name = $father_name;
            $admission->father_occupation = $father_occupation;
            $admission->mother_name = $mother_name;
            $admission->mother_occupation = $mother_occupation;
            $admission->permanent_address = $permanent_address;
            $admission->permanent_address_district = $permanent_address_district;
            $admission->permanent_address_state = $permanent_address_state;
            $admission->permanent_address_pincode = $permanent_address_pincode;
            $admission->is_same_correspondance = $is_same_correspondance;
            $admission->corresspondance_address = $corresspondance_address;
            $admission->correspondence_address_district = $correspondence_address_district;
            $admission->correspondence_address_state = $correspondence_address_state;
            $admission->correspondence_address_pincode = $correspondence_address_pincode;
            $admission->mobile = $mobile;
            $admission->whatsapp_no = $whatsapp_no;
            $admission->email = $email;
            $admission->is_guardian = $is_guardian;
            $admission->guardian_name = $guardian_name;
            $admission->guardian_address = $guardian_address;
            $admission->guardian_address_district = $guardian_address_district;
            $admission->guardian_address_state = $guardian_address_state;
            $admission->guardian_address_pincode = $guardian_address_pincode;
            $admission->guardian_mobile = $guardian_mobile;
            $admission->guardian_whatsapp_no = $guardian_whatsapp_no;
            $admission->guardian_email = $guardian_email;
            $admission->previous_school_name = $previous_school_name;
            $admission->previous_school_address = $previous_school_address;
            
            
            
            if (!empty($imageDb)) {
                $oldImageDb = $admission->image;
                $admission->image = $imageDb;
            }
            $admission->updated_by = auth()->user()->email;
            if ($admission->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
               if (!empty($oldImageDb) && file_exists(public_path() . '/' . $oldImageDb)) {
                    unlink(public_path() . '/' . $oldImageDb);
                }
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
               if (!empty($imageDb) && file_exists(public_path() . '/' . $imageDb)) {
                    unlink(public_path() . '/' . $imageDb);
                }
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
           if (!empty($imageDb) && file_exists(public_path() . '/' . $imageDb)) {
                unlink(public_path() . '/' . $imageDb);
            }
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }
    
}
