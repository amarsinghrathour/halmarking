<?php

namespace App\Services\Api;

use Auth;
use DB;
use File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Log;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\HttpStatus;
use Validator;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Models\AppModels\CustomerLogin;
use App\Models\Core\SmsService;
use Illuminate\Support\Str;
use App\Models\Customer;
class CustomerService extends Model
{

    public static function processlogin($request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required|string|min:8',
        ]);
        
        if ($validator->fails()) {
            Log::error(__CLASS__."::".__FUNCTION__." Login failed ! Validation failed !");
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }

        
            $user_name = $request->user_name;
            $password = $request->password;
            $login_type = filter_var($request->input('user_name'), FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : 'user_name';

            $customerInfo = array($login_type => $user_name, "password" => $password);
             try {
            if ($token = JWTAuth::attempt($customerInfo)) {

                $existUser = Customer::
                    where($login_type, $user_name)->where('status', 'ACTIVE')->get();

                if (count($existUser) > 0) {

                    $customers_id = $existUser[0]->id;

                    

                    //check if already login or not
                    $already_login = DB::table('whos_onlines')->where('customer_id', '=', $customers_id)->get();

                    if (count($already_login) > 0) {
                        DB::table('whos_onlines')
                            ->where('customer_id', $customers_id)
                            ->update([
                                'name' => $existUser[0]->name,
                                'time_entry' => date('Y-m-d H:i:s'),
                                'ip_address' => $request->ip(),
                                'time_last_click' => date('Y-m-d H:i:s'),
                            ]);
                    } else {
                        DB::table('whos_onlines')
                            ->insert([
                                'name' => $existUser[0]->name,
                                'time_entry' => date('Y-m-d H:i:s'),
                                'customer_id' => $customers_id,
                                'session_id' => '',
                                'ip_address' => $request->ip(),
                                'time_last_click' => date('Y-m-d H:i:s'),
                                'last_page_url' => $request->fullUrl(),
                                
                            ]);
                    }




                    //$responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');
                     $now = Carbon::now();
                    $data = array(
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'expires_in' => JWTFactory::getTTL() * 60,
                        'last_login' => substr($now, 0, strlen($now)),
                        'user' => $existUser,
                        //'studentList' => StudentModel::getStudentList(auth()->user()->id),
                    );
       
                //Log::debug($data);
                return returnResponse("Login Success !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);

                } else {
                    //$responseData = array('success' => '0', 'data' => array(), 'message' => "Your account has been deactivated.");
                    return returnResponse("Your account has been deactivated.", HttpStatus::HTTP_UNAUTHORIZED);
                }
            } else {
                Log::error(__CLASS__."::".__FUNCTION__." Login attempt failed !");
                return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);

            }
        
        }
        catch (JWTException $exc) {
            Log::error(__CLASS__."::".__FUNCTION__." Exception : ".$exc->getMessage());
            return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
        }
         
            return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
        
       
    }

    public static function processregistration($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'mobile' => 'nullable',
            'email' => 'required|string|email|max:100|unique:customers',
            'user_name' => 'required|string|unique:customers',
            'password' => 'required|string|min:8',
            'referral_code' => 'nullable',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $customers_name = $request->name;
        $user_name = $request->user_name;
        $email = $request->email;
        $password = $request->password;
        $referral_code = $request->referral_code;
        $mobile = $request->mobile;
        

try{

    if ($email == $user_name) {
                //response if email already exit
                //$responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address is already exist");
                return returnResponse("User name and email can not be same !", HttpStatus::HTTP_BAD_REQUEST);
            }
            //check email existance
            $existUser = Customer::where('email', $email)->get();

            if (count($existUser) > 0) {
                //response if email already exit
                //$responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address is already exist");
                return returnResponse("User is already exist with this email !", HttpStatus::HTTP_BAD_REQUEST);
            } else {
                $parent_info = self::getParentCodeByReferralCode($referral_code);
                $parent_id = '';
                  if(!empty($referral_code)&&empty($parent_info->id)){
                     return returnResponse("Referral code is not valid", HttpStatus::HTTP_BAD_REQUEST); 
                  }
                  if(!empty($parent_info->id)){
                      $parent_id = $parent_info->id;
                  }
                  $member_code = self::generateReferralToken();
                  
                  if(!isset($member_code)){
                      Log::error(__CLASS__."::".__FUNCTION__." Error occured while generating member code");
                     return returnResponse("Some error occured", HttpStatus::HTTP_BAD_REQUEST); 
                  }
                $newCustomer = new Customer;
                $newCustomer->name = $customers_name;
                $newCustomer->mobile = $mobile;
                $newCustomer->email = $email;
                $newCustomer->password = Hash::make($password);
                $newCustomer->user_name = $user_name;
                $newCustomer->parent_id = $parent_id;
                $newCustomer->member_code = $member_code;
                if($newCustomer->save()){
                   
                return returnResponse("Sign Up successfully!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $newCustomer);
                
                
                }else{
                  Log::error(__CLASS__."::".__FUNCTION__." Error occured while saving member data");
                     return returnResponse("Some error occured", HttpStatus::HTTP_BAD_REQUEST);  
                }
                
                }
            

        }catch(\Exception $e){
            Log::error(__CLASS__."::".__FUNCTION__." Error ".$e->getTraceAsString());
                     return returnResponse("Some error occured", HttpStatus::HTTP_BAD_REQUEST);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    public static function notify_me($request)
    {
        $device_id = $request->device_id;
        $is_notify = $request->is_notify;
        $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $devices = DB::table('devices')->where('device_id', $device_id)->get();
            if (!empty($devices[0]->customers_id)) {
                $customers = Customer::where('id', $devices[0]->customers_id)->get();

                if (count($customers) > 0) {

                    foreach ($customers as $customers_data) {

                        DB::table('devices')->where('user_id', $customers_data->customers_id)->update([
                            'is_notify' => $is_notify,
                        ]);
                    }

                }
            } else {

                DB::table('devices')->where('device_id', $device_id)->update([
                    'is_notify' => $is_notify,
                ]);
            }

            $responseData = array('success' => '1', 'data' => '', 'message' => "Notification setting has been changed successfully!");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $categoryResponse = json_encode($responseData);

        return $categoryResponse;
    }

    public static function updatecustomerinfo($request)
    {
        $customers_id            			=   $request->customers_id;
        $customers_firstname            	=   $request->customers_firstname;
        $customers_lastname           		=   $request->customers_lastname;
        $customers_telemobile          		=   $request->customers_telemobile;
        $customers_gender          		   	=   $request->customers_gender;
        $customers_dob          		   		=   $request->customers_dob;
        $customers_info_date_account_last_modified 	=   date('y-m-d h:i:s');
        $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url']  	  =  __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if($authenticate==1){
        $cehckexist = Customer::where('id', $customers_id)->where('role_id', 2)->first();
            if($cehckexist){

                $customer_data = array(
                    'role_id' => 2,
                    'first_name'			 =>  $customers_firstname,
                    'last_name'			 =>  $customers_lastname,
                    'mobile'			 =>  $customers_telemobile,
                    'gender'				 =>  $customers_gender,
                    'dob'					 =>  $customers_dob,
                );


            //update into customer
            Customer::where('id', $customers_id)->update($customer_data);

            DB::table('customers_info')->where('customers_info_id', $customers_id)->update(['customers_info_date_account_last_modified'   =>   $customers_info_date_account_last_modified]);

            $userData = DB::table('users')
                ->select('users.*')->where('users.id', '=', $customers_id)->where('status', '1')->get();

            $responseData = array('success'=>'1', 'data'=>$userData, 'message'=>"Customer information has been Updated successfully");


            }else{
            $responseData = array('success'=>'3', 'data'=>array(),  'message'=>"Record not found.");
            }

        }else{
            $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }


    public static function updatepassword($request)
    {
    $customers_id            					=   $request->customers_id;
    $customers_info_date_account_last_modified 	=   date('y-m-d h:i:s');
    $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);


    if($authenticate==1){
        $cehckexist = Customer::where('id', $customers_id)->where('role_id', 2)->first();
            if($cehckexist){
                $oldpassword    = $request->oldpassword;
                $newPassword    = $request->newpassword;

                $content = Customer::where('id', $customers_id)->first();

                $customerInfo = array("email" => $cehckexist->email, "password" => $oldpassword);

                if (Auth::attempt($customerInfo)) {

                    Customer::where('id', $customers_id)->update([
                    'password'			 =>  Hash::make($newPassword)
                    ]);

                    //get user data
                    $userData = DB::table('users')
                        ->select('users.*')
                        ->where('users.id', '=', $customers_id)->where('status', '1')->get();
                    $responseData = array('success'=>'1', 'data'=>$userData, 'message'=>"Information has been Updated successfully");
                }else{
                    $responseData = array('success'=>'2', 'data'=>array(),  'message'=>"current password does not match.");
                }
        }else{
            $responseData = array('success'=>'3', 'data'=>array(),  'message'=>"Record not found.");
        }

        }else{
            $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
        }

        $userResponse = json_encode($responseData);
        return $userResponse;
    }

    public static function processforgotpassword($request)
    {

        $email = $request->email;
        $postData = array();

       $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            //check email exist
            $existUser = Customer::where('email', $email)->get();

            if (count($existUser) > 0) {
                $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);

                Customer::where('email', $email)->update([
                    'password' => Hash::make($password),
                ]);

                $existUser[0]->password = $password;

                $myVar = new AlertController();
                $alertSetting = $myVar->forgotPasswordAlert($existUser);
                $responseData = array('success' => '1', 'data' => $postData, 'message' => "Your password has been sent to your email address.");
            } else {
                $responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address doesn't exist!");
            }
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function facebookregistration($request)
    {
        require_once app_path('vendor/autoload.php');
        $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {
            //get function from other controller
            $myVar = new AppSettingController();
            $setting = $myVar->getSetting();

            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $access_token = $request->access_token;

            $fb = new \Facebook\Facebook([
                'app_id' => $setting['facebook_app_id'],
                'app_secret' => $setting['facebook_secret_id'],
                'default_graph_version' => 'v2.2',
            ]);

            try {
                $response = $fb->get('/me?fields=id,name,email,first_name,last_name,gender,public_key', $access_token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
            }

            $user = $response->getGraphUser();

            $fb_id = $user['id'];
            $customers_firstname = $user['first_name'];
            $customers_lastname = $user['last_name'];
            $name = $user['name'];
            if (empty($user['gender']) or $user['gender'] == 'male') {
                $customers_gender = '0';
            } else {
                $customers_gender = '1';
            }
            if (!empty($user['email'])) {
                $email = $user['email'];
            } else {
                $email = '';
            }

            //user information
            $fb_data = array(
                'fb_id' => $fb_id,
            );
            $customer_data = array(
                'role_id' => 2,
                'first_name' => $customers_firstname,
                'last_name' => $customers_lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            );

            $existUser = DB::table('customers')->where('fb_id', '=', $fb_id)->get();
            if (count($existUser) > 0) {

                $customers_id = $existUser[0]->customers_id;
                $success = "2";
                $message = "Customer record has been updated.";
                //update data of customer
                DB::table('customers')->where('user_id', '=', $customers_id)->update($fb_data);
            } else {
                $success = "1";
                $message = "Customer account has been created.";
                //insert data of customer
                $customers_id = Customer::insertGetId($customer_data);
                DB::table('customers')->insertGetId([
                    'fb_id' => $fb_id,
                    'user_id' => $customers_id,

                ]);

            }

            $userData = Customer::where('id', '=', $customers_id)->get();

            //update record of customers_info
            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
            $customers_info_id = $customers_id;
            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
            $customers_info_number_of_logons = '1';
            $customers_info_date_account_created = date('Y-m-d H:i:s');
            $global_product_notifications = '1';

            if (count($existUserInfo) > 0) {
                //update customers_info table
                DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                    'global_product_notifications' => $global_product_notifications,
                    'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                ]);

            } else {
                //insert customers_info table
                $customers_default_address_id = DB::table('customers_info')->insertGetId([
                    'customers_info_id' => $customers_info_id,
                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                    'customers_info_number_of_logons' => $customers_info_number_of_logons,
                    'customers_info_date_account_created' => $customers_info_date_account_created,
                    'global_product_notifications' => $global_product_notifications,
                ]);

            }

            //check if already login or not
            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();
            if (count($already_login) > 0) {
                DB::table('whos_online')
                    ->where('customer_id', $customers_id)
                    ->update([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                    ]);
            } else {
                DB::table('whos_online')
                    ->insert([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                        'customer_id' => $customers_id,
                    ]);
            }

            $responseData = array('success' => $success, 'data' => $userData, 'message' => $message);
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function googleregistration($request)
    {
        $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            //gmail user information
            $access_token = $request->idToken;
            $google_id = $request->userId;
            $customers_firstname = $request->givenName;
            $customers_lastname = $request->familyName;
            $email = $request->email;

            //user information
            $google_data = array(
                'google_id' => $google_id,
            );

            $customer_data = array(
                'role_id' => 2,
                'first_name' => $customers_firstname,
                'last_name' => $customers_lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            );

            $existUser = DB::table('customers')->where('google_id', '=', $google_id)->get();
            if (count($existUser) > 0) {
                $customers_id = $existUser[0]->customers_id;
                Customer::where('id', $customers_id)->update($customer_data);
            } else {
                //insert data into customer
                $customers_id = Customer::insertGetId($customer_data);
                DB::table('customers')->insertGetId([
                    'google_id' => $google_id,
                    'user_id' => $customers_id,
                ]);

            }

            $userData = Customer::where('id', '=', $customers_id)->get();

            //update record of customers_info
            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
            $customers_info_id = $customers_id;
            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
            $customers_info_number_of_logons = '1';
            $customers_info_date_account_created = date('Y-m-d H:i:s');
            $customers_info_date_account_last_modified = date('Y-m-d H:i:s');
            $global_product_notifications = '1';

            if (count($existUserInfo) > 0) {
                $success = '2';
            } else {
                //insert customers_info table
                $customers_default_address_id = DB::table('customers_info')->insertGetId(
                    [
                        'customers_info_id' => $customers_info_id,
                        'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                        'customers_info_number_of_logons' => $customers_info_number_of_logons,
                        'customers_info_date_account_created' => $customers_info_date_account_created,
                        'global_product_notifications' => $global_product_notifications,
                    ]
                );
                $success = '1';
            }

            //check if already login or not
            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

            if (count($already_login) > 0) {
                DB::table('whos_online')
                    ->where('customer_id', $customers_id)
                    ->update([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                    ]);
            } else {

                DB::table('whos_online')
                    ->insert([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                        'customer_id' => $customers_id,
                    ]);
            }

            //$userData = $request->all();
            $responseData = array('success' => $success, 'data' => $userData, 'message' => "Login successfully");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function registerdevices($request)
    {
       /* 
        $validator = Validator::make($request->all(), [
            'consumer_device_id' => 'required',
            'device_type' => 'required',
            'device_manufacturer' => 'required',
            'customers_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            Log::error(__CLASS__."::".__FUNCTION__." Validation failed !");
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
        */
        Log::error(__CLASS__."::".__FUNCTION__." Consumer data !".json_encode($request->all()));
        $consumer_data = array();
        
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer_device_id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
       

            $myVar = new AppSettingController();
            $setting = $myVar->getSetting();
            $myVar2 = new AddressController();
            $setting['countries'] = $myVar2->getAllCountries();

            $device_type = $request->device_type;
           $type = 3;
            if ($device_type == 'iOS') { /* imobile */
                $type = 1;
            } elseif ($device_type == 'Android') { /* android */
                $type = 2;
            } elseif ($device_type == 'Desktop') { /* other */
                $type = 3;
            }

            if (!empty($request->customers_id)) {

                $device_data = array(
                    'device_id' => $request->consumer_device_id,
                    'device_type' => $type,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'ram' => $request->device_ram,
                    'status' => '1',
                    'processor' => $request->device_processor,
                    'device_os' => $request->device_platform,
                    'location' => $request->device_location,
                    'device_model' => $request->device_model,
                    'customers_id' => $request->customers_id,
                    'manufacturer' => $request->device_manufacturer,
                    'device_app_version' => $request->device_app_version,
                    'device_os_version' => $request->device_os_version,
                    $setting['default_notification'] => '1',
                );

            } else {

                $device_data = array(
                    'device_id' => $request->consumer_device_id,
                    'device_type' => $type,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => '1',
                    'ram' => $request->device_ram,
                    'processor' => $request->device_processor,
                    'device_os' => $request->device_device_platform,
                    'location' => $request->device_location,
                    'device_model' => $request->device_model,
                    'manufacturer' => $request->device_manufacturer,
                    'device_app_version' => $request->device_app_version,
                    'device_os_version' => $request->device_os_version,
                    $setting['default_notification'] => '1',
                );

            }

            //check device exist
            $device_id = DB::table('devices')->where('device_id', '=', $request->consumer_device_id)->get();

            if (count($device_id) > 0) {

                $dataexist = DB::table('devices')->where('device_id', '=', $request->consumer_device_id)->where('user_id', '=', '0')->get();

                DB::table('devices')
                    ->where('device_id', $request->consumer_device_id)
                    ->update($device_data);

                if (count($dataexist) >= 0 && isset($request->customers_id)) {
                    $userData = Customer::where('id', '=', $request->customers_id)->get();
                    //notification
                    $myVar = new AlertController();
                    $alertSetting = $myVar->createUserAlert($userData);
                }
            } else {
                $device_id = DB::table('devices')->insertGetId($device_data);
            }

           // $responseData = array('success' => '1', 'data' => array(), 'message' => "Device is registered.");
        
       return returnResponse("Device is registered.", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $setting);
    }
    
    
    // send otp for Normal Signup
    public static function normalSignup($request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string|between:10,12',
            'name' => 'required|string|max:200',
            'password' => 'required|confirmed',
            'email' => 'nullable|email',
            'referral_code' => 'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        $currentDateTime = Carbon::now();
        $otpExpiry = Carbon::now()->addMinute(15);
        
        $mobile_no = $request->mobile_no;
        Log::debug(__CLASS__."::".__FUNCTION__."Called with mobile no $mobile_no");

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

          $otp_for = 'normal_signup';
        if ($authenticate == 1) {

            //check email existance
            $existUser = Customer::where('mobile', $mobile_no)->where('role_id', '2')->where('status', '1')->get();
            $otp = generateOtp($mobile_no);
            if (isset($existUser[0]->first_name) && count($existUser) > 0) {
                
                return returnResponse('User Already Exists !', HttpStatus::HTTP_BAD_REQUEST);
            } else {
                
                
                
                $otpHistory = new OtpHistory;
                $otpHistory->mobile_no = $mobile_no;
                $otpHistory->otp = $otp;
                $otpHistory->otp_for = $otp_for;
                $otpHistory->otp_expiry = $otpExpiry;
                if($otpHistory->save()){
                $message_text = "Dear User, OTP for Signup is ".$otp.". Please dont share this to anyone.
Team,
".config('app.send_sms_company_name');
                Log::debug("sms scheduled as $message_text");
                
                if(SmsService::scheduleNewSMS($mobile_no, $message_text, 'otp', '1')){
                Log::debug("Otp Sent $otp");
                return returnResponse("Otp Sent successfully!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, 'true');
                
                }
                
                }
                
                return returnResponse("Otp Seding Failed!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, 'false');
            }

        } 
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    
    
    //Send Otp for Prime Signup
     public static function primeSignup($request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string|between:10,12',
            'name' => 'required',
            'referral_code' => 'required',
            'email' => 'required|email',
            'dob' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            'password' => 'required|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        $currentDateTime = Carbon::now();
        $otpExpiry = Carbon::now()->addMinute(15);
        
        $mobile_no = $request->mobile_no;
    Log::debug(__CLASS__."::".__FUNCTION__." Called with mobile $mobile_no");
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

          $otp_for = 'prime_signup';
        if ($authenticate == 1) {

            //check mobile number existance
            //$existUser = Customer::where('mobile', $mobile_no)->where('role_id', '2')->where('status', '1')->get();
            $existUser = Customer::where('mobile', $mobile_no)->where('role_id', '2')->get();
            if (isset($existUser->first_name)) {
                
                if(isset($existUser->is_prime) && $existUser->is_prime == "Y"){
                    return returnResponse('User Already Exists !', HttpStatus::HTTP_BAD_REQUEST);
                }
            }
            $otp = generateOtp($mobile_no);
            $otpHistory = new OtpHistory;
                            $otpHistory->mobile_no = $mobile_no;
                            $otpHistory->otp = $otp;
                            $otpHistory->otp_for = $otp_for;
                            $otpHistory->otp_expiry = $otpExpiry;
                            if($otpHistory->save()){
                            $message_text = "Dear User, OTP for Signup is ".$otp.". Please dont share this to anyone.
Team,
".config('app.send_sms_company_name');
                            
                     Log::debug("Sms Schedule as $message_text");       
                if(SmsService::scheduleNewSMS($mobile_no, $message_text, 'otp', '1')){
                    Log::debug("Otp Sent $otp");
                    return returnResponse("Otp Sent successfully!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, 'true');
                
                }
            
            }
            
            return returnResponse("Otp Seding Failed!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, 'false');
        } 
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
 //prime signup verify
    
    public static function primeSignupVerify($request)
    {
        $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string|between:10,12',
            'otp' => 'required|numeric|min:4',
            'name' => 'required',
            'referral_code' => 'required',
            'email' => 'required|email',
            'dob' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            'password' => 'required|confirmed',
        ]);
        
        if ($validator->fails()) {
            Log::error(__CLASS__."::".__FUNCTION__." Login failed ! Validation failed !");
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        if ($authenticate == 1) {

            $mobile = $request->mobile_no;
            $name = $request->name;
            $otp = $request->otp;
            $email = $request->email;
            $referral_id = $request->referral_code;
            $dob = Carbon::parse($request->dob)->format('Y-m-d');
            $city = $request->city;
            $pin_code = $request->pin_code;
            $password = Hash::make($request->password);
            $country = 99;
            $country_code = 'IND';
            $referal_token = self::generateReferralToken();
            
            $existUser = DB::table('users')
                    ->where('mobile', $mobile)->where('status', '1')->get();
            //$password = Crypt::decrypt($existUser[0]->password);
            Log::debug(__CLASS__."::".__FUNCTION__."CAlled with mobile $mobile otp $otp email $email referral code $referral_id");
            
            $currentTime = Carbon::now();
             try {
            DB::beginTransaction();
            $otp_for = $request->otp_for;
            $existOtp = OtpHistory::where('mobile_no', $mobile)->where('otp', $otp)->where('status', 'ACTIVE')->first();
                    
            //$password = Crypt::decrypt($existUser[0]->password);
            
            $currentTime = Carbon::now();
             
        if(isset($existOtp->otp) && $otp == $existOtp->otp && $currentTime<= $existOtp->otp_expiry){
            OtpHistory::where('id',$existOtp->id)->update(['status'=>'USED']);
               if(isset($existUser[0]->is_prime) && $existUser[0]->is_prime == 'Y'){
                   return returnResponse('Already Prime Member Login to continue');
               }
                if(isset($existUser[0]->id) && $existUser[0]->is_prime =='N'){
                    $user = CustomerLogin::where('mobile', $mobile)->where('status', '1')->where('role_id', '2')->first();
                    if ($token = JWTAuth::fromUser($user)) {

                        if (count($existUser) > 0) {

                            $customers_id = $user->id;
                            $parent_id = self::getParentCodeByReferralCode($referral_id,5,1);
                            //update record of customers_info
                            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                            $customers_info_id = $customers_id;
                            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                            $customers_info_number_of_logons = '1';
                            $customers_info_date_account_created = date('Y-m-d H:i:s');
                            $global_product_notifications = '1';

                            if (count($existUserInfo) > 0) {
                                //update customers_info table
                                DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                    'global_product_notifications' => $global_product_notifications,
                                    'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                                ]);

                            } else {
                                //insert customers_info table
                                $customers_default_address_id = DB::table('customers_info')->insertGetId(
                                    ['customers_info_id' => $customers_info_id,
                                        'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                        'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                        'customers_info_date_account_created' => $customers_info_date_account_created,
                                        'global_product_notifications' => $global_product_notifications,
                                    ]
                                );


                            }

                            // data to address book

                            //check if record exist
                            $exist = DB::table('user_to_address')->where('user_id','=',$user->id)->first();

                            if(isset($exist->address_book_id)){
                              $address_book_id = $exist->address_book_id;
                              DB::table('address_book')->where('user_id','=', $user->id)->where('address_book_id','=', $address_book_id)->update([
                                'entry_firstname'	      =>	$name,
                                'entry_lastname'		      =>	'',
                                'entry_street_address'		=>	'',
                                'entry_city'			        =>	$city,
                                'entry_state'			      =>	'',
                                'entry_postcode'		     	=>	$pin_code,
                                'entry_country_id'		    =>	$country,
                              ]);

                            }else{
                             $address_book_id = DB::table('address_book')->insertGetId([
                                'is_user_address'          =>    'Y',
                                'user_id'		            =>	$user->id,
                                'entry_firstname'	      =>	$name,
                                'entry_lastname'		      =>	'',
                                'entry_street_address'		=>	'',
                                'entry_city'			        =>	$city,
                                'entry_state'			      =>	'',
                                'entry_postcode'		     	=>	$pin_code,
                                'entry_country_id'		    =>	$country,
                              ]);

                              if($address_book_id){
                                $user_to_address =  DB::table('user_to_address')->insertGetId([
                                   'user_id'		            =>	$user->id,
                                   'address_book_id'	      =>	$address_book_id,
                                   'is_default'    =>  1
                                 ]);
                              }
                            }

                            Customer::where('id', $customers_id)->update([
                                    'default_address_id' => $address_book_id,
                                    'mobile_verified' => '1',
                                    'mobile' => $mobile,
                                    'first_name' => $name,
                                    'dob' => $dob,
                                    'email' => $email,
                                    'parent_id' => $parent_id,
                                    'password' => $password,
                                   // 'member_code' => $referal_token,
                                    'country_code' => $country_code,
                                    'prime_referral' => $referral_id,
                                    'prime_time' => date('y-m-d h:i:s'),
                                    'is_prime' => 'Y',
                                ]);

                            //check if already login or not
                            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                            if (count($already_login) > 0) {
                                DB::table('whos_online')
                                    ->where('customer_id', $customers_id)
                                    ->update([
                                        'full_name' => $user->first_name . ' ' . $user->last_name,
                                        'time_entry' => date('Y-m-d H:i:s'),
                                    ]);
                            } else {
                                DB::table('whos_online')
                                    ->insert([
                                        'full_name' => $user->first_name . ' ' . $user->last_name,
                                        'time_entry' => date('Y-m-d H:i:s'),
                                        'customer_id' => $customers_id,
                                    ]);
                            }

                            Log::debug('CAlling Method for Distributing Level Income');
                            if(!self::levelIncomeDistribute(1, $referral_id, $parent_id,$customers_id)){
                                 Log::debug('Distributing Level Income failed');
                                 return returnResponse("Error While Processing !");
                            }

                           
                            $user_data = CustomerLogin::where('id', $user->id)->where('status', '1')->where('role_id', '2')->first();

                            if(isset($user_data->member_code)){
                                $user_level_income = DB::table('user_level_incomes')
                                ->where('member_code', '=', $user_data->member_code)
                                ->where('status', '=', "REGISTERED")
                                ->where('is_paid', '=', "N")
                                ->sum('amount');
                                $user_data->f_wallet = $user_level_income;
                            }


                            //$responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');
                             $now = Carbon::now();
                            $data = array(
                                'access_token' => $token,
                                'token_type' => 'Bearer',
                                'expires_in' => JWTFactory::getTTL() * 60,
                                'last_login' => substr($now, 0, strlen($now)),
                                'user' => $user_data,

                            );
                        DB::commit();
                        //Log::debug($data);
                        return returnResponse("Prime Registration done Successfully !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);

                        } else {
                            //$responseData = array('success' => '0', 'data' => array(), 'message' => "Your account has been deactivated.");
                            return returnResponse("Your account has been deactivated.", HttpStatus::HTTP_UNAUTHORIZED);
                        }
                    } else {
                        Log::error(__CLASS__."::".__FUNCTION__." Login attempt failed !");
                        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);

                    }
                }else{
                    
                    Log::debug('Getting Parent ID');
                 $parent_id = self::getParentCodeByReferralCode($referral_id,5,1);
                    if(!empty($email)){
                        $email = strtolower($email);
                    }
                    
                 $customer_id =   Customer::insertGetId([
                                    'mobile_verified' => '1',
                                    'first_name' => $name,
                                    'mobile' => $mobile,
                                    'dob' => $dob,
                                    'email' => $email,
                                    'password' => $password,
                                    'country_code' => $country_code,
                                    'member_code' => $referal_token,
                                    'prime_referral' => $referral_id,
                                    'role_id' => '2',
                                    'parent_id' => $parent_id,
                                    'prime_time' => date('y-m-d h:i:s'),
                                    'status' => '1',
                                    'is_prime' => 'Y',
                                    'created_at' => date('y-m-d h:i:s'),
                                ]);
                    
                    $user = CustomerLogin::where('id', $customer_id)->where('status', '1')->where('role_id', '2')->first();
                    if ($token = JWTAuth::fromUser($user)) {


                            $customers_id = $user->id;

                            //update record of customers_info
                            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                            $customers_info_id = $customers_id;
                            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                            $customers_info_number_of_logons = '1';
                            $customers_info_date_account_created = date('Y-m-d H:i:s');
                            $global_product_notifications = '1';

                            if (count($existUserInfo) > 0) {
                                //update customers_info table
                                DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                    'global_product_notifications' => $global_product_notifications,
                                    'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                                ]);

                            } else {
                                //insert customers_info table
                                $customers_default_address_id = DB::table('customers_info')->insertGetId(
                                    ['customers_info_id' => $customers_info_id,
                                        'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                        'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                        'customers_info_date_account_created' => $customers_info_date_account_created,
                                        'global_product_notifications' => $global_product_notifications,
                                    ]
                                );


                            }

                            // data to address book

                            //check if record exist
                            $exist = DB::table('user_to_address')->where('user_id','=',$user->id)->first();

                            if(isset($exist->address_book_id)){
                              $address_book_id = $exist->address_book_id;
                              DB::table('address_book')->where('user_id','=', $user->id)->where('address_book_id','=', $address_book_id)->update([
                                'entry_firstname'	      =>	$name,
                                'entry_lastname'		      =>	'',
                                'entry_street_address'		=>	'',
                                'entry_city'			        =>	$city,
                                'entry_state'			      =>	'',
                                'entry_postcode'		     	=>	$pin_code,
                                'entry_country_id'		    =>	$country,
                              ]);

                            }else{
                             $address_book_id = DB::table('address_book')->insertGetId([
                                'user_id'		            =>	$user->id,
                                'entry_firstname'	      =>	$name,
                                'entry_lastname'		      =>	'',
                                'entry_street_address'		=>	'',
                                'entry_city'			        =>	$city,
                                'entry_state'			      =>	'',
                                'entry_postcode'		     	=>	$pin_code,
                                'entry_country_id'		    =>	$country,
                              ]);

                              if($address_book_id){
                                $user_to_address =  DB::table('user_to_address')->insertGetId([
                                   'user_id'		            =>	$user->id,
                                   'address_book_id'	      =>	$address_book_id,
                                   'is_default'    =>  1
                                 ]);
                              }
                            }

                            Customer::where('id', $customers_id)->update([
                                    'default_address_id' => $address_book_id,
                                    
                                ]);

                            //check if already login or not
                            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                            if (count($already_login) > 0) {
                                DB::table('whos_online')
                                    ->where('customer_id', $customers_id)
                                    ->update([
                                        'full_name' => $user->first_name . ' ' . $user->last_name,
                                        'time_entry' => date('Y-m-d H:i:s'),
                                    ]);
                            } else {
                                DB::table('whos_online')
                                    ->insert([
                                        'full_name' => $user->first_name . ' ' . $user->last_name,
                                        'time_entry' => date('Y-m-d H:i:s'),
                                        'customer_id' => $customers_id,
                                    ]);
                            }




                           
                            $user_data = CustomerLogin::where('id', $user->id)->where('status', '1')->where('role_id', '2')->first();

                            Log::debug('CAlling Method for Distributing Level Income');
                            if(!self::levelIncomeDistribute(1, $referral_id, $parent_id,$user_data->id)){
                                 Log::debug('Distributing Level Income failed');
                                 return returnResponse("Error While Processing !");
                            }

                            if(isset($user_data->member_code)){
                                $user_level_income = DB::table('user_level_incomes')
                                ->where('member_code', '=', $user_data->member_code)
                                ->where('status', '=', "REGISTERED")
                                ->where('is_paid', '=', "N")
                                ->sum('amount');
                                $user_data->f_wallet = $user_level_income;
                            }
                            //$responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');
                             $now = Carbon::now();
                            $data = array(
                                'access_token' => $token,
                                'token_type' => 'Bearer',
                                'expires_in' => JWTFactory::getTTL() * 60,
                                'last_login' => substr($now, 0, strlen($now)),
                                'user' => $user_data,

                            );
                        DB::commit();
                        //Log::debug($data);
                        return returnResponse("Prime Registration done Successfully !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);

                         
                    } else {
                        Log::error(__CLASS__."::".__FUNCTION__." Login attempt failed !");
                        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);

                    }
                    
                }
             }
            return returnResponse('Invalid Otp', HttpStatus::HTTP_UNAUTHORIZED);
        
        }
        catch (JWTException $exc) {
            Log::error(__CLASS__."::".__FUNCTION__." Exception : ".$exc->getMessage());
            return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
        }
        } 
            return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
        
       
    }    
    
    public static function normalSignupVerify($request)
    {
        $consumer_data = getallheaders();
      /*
      $consumer_data['consumer_key'] = $request->header('consumer_key');
      $consumer_data['consumer_secret'] = $request->header('consumer_secret');
      $consumer_data['consumer_nonce'] = $request->header('consumer_nonce');
      $consumer_data['consumer_device_id'] = $request->header('consumer_device_id');
      */
      $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string|between:10,12',
            'name' => 'required|string|max:200',
            'otp' => 'required|numeric|min:4',
            'password' => 'required|confirmed',
            'email' => 'nullable|email',
            'referral_code' => 'nullable|string',
        ]);
        $customers_firstname = $request->name;
        $otp_for = 'normal_signup';
        $password = '';
        if ($validator->fails()) {
            Log::error(__CLASS__."::".__FUNCTION__." Login failed ! Validation failed !");
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        if ($authenticate == 1) {

            $mobile = $request->mobile_no;
            $email = $request->email;
            $otp = $request->otp;
            $otp_for = $request->otp_for;
            $existOtp = OtpHistory::where('mobile_no', $mobile)->where('otp', $otp)->where('status', 'ACTIVE')->first();
                    
            //$password = Crypt::decrypt($existUser[0]->password);
            
            $currentTime = Carbon::now();
             
        if(isset($existOtp->otp) && $otp == $existOtp->otp && $currentTime<= $existOtp->otp_expiry){
            OtpHistory::where('id',$existOtp->id)->update(['status'=>'USED']);
            DB::beginTransaction();
            $password = Hash::make($request->password);
                   
                   $referal_token = self::generateReferralToken();
                   $referral_id = '';
                   if($request->has('referral_code')){
                   $referral_id = $request->referral_code;
                   $existreferal = Customer::where('member_code', $referral_id)->where('status', '1')->first();
                   if(!isset($existreferal->id)){
                    return returnResponse('Invalid Referal Code', HttpStatus::HTTP_BAD_REQUEST);   
                   }
                   }
            
            if(!empty($email)){
                $email = strtolower($email);
            }
                //insert data into customer
                $customers_id = Customer::insertGetId([
                    'role_id' => 2,
                    'first_name' => $customers_firstname,
                    'mobile' => $mobile,
                    'email' => $email,
                    'mobile_verified' => '1',
                    'password' => $password,
                    'member_code' => $referal_token,
                    'normal_referral' => $referral_id,
                    'status' => '1',
                    'created_at' => date('y-m-d h:i:s'),
                    'is_prime' => 'N',
                ]);
                if($otp_for =='normal_signup' && !empty($referral_id)){
                 self::distributeDirectIncome($customers_id,$referral_id);
                }    
                try {
            
            $user = CustomerLogin::where('id', $customers_id)->where('status', '1')->where('role_id', '2')->first();
                if ($token = JWTAuth::fromUser($user)) {

                    if (isset($user->id)) {

                        $customers_id = $user->id;

                        //update record of customers_info
                        $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                        $customers_info_id = $customers_id;
                        $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                        $customers_info_number_of_logons = '1';
                        $customers_info_date_account_created = date('Y-m-d H:i:s');
                        $global_product_notifications = '1';

                        if (count($existUserInfo)>0) {
                            //update customers_info table
                            DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                                'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                'global_product_notifications' => $global_product_notifications,
                                'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                            ]);

                        } else {
                            //insert customers_info table
                            $customers_default_address_id = DB::table('customers_info')->insertGetId(
                                ['customers_info_id' => $customers_info_id,
                                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                    'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                    'customers_info_date_account_created' => $customers_info_date_account_created,
                                    'global_product_notifications' => $global_product_notifications,
                                ]
                            );

                            Customer::where('id', $customers_id)->update([
                                'default_address_id' => $customers_default_address_id,
                                'mobile_verified' => '1',
                            ]);
                        }

                        //check if already login or not
                        $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                        if (count($already_login) > 0) {
                            DB::table('whos_online')
                                ->where('customer_id', $customers_id)
                                ->update([
                                    'full_name' => $user->first_name . ' ' . $user->last_name,
                                    'time_entry' => date('Y-m-d H:i:s'),
                                ]);
                        } else {
                            DB::table('whos_online')
                                ->insert([
                                    'full_name' => $user->first_name . ' ' . $user->last_name,
                                    'time_entry' => date('Y-m-d H:i:s'),
                                    'customer_id' => $customers_id,
                                ]);
                        }

                       
                        if(isset($user->member_code)){
                            $user_level_income = DB::table('user_level_incomes')
                            ->where('member_code', '=', $user->member_code)
                            ->where('status', '=', "REGISTERED")
                            ->where('is_paid', '=', "N")
                            ->sum('amount');
                            $user->f_wallet = $user_level_income;
                        }
                        //$responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');
                         $now = Carbon::now();
                        $data = array(
                            'access_token' => $token,
                            'token_type' => 'Bearer',
                            'expires_in' => JWTFactory::getTTL() * 60,
                            'last_login' => substr($now, 0, strlen($now)),
                            'user' => $user,
                        );

                        DB::commit();
                    return returnResponse("Registration done Successfully !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);

                    } else {
                        //$responseData = array('success' => '0', 'data' => array(), 'message' => "Your account has been deactivated.");
                        return returnResponse("Your account has been deactivated.", HttpStatus::HTTP_UNAUTHORIZED);
                    }
                } else {
                    Log::error(__CLASS__."::".__FUNCTION__." Login attempt failed !");
                    return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);

                }
            
            
        
                }
              catch (JWTException $exc) {
                  Log::error(__CLASS__."::".__FUNCTION__." Exception : ".$exc->getMessage());
                  return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
              }
                
            }else{
                return returnResponse('Invalid Otp', HttpStatus::HTTP_UNAUTHORIZED);
            }
        } 
            return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
        
       
    }
    
//Send Otp for customer Login
    
    public static function usualLoginSendOtp($request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string|between:10,12',
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        $currentDateTime = Carbon::now();
        $otpExpiry = Carbon::now()->addMinute(15);
        
        $mobile = $request->mobile_no;

        $consumer_data = getallheaders();
        Log::debug(__CLASS__."::".__FUNCTION__."called with Mobile no. $mobile");
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

          $otp_for = 'login';
        if ($authenticate == 1) {

            //check email existance
            $existUser = Customer::where('mobile', $mobile)->where('role_id', '2')->where('status', '1')->first();
            
            $otp = generateOtp($mobile);
            if (isset($existUser->id)) {
                if($existUser->status == '1'){
                $otpHistory = new OtpHistory;
                $otpHistory->mobile_no = $mobile;
                $otpHistory->otp = $otp;
                $otpHistory->otp_for = $otp_for;
                $otpHistory->otp_expiry = $otpExpiry;
                if($otpHistory->save()){
                $message_text = "Dear ".$existUser->first_name.", OTP for Login is ".$otp.". Please dont share this to anyone.
Team,
".config('app.send_sms_company_name');
                
                Log::debug("sms scheduled as $message_text");
                if(SmsService::scheduleNewSMS($mobile, $message_text, 'otp', '1')){
                Log::debug("Otp Sent $otp");
                return returnResponse("Otp Sent successfully!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, 'true');
                
                }
                }
                return returnResponse("Otp Seding Failed!", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, 'false');
               
                
                }
                return returnResponse('Your Account is deactive !', HttpStatus::HTTP_BAD_REQUEST);
            } else {
                
                return returnResponse("User Dosen't Exists !", HttpStatus::HTTP_BAD_REQUEST);
            }

        } 
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    
    
    // Validate Referral Code
    public static function validateReferralCode($request)
    {
        Log::debug(__CLASS__."".__FUNCTION__."called");
        
        $validator = Validator::make($request->all(), [
            'referral_code' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $member_code = $request->referral_code;
        Log::debug(__CLASS__."".__FUNCTION__."referral code recieved as $member_code");
            try{
            $existUser = Customer::where('member_code', $member_code)->where('status', 'ACTIVE')->first();
               
            if (isset($existUser->id)) {
                $name['name'] = $existUser->name;
                $name['code'] = $existUser->member_code;
                //response if email already exit
                //$responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address is already exist");
                
                return returnResponse("Referral code is valid !", HttpStatus::HTTP_OK,HttpStatus::HTTP_SUCCESS,$name);
                
            } else {
                return returnResponse("Referral code is not valid !", HttpStatus::HTTP_BAD_REQUEST);
            }
           }catch(\Exception $e){
   return returnResponse($e->getMessage(), HttpStatus::HTTP_BAD_REQUEST); 
}
return returnResponse("Opps Some Error Occured", HttpStatus::HTTP_BAD_REQUEST);
        
    }
    // Validate Referral Code
    public static function getParentCodeByReferralCode($member_code)
    {
        Log::debug(__CLASS__."".__FUNCTION__."called");
        
        
        Log::debug(__CLASS__."".__FUNCTION__."referral code recieved as $member_code");
            try{
            $existUser = Customer::where('member_code', $member_code)->where('status', 'ACTIVE')->first();
               
            if (isset($existUser->id)) {
               return $existUser;
            } else {
                return false;
            }
           }catch(\Exception $e){
               Log::error(__CLASS__."".__FUNCTION__." Error ".$e->getTraceAsString());
               return false;
}
return false;
        
    }
    // Validate Referral Code
    public static function validateUserName($request)
    {
        Log::debug(__CLASS__."".__FUNCTION__."called");
        
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $user_name = $request->user_name;
        Log::debug(__CLASS__."".__FUNCTION__."User Name recieved as $user_name");
            try{
            $existUser = Customer::where('user_name', $user_name)->get();
               
            if (count($existUser) > 0) {
                return returnResponse("User Name is already Exits !", HttpStatus::HTTP_NOT_ACCEPTABLE,HttpStatus::HTTP_WARNING);
                
            } else {
                return returnResponse("User Name is valid !", HttpStatus::HTTP_OK,HttpStatus::HTTP_SUCCESS);
            }
           }catch(\Exception $e){
   return returnResponse($e->getMessage(), HttpStatus::HTTP_BAD_REQUEST); 
}
return returnResponse("Opps Some Error Occured", HttpStatus::HTTP_BAD_REQUEST);
        
    }
    
    //validate user phone number
    public static function validateUserPhone($request)
    {
        Log::debug(__CLASS__."".__FUNCTION__."called");
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $mobile = $request->mobile;
        Log::debug(__CLASS__."".__FUNCTION__."User Phone number recieved as $mobile");
            try{
            $existUser = Customer::where('mobile', $mobile)->get();
               
            if (count($existUser) > 0) {
                return returnResponse("Mobile number is already Exits !", HttpStatus::HTTP_NOT_ACCEPTABLE,HttpStatus::HTTP_WARNING);
                
            } else {
                return returnResponse("Mobile number is valid !", HttpStatus::HTTP_OK,HttpStatus::HTTP_SUCCESS);
            }
           }catch(\Exception $e){
   return returnResponse($e->getMessage(), HttpStatus::HTTP_BAD_REQUEST); 
}
return returnResponse("Opps Some Error Occured", HttpStatus::HTTP_BAD_REQUEST);
        
    }
    //validate user email
    public static function validateUserEmail($request)
    {
        Log::debug(__CLASS__."".__FUNCTION__."called");
        
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $email = $request->email;
        Log::debug(__CLASS__."".__FUNCTION__."User Email recieved as $email");
            try{
            $existUser = Customer::where('email', $email)->get();
               
            if (count($existUser) > 0) {
                return returnResponse("Email is already Exits !", HttpStatus::HTTP_NOT_ACCEPTABLE,HttpStatus::HTTP_WARNING);
                
            } else {
                return returnResponse("Email is valid !", HttpStatus::HTTP_OK,HttpStatus::HTTP_SUCCESS);
            }
           }catch(\Exception $e){
   return returnResponse($e->getMessage(), HttpStatus::HTTP_BAD_REQUEST); 
}
return returnResponse("Opps Some Error Occured", HttpStatus::HTTP_BAD_REQUEST);
        
    }
    
    //update Referral Url
    
    public static function updateReferralUrl($request)
    {
        $validator = Validator::make($request->all(), [
            'referral_url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $referral_url = $request->referral_url;
        

        $consumer_data = getallheaders();
        
        Log::debug(__CLASS__."::".__FUNCTION__."called with user id".auth()->user()->id);

try{
            $user = Customer::where('id', auth()->user()->id)->first();
            Log::debug(__FUNCTION__."user id ".$user->id.", Referral URL : ".$user->referral_url);
            if(isset($user->id) and empty($user->referral_url)){
                $updated = Customer::where('id', auth()->user()->id)->update(['referral_url'=>$referral_url]);
                if ($updated) {
                    return returnResponse("Referral url is Updated !", HttpStatus::HTTP_OK,HttpStatus::HTTP_SUCCESS);
                } else {
                    return returnResponse("Referral url updating Failed !", HttpStatus::HTTP_BAD_REQUEST);
                }
            }else{
                return returnResponse("Referral url already Exists !");
            }
}catch(\Exception $e){
   return returnResponse($e->getMessage(), HttpStatus::HTTP_BAD_REQUEST); 
}
return returnResponse("Opps Some Error Occured", HttpStatus::HTTP_BAD_REQUEST);
             

    }
    
    //update FCM Token
    
    public static function updateFcmToken($request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), HttpStatus::HTTP_BAD_REQUEST);
        }
        
        $fcm_token = $request->fcm_token;
        

        $consumer_data = getallheaders();
        
        Log::debug(__CLASS__."::".__FUNCTION__."called with user id ".auth()->user()->id);
      

            $user = Customer::where('id', auth()->user()->id)->first();
            Log::debug(__FUNCTION__."user id = ".$user->id.", FCM Token : ".$user->fcm_token);
            if(isset($user->id)){
                try{
                    $updated = Customer::where('id', auth()->user()->id)->update(['fcm_token'=>$fcm_token]);
                    Log::error(__FUNCTION__." Exception found! ");
                    Log::error($updated);
                    if ($updated) {
                        return returnResponse("FCM Token is Updated !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS);
                    } else {
                        return returnResponse("FCM Token updating Failed !", HttpStatus::HTTP_BAD_REQUEST);
                    }
                } catch(Exception $ex){
                    Log::error(__FUNCTION__." Exception found! ");
                    Log::error(__FUNCTION__." Exception : ".$ex->getMessage());
                }
            }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    
   
    
    
    //generate random password
    protected static function createRandomPassword() {
		$pass = substr(uniqid(mt_rand(), true) , 0, 6);
		return Crypt::encrypt($pass);
	}
        // Generate referral token
    protected static function generateReferralToken() {
        $code = "";
        do {
            //$code = substr(uniqid(mt_rand(), true) , 0, 6);
            $code = substr(sha1(time()), 0, 8);
            $data = Customer::where('member_code', $code)->get();
        } while ($data->count() > 0);
        return $code;
    }
    
    
    
    

}
