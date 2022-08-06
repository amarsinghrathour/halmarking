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
use App\Models\Admin\Admin;
use Hash;
use Illuminate\Support\Arr;
class AdminService {
    //put your code here
     public static function save($request) {

         $name = $request->input('name');
        $role_id = $request->input('role');
        try{
            DB::beginTransaction();
            $roleName = Role::find($role_id)->name;
            $password = $request->input('password');
            $newuser = new Admin;
            $newuser->name = $name;
            if(!empty($request->input('mobile'))){
                $newuser->mobile = $request->input('mobile');
            }
            $newuser->email = $request->input('email');
            $newuser->password = Hash::make($password);
             $newuser->role_id = $role_id; 
             $newuser->created_by = auth()->user()->email; 
               

            if($newuser->save())
            {
                $newuser->assignRole($roleName);
                Log::debug(__CLASS__."::".__FUNCTION__." User details saved successfully for User :: $name and Password : $password");
                    session()->put("success",__('User details saved successfully for User :: :name and Password :: :password',['name'=>$name,'password'=>$password]));
                    DB::commit();
                    return true;
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." User details saving failed for User :: $name");
                session()->put("error",__(':data details saving failed for :column :: :name',['data'=>'User','column'=>'User','name'=>$name]));
                return false;

            }
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__." Exception :: ".$e->getMessage());
            session()->put("error","__('Exception While Data Storing :data for :column :: :name Please try again',['data'=>'in User table','column'=>'User','name'=>$name])");
           
            return false;
        }
        



        return false;
    }

    public static function update($request) {

        $id = $request->input('id');
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $role_id = $request->input('role');
        try {
            DB::beginTransaction();
          $roleName = Role::find($role_id)->name;
            $newuser = Admin::find($id);
            $newuser->name = $name;
            if(!empty($request->input('mobile'))){
                $newuser->mobile = $request->input('mobile');
            }
            $newuser->email = $request->input('email');
             $newuser->role_id = $role_id; 
             $newuser->updated_by = auth()->user()->email; 
    
        
            if ($newuser->save()) {
                 DB::table('model_has_roles')->where('model_id',$id)->delete();
    
              $newuser->assignRole($roleName);
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
