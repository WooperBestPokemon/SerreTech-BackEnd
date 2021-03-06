<?php

namespace App\Http\Controllers\API;


use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psy\Util\Json;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;

class apiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("json.response");
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            Token::where('user_id','=',$user->idProfile)->delete();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return Controller::sendResponse($success, 'User login successfully.');
        } else {
            return Controller::sendError('Unauthorised.', ['error' => 'Unauthorised', $request->email()]);
        }
    }

    public function ViewGreenHouse()
    {
        $greenhouses = [];
        foreach (GreenHouse::all() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
                "luminosite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'luminosite', false),
                "humidite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite', false),
                "humidite_sol" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite sol', false),
                "temperature" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'temperature', false),
            ]);
        }

        return Controller::sendResponse(['GreenHouse' =>$greenhouses], 'Donn??e Recuperer');

    }

    public function ViewZone($id)
    {
        $zones = [] ;
        foreach(Zone::where('idGreenHouse','=',$id)->get() as $zone) {
            array_push($zones, [
                "idZone" => $zone->getAttributes()["idZone"],
                "name" => $zone->getAttributes()["name"],
                "description" => $zone->getAttributes()["description"],
                "img" => $zone->getAttributes()["img"],
                "typeFood" => Controller::NamePlant($zone->getAttributes()["typeFood"]),
                "idGreenHouse" => $zone->getAttributes()["idGreenHouse"]
            ]);
        }
        if($zones == null){
            return Controller::sendError('Server Error', ['error' => 'Zone not found'],500);
        }
        return Controller::sendResponse(['zone' => $zones ], 'Donn??e Recuperer');

    }

    public function ViewSensor($id){

        $sensors = [] ;
        foreach(Sensor::where('idZone','=',$id)->get() as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->getAttributes()["idSensor"],
                "name" => $sensor->getAttributes()["name"],
                "description" => $sensor->getAttributes()["description"],
                "typeData" => $sensor->getAttributes()["typeData"],
                "idZone" => $sensor->getAttributes()["idZone"]
            ]);
        }
        if($sensors == null){
            return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
        }
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donn??e Recuperer');

    }

    public function SearchGreenhouse($id)
    {
        $greenhouses = [];
        foreach (GreenHouse::where('idGreenHouse','=',$id)->get() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
                "luminosite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'luminosite', false),
                "humidite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite', false),
                "humidite_sol" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite sol', false),
                "temperature" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'temperature', false),
            ]);
        }
        if($greenhouses == null){
            return Controller::sendError('Server Error', ['error' => 'Greenhouse not found'],500);
        }
        return Controller::sendResponse(['greenhouse' => $greenhouses ], 'Donn??e Recuperer');

    }

    public function SearchZone($id)
    {
        $Zones = [] ;
        $Zone = Zone::find($id);
        if($Zone != null) {
            if (Controller::UserVerication($Zone->idGreenHouse) == true) {
                foreach (Zone::where('idZone', '=', $id)->get() as $zone) {
                    array_push($Zones, [
                        "idZone" => $zone->getAttributes()["idZone"],
                        "name" => $zone->getAttributes()["name"],
                        "description" => $zone->getAttributes()["description"],
                        "img" => $zone->getAttributes()["img"],
                        "typeFood" => Controller::NamePlant($zone->getAttributes()["typeFood"]),
                        "idGreenHouse" => $zone->getAttributes()["idGreenHouse"],
                        "luminosite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'luminosite', false),
                        "humidite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite', false),
                        "humidite_sol" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite sol', false),
                        "temperature" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'temperature', false),
                    ]);
                }
            }
            else {
                return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
            }
        }
        if($Zones == null){
            return Controller::sendError('Server Error', ['error' => 'Zone not found'],500);
        }
        return Controller::sendResponse(['zone' => $Zones ], 'Donn??e Recuperer');

    }

    public function SearchSensor($id){

        $sensors = [] ;
        $sens = Sensor::find($id);
        if($sens != null) {
            $zone = Zone::find($sens->idZone);
            if ($zone != null) {
                if (Controller::UserVerication($zone->idGreenHouse) == true) {
                    foreach (Sensor::where('idSensor', '=', $id)->get() as $sensor) {
                        array_push($sensors, [
                            "idSensor" => $sensor->getAttributes()["idSensor"],
                            "name" => $sensor->getAttributes()["name"],
                            "description" => $sensor->getAttributes()["description"],
                            "typeData" => $sensor->getAttributes()["typeData"],
                            "idZone" => $sensor->getAttributes()["idZone"],
                            "valeur" => apiController::GetAvgDataSensor($sensor->getAttributes()["idSensor"]),
                        ]);
                    }
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
        if($sensors == null){
            return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
        }
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donn??e Recuperer');
    }

    public function GetDataLastDay($idSensor)
    {
        $datas = [];
        $sens = Sensor::find($idSensor);
        if ($sens != null) {
            $zone = Zone::find($sens->idZone);
            if ($zone != null) {
                if (Controller::UserVerication($zone->idGreenHouse) == true) {

                    $datas = DB::table('tblData')
                        ->select('data', 'timestamp', 'idSensor')
                        ->where('timestamp', '>=', now()->subDays(1))
                        ->where('timestamp', '<=', now())
                        ->where('idSensor', '=', $idSensor)
                        ->pluck('data', 'timestamp');
                } else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
        return Controller::sendResponse(['valeur' => $datas], 'Donn??e Recuperer');
    }
    public function GetAvgDataSensor($idSensor)
    {
        $datas = [];
                    $datas = DB::table('tblData')
            ->select('data')
            ->where('timestamp', '>=', now()->subMinutes(30))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)
            ->average('data');
                return $datas;
    }
    public function GetDataLastWeek($idSensor)
    {
        $datas = [];
        $sens = Sensor::find($idSensor);
        if($sens != null) {
            $zone = Zone::find($sens->idZone);
            if ($zone != null) {
                if (Controller::UserVerication($zone->idGreenHouse) == true) {

                    $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subWeeks(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)->get();
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
        return Controller::sendResponse(['valeur' => $datas ], 'Donn??e Recuperer');
    }

    public function GetDataLastMonth($idSensor)
    {
        $datas = [];
        $sens = Sensor::find($idSensor);
        if($sens != null) {
            $zone = Zone::find($sens->idZone);
            if ($zone != null) {
                if (Controller::UserVerication($zone->idGreenHouse) == true) {

                    $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subMonths(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)
            ->pluck('data','timestamp');
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
        return Controller::sendResponse(['valeur' => $datas ], 'Donn??e Recuperer');
    }

    public function GetDataLastYear($idSensor)
    {
        $datas = [];
        $sens = Sensor::find($idSensor);
        if($sens != null) {
            $zone = Zone::find($sens->idZone);
            if ($zone != null) {
                if (Controller::UserVerication($zone->idGreenHouse) == true) {
                    $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subYears(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)->get();
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }

        return Controller::sendResponse(['valeur' => $datas ], 'Donn??e Recuperer');
    }

    public function GetAvgDataGreenhouse($idGreenHouse, $typedata,$json = true)
    {
        if (Controller::UserVerication($idGreenHouse) == true) {
            $datas = DB::table('tblData')
                ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
                ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
                ->leftjoin('tblGreenHouse', 'tblGreenHouse.idGreenHouse', '=', 'tblZone.idGreenHouse')
                ->selectRaw('AVG(tblData.data) as valeur')
                ->where('timestamp', '>=', now()->subMinutes(30))
                ->where('tblSensor.typeData', '=', $typedata)
                ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenHouse)
                ->get();
        }
        else {
            return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }

        if($json == true){
            return Controller::sendResponse(['valeur' => $datas ], 'Donn??e Recuperer');
        }
        else{
            return $datas[0]->valeur;
        }
    }
    public function GetAvgDataZone($idZone,$typeData,$json = true)
    {
        $zone = Zone::find($idZone);
        if ($zone != null) {
            if (Controller::UserVerication($zone->idGreenHouse) == true) {
                $datas = DB::table('tblData')
                    ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
                    ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
                    ->selectRaw('AVG(tblData.data) as valeur')
                    ->where('timestamp', '>=', now()->subMinutes(30))
                    ->where('tblSensor.typeData', '=', $typeData)
                    ->where('tblZone.idZone' ,'=',$idZone)
                    ->get();
            }
            else {
                return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
            }
        }
        if($json == true){
            return Controller::sendResponse(['valeur' => $datas ], 'Donn??e Recuperer');
        }
        else{
            return $datas[0]->valeur;
        }
    }
    public function GetSensorsGreenhouse($idGreenhouse)
    {
        if (Controller::UserVerication($idGreenhouse) == true) {
            $user = Auth::user();
            $data = DB::table('tblSensor')
                ->leftjoin('tblZone', 'tblZone.idZone', '=', 'tblSensor.idZone')
                ->leftjoin('tblGreenHouse', 'tblGreenHouse.idGreenHouse', '=', 'tblZone.idGreenHouse')
                ->select('tblSensor.idSensor', 'tblSensor.name', 'tblSensor.description', 'tblSensor.typeData', 'tblSensor.idZone', 'tblGreenHouse.idGreenHouse')
                ->where('idCompany', '=', $user->idCompany)
                ->where('tblGreenHouse.idGreenHouse', '=', $idGreenhouse)
                ->get();

            $sensors = [];
            foreach ($data as $sensor) {
                array_push($sensors, [
                    "idSensor" => $sensor->idSensor,
                    "name" => $sensor->name,
                    "description" => $sensor->description,
                    "typeData" => $sensor->typeData,
                    "idZone" => $sensor->idZone,
                    "idGreenhouse" => $sensor->idGreenHouse,
                    "valeur" => apiController::GetAvgDataSensor($sensor->idSensor, false),
                    "Notification" => apiController::GetNotificationSensor($sensor->idSensor)
                ]);
            }
            if ($sensors == null) {
                return Controller::sendError('Server Error', ['error' => 'Sensor not Found'], 500);
            }
            return Controller::sendResponse(['sensors' => $sensors], 'Donn??e Recuperer');
        }
    }
    public function GetSensorsType($typeData){
        $user = Auth::user();
        $data = DB::table('tblSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->select('tblSensor.idSensor','tblSensor.name','tblSensor.description','tblSensor.typeData','tblSensor.idZone')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('tblSensor.typeData','=',$typeData)
            ->get();

        $sensors = [] ;
        foreach($data as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->idSensor,
                "name" => $sensor->name,
                "typeData" => $sensor->typeData,
                "idZone" => $sensor->idZone,
                "valeur"=>apiController::GetAvgDataSensor($sensor->idSensor,false),
            ]);
        }
        return Controller::sendResponse(['sensors' => $sensors ], 'Donn??e Recuperer');
    }

    public function GetSensors(){
        $user = Auth::user();
        $data = DB::table('tblSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->select('tblSensor.idSensor','tblSensor.name','tblSensor.description','tblSensor.typeData','tblSensor.idZone')
            ->where('idCompany' ,'=',$user->idCompany)
            ->get();

        $sensors = [] ;
        foreach($data as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->idSensor,
                "name" => $sensor->name,
                "typeData" => $sensor->typeData,
                "idZone" => $sensor->idZone,
                "valeur"=>apiController::GetAvgDataSensor($sensor->idSensor,false),
            ]);
        }
        return Controller::sendResponse(['sensors' => $sensors ], 'Donn??e Recuperer');
    }

    public function GetGraph($typeData,$idGreenhouse,$temps){
        if (Controller::UserVerication($idGreenhouse) == true) {
            if ($temps == 1) $temp = now()->subHours(1);
            if ($temps == 2) $temp = now()->subdays(1);
            if ($temps == 3) $temp = now()->subWeeks(1);
            $user = Auth::user();
            $data = DB::table('tblData')
                ->leftjoin('tblSensor', 'tblData.idSensor', '=', 'tblSensor.idSensor')
                ->leftjoin('tblZone', 'tblZone.idZone', '=', 'tblSensor.idZone')
                ->leftjoin('tblGreenHouse', 'tblGreenHouse.idGreenHouse', '=', 'tblZone.idGreenHouse')
                ->select('tblData.data as valeur', 'tblData.timestamp as Temps')
                ->where('idCompany', '=', $user->idCompany)
                ->where('timestamp', '>=', $temp)
                ->where('tblSensor.typeData', '=', $typeData)
                ->where('tblGreenHouse.idGreenHouse', '=', $idGreenhouse)
                ->orderBy('tblData.timestamp')->get();

            return Controller::sendResponse(['valeur' => $data], 'Donn??e Recuperer');
        }
        else {
                return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }

    }
    public function GetGraphYear($typeData,$idGreenhouse){

        $user = Auth::user();
        $data2 = [];
        if (Controller::UserVerication($idGreenhouse) == true) {
            $data = DB::table('tblData')
                ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
                ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
                ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
                ->selectRaw('AVG(tblData.data) as Valeur,MONTH(timestamp) as Temps')
                ->where('idCompany' ,'=',$user->idCompany)
                ->where('timestamp', '>=', now()->subYears(1))
                ->where('tblSensor.typeData','=',$typeData)
                ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
                ->groupBy('Temps')->get();
            foreach($data as $d) {
                array_push($data2, [
                    "valeur" => $d->Valeur,
                    "Temps" => apiController::selectMonth($d->Temps)
                ]);
            }
        }
        else {
            return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
        return Controller::sendResponse(['valeur' => $data2 ], 'Donn??e Recuperer');
    }
    public function selectMonth($month){
        switch ($month){
            case 1 : return "Janvier";
            case 2 : return "Fevrier";
            case 3 : return "Mars";
            case 4 : return "Avril";
            case 5 : return "Mai";
            case 6 : return "Juin";
            case 7 : return "Juillet";
            case 8 : return "Aout";
            case 9 : return "Septembre";
            case 10 : return "Octobre";
            case 11 : return "Novembre";
            case 12 : return "Decembre";
            default : return  "Bug";
        }
    }
    public function GetGraphMonth($typeData,$idGreenhouse){

        $user = Auth::user();
        $data2 = [];
        if (Controller::UserVerication($idGreenhouse) == true) {
        $data = DB::table('tblData')
            ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->selectRaw('AVG(tblData.data) as Valeur,DAY(timestamp) as Temps')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('timestamp', '>=', now()->subMonths(1))
            ->where('tblSensor.typeData','=',$typeData)
            ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
            ->groupBy('Temps')->get();
            foreach($data as $d) {
                array_push($data2, [
                    "valeur" => $d->Valeur,
                    "Temps" => "Jour ".$d->Temps
                ]);
            }
        }
        else
        {
        return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
        return Controller::sendResponse(['valeur' => $data2 ], 'Donn??e Recuperer');
    }
    public function GetNotificationSensor($idSensor){

        $notifs = DB::table("tblnotification")
            ->select('tblnotification.idSensor','tblnotification.description' , 'tblnotification.codeErreur' , 'tblnotification.alerteStatus')
            ->where('tblnotification.idSensor' ,'=' , $idSensor)
            ->where('tblnotification.alerteStatus' , '=', false)->get();
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

