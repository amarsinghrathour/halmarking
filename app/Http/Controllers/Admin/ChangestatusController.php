<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ChangestatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('lockedscreen');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //wright your code here
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
     * Change data status using ajax call
     */
    public function changeStatus(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');
        $table = $request->post('table');
        Log::debug("id-> $id, status-> $status, table-> $table");
        $data = array();
        if(!empty($id) and !empty($status) and !empty($table)){
            
            if(DB::table($table)->where('id', $id)->update(['status' => $status, "updated_by" => Auth::user()->email, "updated_at" => now()]))
            {
                session()->put("success","Data $status Successfully Updated");
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Your data has been updated';
            }
            else
            {
                session()->put("error","Data $status Updating Failed");
                $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
            }
        } else {
            Log::debug("Empty Data");
            $data['code'] = 201;
            $data['status'] = 'error';
            $data['message'] = 'Data updating failed ! Empty';
        }
        //return response()->json(['success' => 'Your data has been updated !']);
        return response()->json($data);
    }
    
   /*
     * Get Status Lable
     */
    public static function getStatusLabel($status)
    {
        $resp = '<span class="badge badge-default"><i class="fa fa-hand-point-right">&nbsp;</i>'.$status.'</span>';
        switch ($status) {
            case 'PENDING':
                $resp= '<span class="badge badge-warning"><i class="fa fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'NO':
                $resp= '<span class="badge badge-warning"><i class="fa fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'PAID':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';

                break;
            case 'CREDIT':
                $resp= '<span class="badge badge-success"><i class="fa fa-plus">&nbsp;</i>'.$status.'</span>';

                break;
            case 'ACTIVE':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'APPROVED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';
                
                break;
            case 'INACTIVE':
                $resp= '<span class="badge badge-danger"><i class="fa fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            case 'BLOCKED':
                $resp= '<span class="badge badge-danger"><i class="fa fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            case 'DEBIT':
                $resp= '<span class="badge badge-danger"><i class="fa fa-minus">&nbsp;</i>'.$status.'</span>';

                break;
            case 'YES':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';

                break;
            case 'PROCESS':
                $resp= '<span class="badge badge-warning"><i class="fa fa-hourglass-half">&nbsp;</i>'.$status.'</span>';

                break;
            case 'STARTED':
                $resp= '<span class="badge badge-success"><i class="fa fa-check">&nbsp;</i>'.$status.'</span>';

                break;
            case 'END':
                $resp= '<span class="badge badge-danger"><i class="fa fa-ban">&nbsp;</i>'.$status.'</span>';

                break;
            default:
                $resp= '<span class="badge badge-default"><i class="fa fa-hand-point-right">&nbsp;</i>'.$status.'</span>';
                
                break;
        }
        return $resp;
    }
    
}
