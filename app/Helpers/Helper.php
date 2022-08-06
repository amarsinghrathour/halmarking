<?php
use Illuminate\Support\Carbon;
use App\Helpers\HttpStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Core\OtpHistory;
use App\Models\Setting;
/*
 * This will be updated with Request header type, if response requetsed as XML we will validate and return the response accordingly !!
 */

if (!function_exists('SetttingValue')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function SetttingValue($key)
    {
        $result = Setting::where('key',$key)->first();
       if(isset($result->value)){
           return $result->value;
       }else{
           return false;
       }
    }
}
if(!function_exists('returnResponse')){
   function returnResponse($message='Started', $code = HttpStatus::HTTP_BAD_REQUEST, $status = HttpStatus::HTTP_ERROR, $data=null, $pager = null){
       Log::debug(__CLASS__." :: ".__FUNCTION__." started with parameters as code $code, status $status, message $message");
       $resp = new \stdClass();
       $resp->code = $code;
       $resp->status = $status;
       $resp->message = $message;
       if(!empty($pager)) {
           $data_resp = new \stdClass();
           $data_resp->data = $data;
           $data_resp->pager = $pager;
           $resp->data = $data_resp;
       } else {
           $resp->data = $data;
       }
       Log::debug(json_encode($resp));
       return response()->json($resp);
   }
}
if(!function_exists('returnUploadResponse')){
   function returnUploadResponse($message='Uploading...', $status = HttpStatus::HTTP_ERROR, $url = null){
        Log::debug(__CLASS__." :: ".__FUNCTION__." started with parameters as url $url, status $status, message $message");
        $resp = new \stdClass();
        $resp->status = $status;
        if($status == HttpStatus::HTTP_ERROR) {
            $respErr = new \stdClass();
            $respErr->message = $message;
            $resp->error = $respErr;
        }
        $resp->url = $url;
        return response()->json($resp);
   }
}
if(!function_exists('readRequiredField')){
   function readRequiredField($errors){
       $message = '';
       $comma = '';
       foreach (json_decode($errors) as $key => $value) {
           $message .= $comma.$value[0];
           $comma = ', ';
       }
       return $message;
   }
}
if(!function_exists('getNoOfDaysBetweenTwoDays')){
    function getNoOfDaysBetweenTwoDays($start_date, $end_date){
        if(!empty($start_date) and !empty($end_date)){
            return Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date), false); // It will return day count. And false for getting minus (-) days also
        }
    }
}
if(!function_exists('addNoOfMonthFromDate')){
    function addNoOfMonthFromDate($date, $month){
        if(!empty($date) and $month != ""){
            if($month == 0){
                return (string)Carbon::parse(Carbon::parse($date)->format('Y-m-d'));
            }
            return (string)Carbon::parse(Carbon::parse($date)->addMonthsNoOverflow($month)->format('Y-m-d')); // it will return a date
        }
    }
}
if(!function_exists('getNoOfMonthBetweenDates')){
    function getNoOfMonthBetweenDates($date1, $date2){
        if(!empty($date1) and !empty($date2)){
            return Carbon::parse($date1)->diffInMonths(Carbon::parse($date2), false);
        }
    }
}
if(!function_exists('getRecurringCountBetweenDates')){
    function getRecurringCountBetweenDates($date1, $date2, $interval){
        if(!empty($date1) and !empty($date2)){
            $diff = Carbon::parse($date1)->diffInMonths(Carbon::parse($date2), false);
            if($diff > $interval){
                return intval($diff / $interval);
            }
        }
        return false;
    }
}
if(!function_exists('array_sort_by_column')){
    function array_sort_by_column(&$array, $column, $direction = SORT_ASC){
        $reference_array = array();

        foreach($array as $key => $row) {
            $reference_array[$key] = $row[$column];
        }

        array_multisort($reference_array, $direction, $array);
    }
}

