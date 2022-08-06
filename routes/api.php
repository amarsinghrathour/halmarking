<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Api','middleware' => ['assign.guard:api_customer','apilogger']], function () {


	//processregistration url
	Route::post('/processregistration', 'CustomersController@processregistration');
    //logout
       Route::post('/logout', 'CustomersController@logout'); 
        // login url
	Route::post('/processlogin', 'CustomersController@processlogin');
        
        //Check membercode
	Route::post('/validate_referral_code', 'CustomersController@validateReferralCode');
        //Check membercode
	Route::post('/validate_user_name', 'CustomersController@validateUserName');
         //Check mobile number
	Route::post('/validate_user_mobile', 'CustomersController@validateUserPhone');
         //Check user email
	Route::post('/validate_user_email', 'CustomersController@validateUserEmail');

	
	//push notification setting
	Route::post('/notify_me', 'CustomersController@notify_me');

           
	// forgot password url
	Route::post('/processforgotpassword', 'CustomersController@processforgotpassword');
        
        ########################
        # Login Protected Routes
        ########################
        
   Route::group(['middleware' => ['jwt.verify:api_customer','apilogger']], function(){
       
       
       //user Profile
       
       Route::post('/check_login', 'CustomersController@checkLogin');
       
       
       // Update referral url
       Route::post('/update_referral_url', 'CustomersController@updateReferralUrl');
                
       Route::post('/update_fcm_token', 'CustomersController@updateFcmToken');
       
       //user Profile
       
       Route::post('/user_profile', 'CustomersController@userProfile');
       
	//update customer info url
	
	Route::post('/updatecustomerinfo', 'CustomersController@updatecustomerinfo');
	Route::post('/updatepassword', 'CustomersController@updatepassword');
        
        
    
        //getwallettxn
    Route::post('/account/get_wallet_txn', 'AccountController@getWalletTxnHistory');
             
    //makeKycRequest
    Route::post('/account/upload_kyc', 'AccountController@makeKycRequest');
    
    //Upload Avatar
    Route::post('/account/upload_avatar', 'AccountController@uploadAvatar');
    
    //Get Available Slots
    Route::post('/get_slots', 'AccountController@getSlots');
                
    //book Appointment
    Route::post('/appointment/book', 'AccountController@bookAppointment');
                
    //get Appointment
    Route::post('/appointment/get', 'AccountController@getAppointments');
                
      
  

});

//Get Album List || Gallery List
    
    Route::post('/app_cms/gallery', 'AppCmsController@getGallery');    
    Route::post('/app_cms/gallery/images', 'AppCmsController@getGalleryImages'); 


});

