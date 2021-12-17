<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\GreenHouse;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function NamePlant($typeFood)
    {
        $url = 'http://apipcst.xyz/api/search/package/' . $typeFood;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $plantName = $data['plantName'];
        return $plantName;
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
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
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function UserVerication($id)
    {
        $user = Auth::user();
        $greenhouse = GreenHouse::find($id);
        if ($greenhouse == null) {
            return true;
        }
        if ($greenhouse->idCompany == $user->idCompany) {
            return true;
        } else {
            return false;
        }
    }
    public function getActiveNotification(){
        $user = Auth::user();
        $notifs = DB::table("tblnotification")
            ->leftjoin('tblSensor','tblnotification.idSensor','=','tblSensor.idSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->select('tblnotification.idSensor','tblnotification.description' , 'tblnotification.codeErreur' , 'tblnotification.alerteStatus')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('alerteStatus' , '=', 0)->get();

        $Notifications = [];
        foreach ($notifs as $notif) {
            array_push($Notifications, [
                "idSensor" => $notif->idSensor,
                "description" => $notif->description,
                "codeErreur" => $notif->codeErreur,
                "alerteStatus" => $notif->alerteStatus,
            ]);
        }
        return $Notifications;
    }
}