if(!function_exists('formatArrayToDate')){
    function formatArrayToDate($array, $format = null){
        $date = null;
        if(isset($array['year']) and isset($array['month']) and isset($array['day'])){
            $day = $array['day'];
            if(strlen($array['day']) == 1){
                $day = "0".$day;
            }
            $month = $array['month'];
            if(strlen($array['month']) == 1){
                $month = "0".$month;
            }
            $date = $array['year']."-".$month."-".$day;
            if(!empty($format))
            {
                $dateA = date_create($date);
                $date = date_format($dateA, $format);
            }
        }
        return $date;
    }
}
if(!function_exists('createPager')){
    function createPager($count, $dataLimit, $page, $offset){
        
        $pager = array();
        $pages = $count / $dataLimit;
        $fractional_value = $pages - floor($pages);
        if($fractional_value > 0){
            $pages = intval($pages) + 1;
        } else {
            $pages = round($pages, 0);
        }
        Log::debug(__CLASS__." :: ".__FUNCTION__." ::> Count : $count, Data Limit : $dataLimit, Pages : $pages");
        $pagess = array();
        for($i = 1; $i <= $pages; $i++){
            array_push($pagess, array($i));
        }
        $pager["pages"] = $pagess;
        $pager["currentPage"] = $page;
        $pager["totalPages"] = $pages;
        $pager["offset"] = $offset;
        
        return $pager;
    }
}
if(!function_exists('uploadImage')){
    function uploadImage($file, $path, $type)
    {
        try 
        {
            $fileInFolder = public_path()."/image/".$path;
            $fileName = time().'-'.rand(1,9999).'-'.$type.".".$file->getClientOriginalExtension();
            $filePathDB = 'image/'.$path."/".$fileName;
            if($file->move($fileInFolder, $fileName))
            {
                return $filePathDB;
            }
            else
            {
                return false;
            }
        } catch (Exception $ex) {
            session()->put("error"," Exception :: ".$ex->getMessage());
            return false;
        }
        return false;
    }
}

if(!function_exists('getStatusLabel')){
    function getStatusLabel($status)
    {
        $resp = '<span class="badge badge-default"><i class="fa fa-hand-point-right">&nbsp;</i>'.$status.'</span>';
        switch ($status) {
            case 'PENDING':
                $resp= '<span class="badge badge-warning"><i class="fas fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'DUE':
                $resp= '<span class="badge badge-danger"><i class="fas fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'PARTIALLY PAID':
                $resp= '<span class="badge badge-warning"><i class="fas fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'POSTPONED':
                $resp= '<span class="badge badge-warning"><i class="fas fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'REQUESTED':
                $resp= '<span class="badge badge-warning"><i class="fas fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'NO':
                $resp= '<span class="badge badge-warning"><i class="fas fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'N':
                $resp= '<span class="badge badge-danger">'.$status.'</span>';

                break;
            case 'PAID':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';

                break;
            case 'CREDIT':
                $resp= '<span class="badge badge-success"><i class="fas fa-plus">&nbsp;</i>'.$status.'</span>';

                break;
            case 'ACTIVE':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'COMPLETED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'CLOSED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'DELIVERED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'APPROVED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'BOOKED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'INACTIVE':
                $resp= '<span class="badge badge-danger"><i class="fas fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            case 'BLOCKED':
                $resp= '<span class="badge badge-danger"><i class="fas fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            case 'REJECTED':
                $resp= '<span class="badge badge-danger"><i class="fas fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            case 'DEBIT':
                $resp= '<span class="badge badge-danger"><i class="fas fa-minus">&nbsp;</i>'.$status.'</span>';

                break;
            case 'YES':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';

                break;
            case 'Y':
                $resp= '<span class="badge badge-success">'.$status.'</span>';

                break;
            case 'PROCESS':
                $resp= '<span class="badge badge-warning"><i class="fa fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'STARTED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';

                break;
            case 'END':
                $resp= '<span class="badge badge-danger"><i class="fas fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            default:
                $resp= '<span class="badge badge-default"><i class="fa fa-hand-point-right">&nbsp;</i>'.$status.'</span>';
                
                break;
        }
        return $resp;
    }
}

