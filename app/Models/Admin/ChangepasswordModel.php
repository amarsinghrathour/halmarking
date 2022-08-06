<?php
namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangepasswordModel {
    /*
     * Save School Details
     */
    public static function changePassword($id)
    {
        try {
            Log::debug(__CLASS__."::".__FUNCTION__." Started with  ID :: $id");
            $password = self::generatePasword();
            if(DB::table('users')->where('id', $id)->update(['password' => Hash::make($password), 'updated_at' => now(), 'updated_by' => Auth::user()->email]))
            {
                Log::debug(__CLASS__."::".__FUNCTION__." Password Updated Successfully. New Password Genereated As :: $password");
                session()->put("success","Password Updated Successfully. New Password Genereated As :: $password");
                return true;
            }
            else
            {
                Log::error(__CLASS__."::".__FUNCTION__." Password Updating Failed For ID :: $id.");
                session()->put("error","Password Updating Failed.");
                return false;
            }
        } catch (\PDOException $ex) {
            Log::error(__CLASS__."::".__FUNCTION__." Exception :: ".$ex->getMessage());
            session()->put("error","Exception While Updating Password. Please try again");
            return false;
        }
        Log::error(__CLASS__."::".__FUNCTION__." Error While Updating Password");
        session()->put("error","Error While Updating Password. Please try again");
        return false;
    }
    /*
     * Generate Password
     */
    private static function generatePasword($length = 10) 
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
