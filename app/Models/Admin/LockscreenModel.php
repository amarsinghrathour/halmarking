<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;
use Auth;
use Hash;

/**
 * Description of LockscreenModel
 *
 * @author maury
 */
class LockscreenModel {
    /*
     * Do Screen Locked
     */
    public static function doScreenLocked()
    {
        session()->put("screenLocked","YES");
        session()->put("success","Screen Locked.");
        return true;
    }
    /*
     * Do Screen Un-Locked
     */
    public static function doScreenUnLocked($password)
    {
        if(Hash::check($password,auth()->user()->password)){
            session()->put("success","Screen Un-Locked Successfully.");
            session()->forget('screenLocked');
            return true;
        }else{
            session()->put("error","Incorrect Password. Please Try Again.");
            return false;
        }
    }
}
