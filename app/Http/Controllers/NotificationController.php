<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __invoke(){

        // Recupere l'utilisateur qui est logger
        $user = Auth::user();

        // Companie -> Greenhouse -> Zone -> Sensor -> Notification

        $data = DB::table('tblnotification')
            ->leftjoin('tblSensor', 'tblSensor.idSensor', '=', 'tblnotification.idSensor')
            ->leftjoin('tblZone', 'tblZone.idZone', '=', 'tblSensor.idZone')
            ->leftjoin('tblGreenHouse', 'tblGreenHouse.idGreenHouse', '=', 'tblZone.idGreenHouse')
            ->select('tblnotification.idAlerte','tblnotification.description','tblnotification.alerteStatus','tblnotification.codeErreur', 'tblnotification.idSensor','tblnotification.created_at','tblnotification.updated_at')
            ->where('tblGreenHouse.idCompany', '=', $user["idCompany"])
            ->orderBy('tblnotification.alerteStatus')
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
                "create"=> $alerte->created_at,
                "terminer"=> $this::end($alerte->created_at,$alerte->updated_at),
            ]);
        }
        $notif = Controller::getActiveNotification();
        //dd($notification);
        return view('gestion',["notification" => $notification, 'user' => $user, "notif" => $notif,"notifCount" => count($notif) ]);
    }
    public  function end($debut,$fin){
        if($debut == $fin){
            return null;
        }
        else {
            return  $fin;
        }
    }
}
