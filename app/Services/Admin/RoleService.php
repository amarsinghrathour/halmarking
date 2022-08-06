<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of BoardService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService {
    //put your code here
     public static function save($request) {

        try {
            DB::beginTransaction();
            


            $role = Role::create(['name' => $request->input('name'),'guard_name'=>'admin']);
           $role->syncPermissions($request->input('permission'));
                session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
           
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
        $permission = $request->input('permission');
        
        try {
            DB::beginTransaction();
           $role = Role::find($id);
        $role->name = $name;
    
        
            if ($role->save()) {
                $role->syncPermissions($permission);
                session()->put('success', "Data Updated Successfully");
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
    
}
