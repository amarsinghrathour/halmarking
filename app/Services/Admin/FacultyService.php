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
class FacultyService {
    //put your code here
    public static function save($request) {

        $name = htmlspecialchars(strip_tags($request->input('name')));
        $class = $request->input('class');
        $class = implode(',', $class);
        $section = $request->input('section');
        $section = implode(',', $section);
        $subject = $request->input('subject');
        $subject = implode(',', $subject);
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $qualification = $request->input('qualification');
        $designation = $request->input('designation');
        $father_name = $request->input('father_name');
        $dob = $request->input('dob');
        

        $imageDb = '';
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $imageDb = uploadImage($request->file('image'), 'faculty', 'faculty');
            }

            if (!$imageDb) {
                session()->put('error', "Error while uploading Image !");
                return false;
            }

            $facultyNew = new Faculty;
            $facultyNew->classes = $class;
            $facultyNew->subjects = $subject;
            $facultyNew->sections = $section;
            $facultyNew->email = $email;
            $facultyNew->mobile = $mobile;
            $facultyNew->qualification = $qualification;
            $facultyNew->designation = $designation;
            $facultyNew->father_name = $father_name;
            $facultyNew->dob = $dob;
            $facultyNew->name = $name;
            $facultyNew->image = $imageDb;
            $facultyNew->created_by = auth()->user()->email;
            if ($facultyNew->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
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

    public static function update($request) {

        $id = $request->input('id');
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $class = $request->input('class');
        $class = implode(',', $class);
        $section = $request->input('section');
        $section = implode(',', $section);
        $subject = $request->input('subject');
        $subject = implode(',', $subject);
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $qualification = $request->input('qualification');
        $designation = $request->input('designation');
        $father_name = $request->input('father_name');
        $dob = $request->input('dob');

        $imageDb = '';
        $oldImageDb = '';
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $imageDb = uploadImage($request->file('image'), 'faculty', 'faculty');
            }


            $facultyNew = Faculty::find($id);
             $facultyNew->classes = $class;
            $facultyNew->subjects = $subject;
            $facultyNew->sections = $section;
            $facultyNew->email = $email;
            $facultyNew->mobile = $mobile;
            $facultyNew->qualification = $qualification;
            $facultyNew->designation = $designation;
            $facultyNew->father_name = $father_name;
            $facultyNew->dob = $dob;
            $facultyNew->name = $name;
            
            if (!empty($imageDb)) {
                $oldImageDb = $facultyNew->image;
                $facultyNew->image = $imageDb;
            }
            $facultyNew->updated_by = auth()->user()->email;
            if ($facultyNew->save()) {
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
