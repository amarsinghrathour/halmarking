<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MachineController
 *
 * @author singh
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Models\MachineModel;
use App\Machine;
class MachineActivateController extends Controller 
{
    //put your code here
    
    public function Activate(Request $request) {
        
        
        $jwt_token = null;
        $imei = $request->input('imei');
        $code = $request->input('access_code');
        try{
            $machine_data = MachineModel::where('imei',$imei)->first();
            if($machine_data && $machine_data->access_code == $code && $machine_data->status == 'ACTIVE'){

                if (!$jwt_token = JWTAuth::attempt(['email' => $machine_data->email,'password' => 'Mark42'])) {
                return response()->json([
                    'code' => '406',
                    'response' => 'Invalid',
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
              }
              
              
            } else {
               return response()->json([
                    'code' => '406',
                    'response' => 'Invalid',
                    'message' => 'Credentials Not Acceptable',
                ], Response::HTTP_UNAUTHORIZED);
            }


            
       }
        catch (JWTException $e) {
            return response()->json([
                'message' => 'could_not_create_token',
                'data' => null
            ], 500);
        }
        
        return response()->json([
                'code' => '200',
                'response' => 'Valid',
                'message' => 'Credentials Are Valid',
                'token' => $jwt_token,
                'token_type' => 'bearer',

            ]);
        
        
    }
    
    
}
