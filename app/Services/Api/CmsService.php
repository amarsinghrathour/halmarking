<?php

namespace App\Services\Api;

use App\Http\Controllers\App\AlertController;
use App\Http\Controllers\App\AppSettingController;
use Auth;
use DB;
use File;
use Log;
use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\HttpStatus;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Customer;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Models\SlotDate;
use App\Models\SlotTime;
use App\Models\Appointment;
use App\Models\AppointmentHistory;
use App\Models\WebAlbum;
use App\Models\WebAlbumImage;
use App\Models\WebSlider;
use App\Models\RecentActivity;
use App\Models\UpcomingEvent;
use App\Models\Service;
use App\Models\WebPage;
use App\Models\WebPost;
class CmsService extends Model
{
    //get slots with date
    public static function getGallery($request)
    {
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        
         

        if (isset(auth()->user()->id)) {
            

            Log::debug(__CLASS__."::".__FUNCTION__."called  with customer id ".auth()->user()->id);
        }
             try{
                $slots = WebAlbum::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->get();
                if(count($slots) > 0){
                        return returnResponse("Gallery Returned", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS,$slots);
                    
                }  else {
                        Log::warning(__CLASS__."::".__FUNCTION__."No data... ");
                        return returnResponse("Data not available !",HttpStatus::HTTP_NOT_FOUND, HttpStatus::HTTP_WARNING);
                    }
                
             } catch(\Exception $e){
                Log::error("Exception Occured :: ".$e->getMessage());
                return returnResponse("Some Error Occured please try again !");
            }
            
            Log::error(__CLASS__."::".__FUNCTION__."Error Occured ");
            return returnResponse("Some Error Occured please try again !");
    }
    //get slots with date
    public static function getGalleryImages($request)
    {
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
       $validator = Validator::make($request->all(), [
            'gallery_url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
         $slug = $request->input('gallery_url');

        if (isset(auth()->user()->id)) {
            

            Log::debug(__CLASS__."::".__FUNCTION__."called  with customer id ".auth()->user()->id);
        } 
             try{
                  $album = WebAlbum::where('url', $slug)->first();
        if (!isset($album->id)) {
             Log::warning("No Data Found... ");
                        return returnResponse("Data not available !",HttpStatus::HTTP_NOT_FOUND, HttpStatus::HTTP_WARNING);
                    
        }else{
          $albumsImageArray = WebAlbumImage::where('album_id', $album->id)->where('status', '!=', 'DELETED')->orderBy('sort_order')->orderBy('id', 'desc')->get();

                if(count($albumsImageArray) > 0){
                        return returnResponse("Gallery Images Returned", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS,$albumsImageArray);
                    
                }  else {
                        Log::warning("No Data Found... ");
                        return returnResponse("Data not available !",HttpStatus::HTTP_NOT_FOUND, HttpStatus::HTTP_WARNING);
                    }  
        }
        
                
             } catch(\Exception $e){
                Log::error("Exception Occured :: ".$e->getMessage());
                return returnResponse("Some Error Occured please try again !");
            }
            
            Log::error("Error Occured at get Gallery Images ");
            return returnResponse("Some Error Occured please try again !");
    }
    
    public static function bookAppointment($request)
    {
        Log::debug(__CLASS__." :: ".__FUNCTION__." started.. Validating parameters");
        $validator = Validator::make($request->all(), [
            'appointment_date' => 'required|date',
            'slot_time_id' => 'required',
            'instruments_required' => 'required',
            'instruments' => 'nullable',
            'vocal_required' => 'required',
            'vocals' => 'nullable',
            'track_url' => 'nullable',
            'dubbing_required' => 'required',
            'dubbings' => 'nullable',
        ]);
        Log::debug(__CLASS__." :: ".__FUNCTION__." parameter validated, lets validate the response ");
        if($validator->fails()){
            Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error, returning the response ");
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
        Log::debug(__CLASS__." :: ".__FUNCTION__." proceeding further");
        
        $appointment_date = htmlspecialchars(strip_tags($request->appointment_date));
        $slot_time_id = htmlspecialchars(strip_tags($request->slot_time_id));
        
        $SlotDateData = SlotDate::where('slot_date',$appointment_date)->first();
        if(empty($SlotDateData->id)){
           Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error, Appointment Date is not valid returning the response ");
            return returnResponse("Appointment Date is not valid", HttpStatus::HTTP_UNPROCESSABLE_ENTITY); 
        }
        $SlotTimeData = SlotTime::find($slot_time_id);
        if(empty($SlotTimeData->id)){
           Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error, Appointment Time Slot is not valid returning the response ");
            return returnResponse("Appointment Time Slot is not valid", HttpStatus::HTTP_UNPROCESSABLE_ENTITY); 
        }
        if($SlotTimeData->status !="ACTIVE"){
           Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error, Appointment Time Slot is not Availabe returning the response ");
            return returnResponse("Appointment Time Slot is not Availabe", HttpStatus::HTTP_UNPROCESSABLE_ENTITY); 
        }
        $appointment_start_time = $SlotTimeData->start_time;
        $appointment_end_time = $SlotTimeData->end_time;
        
        $instruments_required = htmlspecialchars(strip_tags($request->instruments_required));
        $instruments = $request->input('instruments');
        if($instruments_required =="YES" && empty($instruments)){
           Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error,Please select at least one required instrument returning the response ");
            return returnResponse("Please select at least one required instrument", HttpStatus::HTTP_UNPROCESSABLE_ENTITY); 
        }
        $vocal_required = $request->input('vocal_required');
        $vocals = $request->input('vocals');
        if($vocal_required =="YES" && empty($vocals)){
           Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error,Please select at least one required vocals returning the response ");
            return returnResponse("Please select at least one required vocals", HttpStatus::HTTP_UNPROCESSABLE_ENTITY); 
        }
        $track_url = $request->input('track_url');
        $dubbing_required = $request->input('dubbing_required');
        $dubbings = $request->input('dubbings');
        if($dubbing_required =="YES" && empty($dubbings)){
           Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error,Please select at least one required dubbings returning the response ");
            return returnResponse("Please select at least one required dubbings", HttpStatus::HTTP_UNPROCESSABLE_ENTITY); 
        }
        $credits_used = 0;
        $status = 'BOOKED';
        $slot_status = 'USED';
        
        if(auth()->user()->id) {
            Log::debug(__CLASS__." :: ".__FUNCTION__." fetching user data from database !!");
            $user = Customer::where('id', auth()->user()->id)->first();
            Log::debug(__CLASS__." :: ".__FUNCTION__." user data found validating!!");
            if($user->id != auth()->user()->id){
                Log::error(__CLASS__." :: ".__FUNCTION__." user data fetching failed !!");
                return returnResponse("User data fetching failed !");
            }
            Log::debug(__CLASS__." :: ".__FUNCTION__." starting try catch");

            try{
                Log::debug(__CLASS__." :: ".__FUNCTION__." inside try catch !!");
                DB::beginTransaction();
                $appointment = new Appointment;
                $appointment->customer_id = $user->id;
                $appointment->appointment_date = $appointment_date;
                $appointment->slot_time_id = $slot_time_id;
                $appointment->appointment_start_time = $appointment_start_time;
                $appointment->appointment_end_time = $appointment_end_time;
                $appointment->instruments_required = $instruments_required;
                if(!empty($instruments)){
                    $appointment->instruments = implode(",",$instruments);
                }
                $appointment->vocal_required = $vocal_required;
                if(!empty($vocals)){
                    $appointment->vocals = implode(",",$vocals);
                }
                if(!empty($track_url)){
                    $appointment->track_url = $track_url;
                }
                $appointment->dubbing_required = $dubbing_required;
                if(!empty($dubbings)){
                    $appointment->dubbings = implode(",",$dubbings);
                }
                $appointment->credits_used = $credits_used;
                $appointment->status = $status;
                $appointment->created_by = $user->email;
                if($appointment->save()){
                    $SlotTimeData->status =$slot_status;
                    
                    if($SlotTimeData->save() && self::insertAppointmentHistory($appointment->id, $status, "Appointment Booked")){
                       Log::info(__CLASS__." :: ".__FUNCTION__." all set, committing data now");
                        DB::commit();
                        return returnResponse("Appointment Scheduled Successfully !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS);

                    }else{
                         Log::error(__CLASS__."::".__FUNCTION__."Error Occured at slot status save ... ");
                            return returnResponse("Some Error Occured please try again !");
                    }
                }else{
                     Log::error(__CLASS__."::".__FUNCTION__."Error Occured at appointment save ... ");
                        return returnResponse("Some Error Occured please try again !");
                }
                      
            }catch(\Exception $e){
                Log::error(__CLASS__."::".__FUNCTION__."Error Occured".$e->getMessage());
                return returnResponse("Some Error Occured please try again !");
            }
            Log::debug(__CLASS__."::".__FUNCTION__."Error Occured ... ");
            return returnResponse("Some Error Occured please try again !");
        }

        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    
    //make withdrawal request
    public static function makeKycRequest($request)
    {
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        
         

        if (auth()->user()->id) {
            
            if(auth()->user()->kyc =='APPROVED'){
                return returnResponse("Kyc is already approved !"); 
            }
            
            $kycInfo = self::getKycInfo();
            if(!isset($kycInfo->id)){
                $validator = Validator::make($request->all(), [
                    'adhar_no' => 'required|unique:customers_kyc,adhar_no',
                    'adhar_front_file' => 'required|file',
                    'adhar_back_file' => 'required|file',
                ]);
                Log::debug(__CLASS__."::".__FUNCTION__."called with customer id ".auth()->user()->id);
                if($validator->fails()){
                    return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
                }
            }

            

            Log::debug(__CLASS__."::".__FUNCTION__."called 2 with customer id ".auth()->user()->id);
            $adhar_card_no = $request->adhar_no;
            $adhar_front = $request->file('adhar_front_file');
            $adhar_back = $request->file('adhar_back_file');
            
             try{
                DB::beginTransaction();
                if(!isset($kycInfo->id)){
                    $adhar_front_path = uploadImage($adhar_front, 'document/kyc', 'ADHARF');
                    if(!$adhar_front_path){
                        return returnResponse("Adhar Card Front file uploading failed !"); 
                    }
                } else if($adhar_front != null){
                    $adhar_front_path = uploadImage($adhar_front, 'document/kyc', 'ADHARF');
                    if(!$adhar_front_path){
                        return returnResponse("Adhar Card Front file uploading failed !"); 
                    }
                }
                
                if(!isset($kycInfo->id)){
                    $adhar_back_path = uploadImage($adhar_back, 'document/kyc', 'ADHARB');
                    if(!$adhar_back_path){
                        return returnResponse("Adhar Card Back file uploading failed !"); 
                    }
                } else if($adhar_back != null) {
                    $adhar_back_path = uploadImage($adhar_back, 'document/kyc', 'ADHARB');
                    if(!$adhar_back_path){
                        return returnResponse("Adhar Card Back file uploading failed !"); 
                    }
                }
               
                
                if(!isset($kycInfo->id)){
                    $kyc_req_id = DB::table('customers_kyc')->insertGetId([
                        'user_id'		            => auth()->user()->id,
                        'adhar_no'                      =>	$adhar_card_no,
                        'adhar_front_file'              =>	$adhar_front_path,
                        'adhar_back_file'               =>	$adhar_back_path,
                        'created_at'                    =>	Carbon::now(),
                    ]);
                } else {
                    $data = array();
                    $data["adhar_no"] = $adhar_card_no;
                    $data["status"] = "PENDING";
                    $data["reason"] = "";
                    
                    if(isset($adhar_front_path)){
                        $data["adhar_front_file"] = $adhar_front_path;
                    }
                    if(isset($adhar_back_path)){
                        $data["adhar_back_file"] = $adhar_back_path;
                    }
                    $kyc_req_id = DB::table('customers_kyc')->where('user_id', auth()->user()->id)->update($data);
                }
                
                if(!empty($kyc_req_id) && $kyc_req_id > 0){
                    $updated = Customer::where('id', auth()->user()->id)->update(['kyc' => "PENDING"]);
                    if ($updated) {
                        DB::commit();
                        return returnResponse("Kyc uploaded successfully and is PENDING for verification !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS);
                    }  else {
                        Log::error("Error Occured at kyc upload... ");
                        return returnResponse("Some Error Occured please try again !");
                    }
                }
                
                
             } catch(\Exception $e){
                Log::error("Exception Occured :: ".$e->getMessage());
                return returnResponse("Some Error Occured please try again !");
            }
            
            Log::error("Error Occured at kyc upload ");
            return returnResponse("Some Error Occured please try again !");
        } 
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    
    //Upload Avatar
    public static function uploadAvatar($request)
    {
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
         
        if (auth()->user()->id) {
            
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|file',
            ]);
            Log::debug(__CLASS__."::".__FUNCTION__."called with customer id ".auth()->user()->id);
            if($validator->fails()){
                return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
            }
            

            Log::debug(__CLASS__."::".__FUNCTION__."called with customer id ".auth()->user()->id);
            $avatar = $request->file('avatar');
            
             try{
                $avatar_path = uploadImage($avatar, 'document/avatar', 'A');
                if(!$avatar_path){
                    return returnResponse("Profile image uploading failed !");
                }
                if(!empty($avatar_path)){
                    $updated = Customer::where('id', auth()->user()->id)->update(['avatar' => $avatar_path]);
                    if ($updated) {
                        return returnResponse("Profile uploaded successfully !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS);
                    }  else {
                        Log::error("Error Occured at profile upload... ");
                        return returnResponse("Some Error Occured please try again !");
                    }
                }
             } catch(\Exception $e){
                Log::error("Exception Occured :: ".$e->getMessage());
                return returnResponse("Some Error Occured please try again !");
            }
            
            Log::error("Error Occured at Profile upload ");
            return returnResponse("Some Error Occured please try again !");
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    public static function makeWithdrawRequest($request)
    {
        Log::debug(__CLASS__." :: ".__FUNCTION__." started.. Validating parameters");
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'nullable',
        ]);
        Log::debug(__CLASS__." :: ".__FUNCTION__." parameter validated, lets validate the response ");
        if($validator->fails()){
            Log::debug(__CLASS__." :: ".__FUNCTION__." validator failed with error, returning the response ");
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
        Log::debug(__CLASS__." :: ".__FUNCTION__." proceeding further");
        $amount = $request->amount;
        // check the amount shoud not be less than 0
        Log::debug(__CLASS__." :: ".__FUNCTION__." lets check if withdrawal amount (Rs. $amount) is less than 0");
        if($amount < 0){
            Log::error(__CLASS__." :: ".__FUNCTION__." withdrawal amount found as $amount");
            Log::info(__CLASS__." :: ".__FUNCTION__." can not process the withdrawal request with amount $amount");
            return returnResponse("Can not process withdrawal with amount Rs. $amount !");
        }
        $description = $request->description;
        Log::debug(__CLASS__."::".__FUNCTION__."called with customer id ".auth()->user()->id." and amount $amount");
        

        Log::debug(__CLASS__." :: ".__FUNCTION__." fetching customer data !!");
        $consumer_data = getallheaders();
        /*
        $consumer_data['consumer_key'] = $request->header('consumer_key');
        $consumer_data['consumer_secret'] = $request->header('consumer_secret');
        $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
        $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
        */
        $consumer_data['consumer_ip'] = $request->ip();
        // $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        Log::debug(__CLASS__." :: ".__FUNCTION__." fetching settings !!");
        $settings = $authController->getSetting();
        Log::debug(__CLASS__." :: ".__FUNCTION__." settings found, validating !!");
        if($settings['withdraw_request_service'] != 'Y'){
            Log::debug(__CLASS__." :: ".__FUNCTION__." wihdraw service is closed, returning !!");
            return returnResponse("Withdrawal service is temporarily closed !"); 
        }
        Log::debug(__CLASS__." :: ".__FUNCTION__." validating for min amount allowed for withdrawal !!");
        if($settings['withdraw_request_min_amt'] > $amount){
            Log::error(__CLASS__." :: ".__FUNCTION__." min amount allowed for withdrawal is Rs. ".$settings['withdraw_request_min_amt']." and requested amount is $amount");
            Log::error(__CLASS__." :: ".__FUNCTION__." returning response !!");
            return returnResponse("Minimum withdraw amount permitted is Rs. ".$settings['withdraw_request_min_amt']." !"); 
        }
        Log::debug(__CLASS__." :: ".__FUNCTION__." validating for max amount allowed for withdrawal !!");
        if($settings['withdraw_request_max_amt'] < $amount){
            Log::error(__CLASS__." :: ".__FUNCTION__." Max amount allowed for withdrawal is Rs. ".$settings['withdraw_request_max_amt']." and requested amount is $amount");
            Log::error(__CLASS__." :: ".__FUNCTION__." returning response !!");
            return returnResponse("Maximum withdraw amount permitted is Rs. ".$settings['withdraw_request_max_amt']." !"); 
        }
        Log::debug(__CLASS__." :: ".__FUNCTION__." authenticating user now !!");
        if($authenticate == 1 && auth()->user()->id) {
            Log::debug(__CLASS__." :: ".__FUNCTION__." fetching user data from database !!");
            $user = Customer::where('id', auth()->user()->id)->first();
            Log::debug(__CLASS__." :: ".__FUNCTION__." user data found validating!!");
            if($user->id != auth()->user()->id){
                Log::error(__CLASS__." :: ".__FUNCTION__." user data fetching failed !!");
                return returnResponse("User data fetching failed !");
            }
            Log::debug(__CLASS__." :: ".__FUNCTION__." starting try catch");

            try{
                Log::debug(__CLASS__." :: ".__FUNCTION__." inside try catch !!");
                Log::debug(__CLASS__." :: ".__FUNCTION__." fetching main wallet balance and blocked amount !!");
                $m_wallet_balance = $user->m_wallet;
                $m_wallet_block = $user->m_wallet_block;
                Log::debug("m wallet balance $m_wallet_balance");
                Log::debug("m wallet block $m_wallet_block");
                $withdrawable_balance = $m_wallet_balance - $m_wallet_block;
                Log::debug("withdrawable balance is $withdrawable_balance");
                if($withdrawable_balance < $amount){
                    Log::debug("Insufficient Withdrawable Balance Rs. $withdrawable_balance !");
                    return returnResponse("Insufficient Withdrawable Balance Rs. $withdrawable_balance !");
                }
                Log::debug("proceeding for withdrawal as withdrawable_balance is $withdrawable_balance and amount is $amount");
                $balance_after = $user->m_wallet - $amount;
                Log::debug("balance after us updated as $balance_after");
                Log::debug("starting DB transaction");
                DB::beginTransaction();
                Log::debug("Making entry in withdraw table");
                $withdraw_req_id = DB::table('withdrawal_request')->insertGetId([
                                'customer_id'		            =>	$user->id,
                                'amount'		      =>	$amount,
                                'description'			        =>	$description,
                              ]);
                Log::debug(__CLASS__." :: ".__FUNCTION__." withdraw request saved with id $withdraw_req_id");
                
                if(empty($withdraw_req_id)){
                        Log::error("Withdraw request saving failed ");
                        return returnResponse("Withdraw Request saving failed !!");
                }
                Log::debug(__CLASS__." :: ".__FUNCTION__." lets debit in main wallet");
                if(!WalletModel::debitFromMainWallet($user->id, $amount, $balance_after, "Withdraw Request".$description, $withdraw_req_id, 'WITHDRAWAL')){
                    Log::error("Error Occured at wallet update ");
                    return returnResponse("Some Error Occured please try again !"); 
                }
                
                Log::info(__CLASS__." :: ".__FUNCTION__." all set, committing data now");
                DB::commit();
                return returnResponse("Withdrawal Request Made Successfully !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS);
                        
            }catch(\Exception $e){
                Log::error("Error Occured".$e->getMessage());
                return returnResponse("Some Error Occured please try again !");
            }
        }

        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    
    
    public static function getKycInfo(){
        return DB::table('customers_kyc')
        ->where('user_id', '=', auth()->user()->id)->where('status', '!=', 'DELETED')->first();
    }

    public static function checkIfsc($request)
    {
        $ifscCode = $request->ifsc_code;
        Log::debug("IFSC Code : ".$ifscCode);
        $url = "https://ifsc.razorpay.com/".$ifscCode;
        Log::debug("Calling URL : ".$url);
        $data = callUrl($url);
        Log::debug("Data : ".$data);
        return $data;
    }
    
    public static function insertAppointmentHistory($appoint_id,$status,$description=null){
        try{
            $history = new AppointmentHistory;
            $history->appointment_id = $appoint_id;
            $history->description = $description;
            $history->status = $status;
            $history->created_by = auth()->user()->email;
            if($history->save()){
                Log::debug(__CLASS__."::".__FUNCTION__." Inserted Appointment History for appointment $appoint_id ");
                return true;
            }
            
        } catch (\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__." Error Ocurred ".$e->getTraceAsString());
            return false;
        }
         return false;
    }

}
