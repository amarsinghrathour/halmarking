<?php
namespace App\Http\Controllers\Api;

use Auth;
use DB;
use Log;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use App\Services\Api\CmsService;
use App\Models\Core\User;
use Validator;
use App\Helpers\HttpStatus;


use App\Models\Customer;

class AppCmsController extends Controller
{

    
    //get slots with date
    public function getGallery(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return CmsService::getGallery($request);
    }
    
     //book Appointment
    public function getGalleryImages(Request $request){
        Log::debug(__CLASS__." :: ".__FUNCTION__." called");
        return CmsService::getGalleryImages($request);
    }
    
    
   

   
   
   
}