if(!function_exists('changeStatus')){
    function changeStatus($id,$status,$table)
    {
        try {
            if($status === 'DELETED')
            {
                return deleteData($id, $status, $table);
            }
            if(DB::table($table)->where('id', $id)->update(['status' => $status, "updated_by" => Auth::user()->email, "updated_at" => now()]))
            {
                session()->put("success","Data $status Successfully");
                return true;
            }
        } catch (Exception $ex) {
            session()->put("success","Exception :: ".$ex->getMessage()." While Data $status");
            return false;
        }
    }
}

if(!function_exists('deleteData')){
    function deleteData($id,$status,$table)
    {
        try {
            if($status != 'DELETED')
            {
                session()->put("error","Error While Deleting Data. Please Try Again.");
                return false;
            }
            if(DB::table($table)->where('id', $id)->delete())
            {
                session()->put("success","Data $status Successfully");
                return true;
            }
        } catch (Exception $ex) {
            session()->put("success","Exception ".$ex->getMessage()." While Data $status");
            return false;
        }
    }
}

if(!function_exists('getPerfetctDateTime')){
    function getPerfetctDateTime($date)
    {
        return date("Y-m-d h:i:s", strtotime($date));
    }
}

if(!function_exists('get_client_ip')){
 function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
}

 }
    if(!function_exists('get_user_agent')){
      function get_user_agent(){
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            return $_SERVER['HTTP_USER_AGENT'];
        } else {
            return null;
        }
    }
    }
    
    if (!function_exists('generateOtp')) {

    function generateOtp($mobile) {
        do {
            $code = substr(uniqid(mt_rand(), true) , 0, 4);
            $data = OtpHistory::where('otp', $code)->where('status','!=','USED')->where('mobile_no','!=',$mobile)->get();
        } while ($data->count() > 0);
        return $code;
    }

}


if(!function_exists('generateOrderId')){
    function generateOrderId() {
        $code = "";
        do {
            $code = substr(uniqid(mt_rand(), true) , 0, 6);
            $data = DB::table('orders')->where('order_id', $code)->get();
        } while ($data->count() > 0);
        return $code;
    }
}

if(!function_exists('generateGatewayTxnId')){
    function generateGatewayTxnId() {
        $code = "";
        do {
            $code = substr(uniqid(mt_rand(), true) , 0, 10);
            $data = DB::table('pgateway_txn')->where('txn_id', $code)->get();
        } while ($data->count() > 0);
        return $code;
    }
}

if(!function_exists('getTemporaryIncome')){
    function getTemporaryIncome($membercode) {
       
            $data = DB::table('user_level_incomes')->where('member_code', $membercode)->where('status', 'REGISTERED')->sum('amount');
        if(isset($data)){
        return $data;
        }
        return '0';
    }
}

if(!function_exists('getTemporaryClosingIncome')){
    function getTemporaryClosingIncome($membercode) {
       
            $data = DB::table('user_level_incomes')->where('member_code', $membercode)->where('status', 'ACTIVE')->where('is_paid','N')->sum('amount');
        if(isset($data)){
        return $data;
        }
        return '0';
    }
}
if(!function_exists('callUrl')){
    function callUrl($url) {
        
        $options = array (CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_FOLLOWLOCATION => false, // follow redirects
        CURLOPT_ENCODING => "", // handle compressed
        CURLOPT_USERAGENT => "test", // who am i
        CURLOPT_AUTOREFERER => true, // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
        CURLOPT_TIMEOUT => 120, // timeout on response
        CURLOPT_MAXREDIRS => 10 ); // stop after 10 redirects

        $ch = curl_init ( $url );
        curl_setopt_array ( $ch, $options );
        $content = curl_exec ( $ch );
        $err = curl_errno ( $ch );
        $errmsg = curl_error ( $ch );
        $header = curl_getinfo ( $ch );
        $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

        curl_close ( $ch );

        $header ['errno'] = $err;
        $header ['errmsg'] = $errmsg;
        $header ['content'] = $content;
        return $header ['content'];
    }
}
