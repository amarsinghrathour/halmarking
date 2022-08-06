<?php
namespace App\Services;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeopleService
 *
 * @author singh
 */

use Illuminate\Support\Facades\Log;
use App\Pepole;
use App\UserBioDetail;

class PeopleService {
    
    public static function updateProfile($request) {
        $userDetails = auth()->user();
        $imageDb = '';
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $bio = htmlspecialchars(strip_tags($request->input('bio')));
        try{
            
            if($request->hasFile('profile_pic')){
                $imageDb = uploadImage($request->file('profile_pic'), 'pepole/'.$userDetails->id);
            }
            
            $user = Pepole::find($userDetails->id);
            $user->name = $name;
            if(!empty($imageDb)){
                $user->profile_pic = $imageDb;
            }
            $user->created_by = $userDetails->email;
            $user->updated_by = $userDetails->email;
            
            if($user->save()){
                if(self::bioDescription($bio,$userDetails->id)){
                  session()->put('success','Data Saved Successfully.');  
                }
             
            }else{
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error','Error Occured While Data Storing For User Please try again !');
            return false;
            }
            
        }catch(\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__."Exception occured :: ".$e->getMessage());
            if(!empty($imageDb)){
                unlink(public_path().$imageDb);
            }
            session()->put('error','Exception While Data Storing For User Please try again !');
            return false;
        }
        return true;
        
    }
    
    
    protected static function bioDescription($bio,$userId) {
         Log::debug(__FUNCTION__."called with User Id $userId");
      $data = UserBioDetail::updateOrCreate(
            ['user_id' => $userId],
            ['user_brief_bio_desc'=>$bio,'created_by' => auth()->user()->email]
        );
      
      if($data){
          return true;
      }  
      return false;
    }
    
    
}
