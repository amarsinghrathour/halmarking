<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

/**
 * Description of MenuController
 *
 * @author singh
 */
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class MenuController extends Controller 
{
   public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public static function getAllMenu()
    {
        $role_id = Auth::user()->role_id;
        return DB::select("select * from menu_detail where id in (select menu_id from menu_mapping where role_id = '$role_id' and status = 'ACTIVE') and status = 'ACTIVE' and parent_id = 0 order by menu_order");
    }
    
    public static function getMenuByParentId($parentId)
    {
        $role_id = Auth::user()->role_id;
        return DB::select("select * from menu_detail where id in (select menu_id from menu_mapping where role_id = '$role_id' and status = 'ACTIVE') and status = 'ACTIVE' and parent_id = '$parentId' order by menu_order");
    }
    /*
     * Check For Active Controller
     */
    public static function checkForActiveController($filename, $navigation_controller)
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[1];
        if ($active_controller == $navigation_controller) 
        {
            
            return true;
        }
        return false;
    }

    /*
     * Check For Active Action
     */
    public static function checkForActiveAction($filename, $navigation_action)
    {
        $split_filename = explode("/", $filename);
        if(isset($split_filename[1]))
        {
            $active_action = $split_filename[1];
        }
        else
        {
            $active_action = "";
        }
        if ($active_action == $navigation_action) 
        {
            return true;
        }
        return false;
    }
    
}
