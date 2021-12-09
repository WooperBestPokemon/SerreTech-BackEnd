<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function GetNotification(){

        // Recupere l'utilisateur qui est logger
        $user = Auth::user();

        // Companie -> Greenhouse -> Zone -> Sensor -> Notification

        $data = DB::table('tblnotification')
            ->leftjoin('tblSensor', 'tblSensor.idSensor', '=', 'tblnotification.idSensor')
            ->leftjoin('tblZone', 'tblZone.idZone', '=', 'tblSensor.idZone')
            ->leftjoin('tblGreenHouse', 'tblGreenHouse.idGreenHouse', '=', 'tblZone.idGreenHouse')
            ->select('tblnotification.idAlerte','tblnotification.description','tblnotification.alerteStatus','tblnotification.codeErreur', 'tblnotification.idSensor')
            ->where('tblGreenHouse.idCompany', '=', $user["idCompany"])
            ->get();

        //dd($data);

        // Fais un tableau pour recupere les données en json
        $notification = [];

        foreach ($data as $alerte){
            array_push($notification, [
                "idAlerte" => $alerte->idAlerte,
                "description" => $alerte->description,
                "alerteStatus" => $alerte->alerteStatus,
                "codeErreur" => $alerte->codeErreur,
                "idSensor" => $alerte->idSensor,
                "codeErreur" => $alerte->codeErreur,
            ]);
        }
        //dd($notification);
        return view('viewNotification',["notification" => $notification]);
    }

}
