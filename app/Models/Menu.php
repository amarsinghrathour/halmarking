<?php

namespace App\Models;
use Auth;
use App\Models\Admin\MenuDetail;
use App\Models\Admin\MenuMapping;
use Illuminate\Support\Facades\Log;
class Menu 
{
    /*
     * Get Left Menu
     */
    public static function getLeftMenu($parentId)
    {
        $ids = MenuMapping::where('role_id',Auth::user()->role_id)->where('status','ACTIVE')->pluck('menu_id');
        return MenuDetail::whereIn('id',$ids)->where('status','ACTIVE')->where('parent_id',$parentId)->orderBy('menu_order')->get();
    }
    /*
     * Get Top Menu
     */
    public static function getTopMenu($parentId)
    {
        
        $ids = MenuMapping::where('role_id',Auth::user()->role_id)->where('status','ACTIVE')->pluck('menu_id');
        return MenuDetail::whereIn('id',$ids)->where('status','ACTIVE')->where('parent_id',$parentId)->where('is_top', 'Y')->orderBy('menu_order')->get();
    }
    /*
     * Check Current Url 
     */
    public static function checkForCurrentUrl($dbUrl)
    {
        if ($dbUrl === self::getCurrentUrl()) 
        {
            return true;
        }
        return false;
    }
    /*
     * Get Current Url From Host
     */
    private static function getCurrentUrl()
    {
        $httpHost = $_SERVER["HTTP_HOST"];
        $exp = explode("/", $httpHost.$_SERVER['REQUEST_URI']);
        if($httpHost === "localhost" or strpos($httpHost, "192.168") !== false)
        {
            if(isset($exp[2]))
            {
                return '/'.$exp[2];
            }
            else{
                return '#';
            }
        }else{
            if(isset($exp[1]))
            {
                return '/'.$exp[1];
            }
            else{
                return '#';
            }
        }
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
        if(isset($split_filename[2]))
        {
            $active_action = $split_filename[2];
        }
        else if(isset($split_filename[1]))
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
