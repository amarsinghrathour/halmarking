<?php

namespace App\Http\Controllers\Api;

use DB;
use Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Services\Api\CustomerService;
use App\Helpers\HttpStatus;
use App\Models\Customer;

class CustomersController extends Controller {

    //login
    public function processlogin(Request $request) {
        return CustomerService::processlogin($request);
    }

    //registration
    public function processregistration(Request $request) {
        return CustomerService::processregistration($request);
    }

    // Otp Sending and registration if not already
    public function normalLogin(Request $request) {
        return CustomerService::usualLoginSendOtp($request);
    }

    //verify otp and send login token
    public function verifyLogin(Request $request) {
        return CustomerService::verifyLogin($request);
    }

    // prime signup
    public function primeSignup(Request $request) {
        return CustomerService::primeSignup($request);
    }

    // prime signup verify
    public function primeSignupVerify(Request $request) {
        return CustomerService::primeSignupVerify($request);
    }

    // Normal signup
    public function normalSignup(Request $request) {
        return CustomerService::normalSignup($request);
    }

    // Normal signup
    public function normalSignupVerify(Request $request) {
        return CustomerService::normalSignupVerify($request);
    }

    //Validate Refferal code
    public function validateReferralCode(Request $request) {
        return CustomerService::validateReferralCode($request);
    }

    public function validateUserName(Request $request) {
        return CustomerService::validateUserName($request);
    }

    public function validateUserPhone(Request $request) {
        return CustomerService::validateUserPhone($request);
    }

    public function validateUserEmail(Request $request) {
        return CustomerService::validateUserEmail($request);
    }

    //Update Refferal url
    public function updateReferralUrl(Request $request) {
        return CustomerService::updateReferralUrl($request);
    }

    //Update Refferal url
    public function updateFcmToken(Request $request) {
        return CustomerService::updateFcmToken($request);
    }

    //notify_me
    public function notify_me(Request $request) {
        return CustomerService::notify_me($request);
    }

    //update profile
    public function updatecustomerinfo(Request $request) {
        return CustomerService::updatecustomerinfo($request);
    }

    //processforgotPassword
    public function processforgotpassword(Request $request) {
        return CustomerService::processforgotpassword($request);
    }

    //facebookregistration
    public function facebookregistration(Request $request) {
        return CustomerService::facebookregistration($request);
    }

    //googleregistration
    public function googleregistration(Request $request) {
        return CustomerService::googleregistration($request);
    }

    //generate random password
    function createRandomPassword() {
        $pass = substr(uniqid(mt_rand(), true), 0, 6);
        return Hash::make($pass);
    }

    //generate random password
    function registerdevices(Request $request) {
        return CustomerService::registerdevices($request);
    }

    function updatepassword(Request $request) {
        return CustomerService::updatepassword($request);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {

        if (isset(auth()->user()->id)) {
            auth()->logout();

            return response()->json(['message' => 'User successfully signed out']);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request) {

        if (isset(auth()->user()->id)) {
            return $this->createNewToken(auth()->refresh(), $request);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    public function checkLogin(Request $request) {
        if (auth()->user()->id) {


            return returnResponse("User Logged in !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(Request $request) {


        if (auth()->user()->id) {

            $user = Customer::where('id', auth()->user()->id)->first();



            // $kyc_info = DB::table('customers_kyc')->where('user_id', '=', auth()->user()->id)->first();
            // $user->kyc_info = $kyc_info;

            return returnResponse("User Profile data !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $user);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token, $request) {
        $existUser = Customer::where('id', auth()->user()->id)->where('status', 'ACTIVE')->get();

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
        }
    }

}
