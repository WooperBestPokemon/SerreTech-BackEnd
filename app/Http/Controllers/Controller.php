<?php

namespace App\Http\Controllers;

use App\Models;
use App\Models\GreenHouse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
    public function UserVerication($id){
        $user = Auth::user();

        $greenhouse = GreenHouse::find($id);
        if($greenhouse == null){
            return true;
        }
        if($greenhouse->idCompany == $user->idCompany) {
            return true;
        }
        else{
            return  false;
        }
    }
}
