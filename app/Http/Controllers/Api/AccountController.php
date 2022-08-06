<?php
namespace App\Http\Controllers\Api;

use Auth;
use DB;
use Log;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use App\Services\Api\AccountService;
use App\Models\Core\User;
use Validator;
use App\Helpers\HttpStatus;


use App\Models\Customer;

class AccountController extends Controller
{

    
    //get slots with date
    public function getSlots(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return AccountService::getSlots($request);
    }
    
     //book Appointment
    public function bookAppointment(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return AccountService::bookAppointment($request);
    }
    
     //get Appointments with date
    public function getAppointments(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return AccountService::getAppointments($request);
    }
    
    // make withdraw request
    public function makeWithdrawRequest(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return AccountService::makeWithdrawRequest($request);
    }

    // make Kyc request
    public function makeKycRequest(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return AccountService::makeKycRequest($request);
    }

    // upload avatar
   public function uploadAvatar(Request $request){
       Log::debug(__CLASS__." :: ".__FUNCTION__." called");
       return AccountService::uploadAvatar($request);
   }
    
    public function getWalletTxnHistory(Request $request) {
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        $consumer_data = getallheaders();
        $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        $type = $request->type;
        $offset = 0;
        $dataLimit = 20;
        if(isset($request->offset)){
            $offset = $request->offset;
        }
        if ($authenticate == 1 && auth()->user()->id) {
            if($type == "s_wallet" or $type == "m_wallet"){
                $table = "";
                //sendng type s_wallet for main wallet and withdraw for s wallet
                if($type == "s_wallet"){
                    $table = "mwallet_txn";
                } else if($type == "withdraw"){
                    $table = "swallet_txn";
                } else if($type == "m_wallet"){
                   $table = "mwallet_txn";
               }
                Log::debug("Table : ".$table." :: ".auth()->user()->id);
                $data = DB::table($table)
                    ->where('user_id', '=', auth()->user()->id)
                    ->where('status', '=', "ACTIVE")
                    ->offset($offset)
                    ->limit($dataLimit)
                    ->orderBy('id', 'desc')
                    ->get();

                return returnResponse("Txn data !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);
            }
            
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    public function withdrawRequestHistory(Request $request) {
        $consumer_data = getallheaders();
        $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        if ($authenticate == 1 && auth()->user()->id) {
            Log::debug("Id : ".auth()->user()->id);
            $offset = 0;
            $dataLimit = 20;
            if(isset($request->offset)){
                $offset = $request->offset;
            }
            $data = DB::table("withdrawal_request")
                ->where('customer_id', '=', auth()->user()->id)
                ->where('status', '!=', "DELETED")
                ->offset($offset)
                ->limit($dataLimit)
                ->orderBy('id', 'desc')
                ->get();

            return returnResponse("Txn data !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
    public function checkIfscCode(Request $request){
        Log::debug("Id : ".auth()->user()->id);
        $validator = Validator::make($request->all(), [
            'ifsc_code' => 'required',
        ]);
        if($validator->fails()){
            return returnResponse($validator->errors(), HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data = AccountService::checkIfsc($request);
        return returnResponse("IFSC Response Found !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, json_decode($data));
    }
    public function getCommissionDetails(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        $consumer_data = getallheaders();
        $consumer_data['consumer_ip'] = $request->ip();
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        if ($authenticate == 1 && auth()->user()->id) {
            Log::debug("Id : ".auth()->user()->id.", Member Code = ".auth()->user()->member_code);
            $offset = 0;
            $limit = 10;
            if($request->has('offset')){
                $offset = $request->offset;
            }
            $team_count = 0;
            $user_level_income = 0;
            if($offset == 0){
                $team_count = DB::table("users")
                    ->select('id')
                    ->where('prime_referral', '=', auth()->user()->member_code)
                    ->where('status', '=', "1")
                    ->count();

                $user_level_income = DB::table('user_level_incomes')
                    ->where('member_code', '=', auth()->user()->member_code)
                    ->where('is_paid', '=', "N")
                    ->where('status', '!=', "DELETED")
                    ->sum('amount');
            }
            $member_code = auth()->user()->member_code;
            $query = DB::table('user_level_incomes')
                ->LeftJoin('users', 'user_level_incomes.child_id', '=', 'users.id')
                ->select('users.first_name as name', 'user_level_incomes.amount as amount', 'users.is_active as is_active', 'users.phone as mobile')
                ->where('user_level_incomes.status', '!=', 'DELETED')
                ->where('user_level_incomes.member_code', '=', auth()->user()->member_code)
                //->whereIn('user_level_incomes.child_id', DB::raw('select id from users where prime_referral = '.auth()->user()->member_code))
                ->where('users.status', '=', "1")
                ->where('users.role_id', '=', "2");
                $query->whereIn('user_level_incomes.child_id', function($query2) use ($member_code) {
                    $query2->select('id')
                            ->from('users')
                            ->where('prime_referral', '=', $member_code);
                });
                $query->offset($offset)->limit($limit);
                $commission_list = $query->orderby('users.id', 'asc')->get();
           
            /*
            $member_code = auth()->user()->member_code;
            $commission_list = DB::select("select users.first_name as name, user_level_incomes.amount as amount, users.is_active as is_active, users.phone as mobile from user_level_incomes left join users on user_level_incomes.child_id = users.id where user_level_incomes.status != 'DELETED' and user_level_incomes.member_code = '{$member_code}' and users.status = '1' and users.role_id = '2' order by users.id asc offset {$offset} limit {$limit}");
            */

            $data = array(
                'team_count' => $team_count,
                'income' => $user_level_income,
                'commission_list' => $commission_list,
            );

            return returnResponse("Commission Found !", HttpStatus::HTTP_OK, HttpStatus::HTTP_SUCCESS, $data);
        }
        return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED);
    }
}
