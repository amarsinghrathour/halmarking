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
use App\Models\Job;
class JobService {
    //put your code here
    public static function save($request) {

        $job_number = htmlspecialchars(strip_tags($request->input('job_number')));
        $product_purity = htmlspecialchars(strip_tags($request->input('product_purity')));
        $no_of_product = htmlspecialchars(strip_tags($request->input('no_of_product')));
        $product_lot = htmlspecialchars(strip_tags($request->input('product_lot')));
        $cg1_m1 = htmlspecialchars(strip_tags($request->input('cg1_m1')));
        $cg1_m2 = htmlspecialchars(strip_tags($request->input('cg1_m2')));
        $cg2_m1 = htmlspecialchars(strip_tags($request->input('cg2_m1')));
        $cg2_m2 = htmlspecialchars(strip_tags($request->input('cg2_m2')));
        
        try {
            DB::beginTransaction();
            
            
            


            $job = new Job;
            $job->job_no = $job_number;
            $job->purity = $product_purity;
            $job->no_of_products = $no_of_product;
            $job->lot_size = $product_lot;
            $job->cg1_m1 = $cg1_m1;
            $job->cg1_m2 = $cg1_m2;
             $job->cg2_m1 = $cg2_m1;
            $job->cg2_m2 = $cg2_m2;
             
            $job->created_by = auth()->user()->email;
            
            if ($job->save()) {
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
        $job_number = htmlspecialchars(strip_tags($request->input('job_number')));
        $product_purity = htmlspecialchars(strip_tags($request->input('product_purity')));
        $no_of_product = htmlspecialchars(strip_tags($request->input('no_of_product')));
        $product_lot = htmlspecialchars(strip_tags($request->input('product_lot')));
         $cg1_m1 = htmlspecialchars(strip_tags($request->input('cg1_m1')));
        $cg1_m2 = htmlspecialchars(strip_tags($request->input('cg1_m2')));
        $cg2_m1 = htmlspecialchars(strip_tags($request->input('cg2_m1')));
        $cg2_m2 = htmlspecialchars(strip_tags($request->input('cg2_m2')));
        try {
            DB::beginTransaction();


            $job = Job::find($id);
            
            $job->job_no = $job_number;
            $job->purity = $product_purity;
            $job->no_of_products = $no_of_product;
            $job->lot_size = $product_lot;
             $job->cg1_m1 = $cg1_m1;
            $job->cg1_m2 = $cg1_m2;
             $job->cg2_m1 = $cg2_m1;
            $job->cg2_m2 = $cg2_m2;

            
            $job->updated_by = auth()->user()->email;
            if ($job->save()) {
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
