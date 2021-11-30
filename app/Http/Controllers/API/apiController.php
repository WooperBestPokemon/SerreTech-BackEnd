<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Laravel\Passport\Token;
use Psy\Util\Json;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            return Controller::sendError('Unauthorised.', ['error' => 'Unauthorised', $request->email]);
        }
    }

    public function ViewGreenHouse()
    {
        $user = Auth::user();
        $greenhouses =[];
        foreach (GreenHouse::where('idCompany','=',$user->idCompany)->get() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
                "luminosite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'luminosite',false),
                "humidite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite',false),
                "humidite_sol" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite sol',false),
                "temperature" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'temperature',false),

            ]);
        }
        return Controller::sendResponse(['GreenHouse' =>$greenhouses], 'Donnée Recuperer');

    }

    public function ViewZone($id)
    {
        $zones = [];
        if(Controller::UserVerication($id) == true) {

            foreach (Zone::where('idGreenHouse', '=', $id)->get() as $zone) {
                array_push($zones, [
                    "idZone" => $zone->getAttributes()["idZone"],
                    "name" => $zone->getAttributes()["name"],
                    "description" => $zone->getAttributes()["description"],
                    "img" => $zone->getAttributes()["img"],
                    "typeFood" => $zone->getAttributes()["typeFood"],
                    "idGreenHouse" => $zone->getAttributes()["idGreenHouse"],
                    "luminosite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'luminosite', false),
                    "humidite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite', false),
                    "humidite_sol" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite sol', false),
                    "temperature" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'temperature', false),
                ]);
            }
        }
        else{
             return Controller::sendError('Access denied', ['error' => 'Access denied'],401);
        }
        if($zones == null){
            return Controller::sendError('Server Error', ['error' => 'Zone not found'],500);
        }
        return Controller::sendResponse(['zone' => $zones ], 'Donnée Recuperer');

    }

    public function ViewSensor($id){
        $sensors = [];
        $zone = Zone::find($id);
        if($zone != null) {
            if (Controller::UserVerication($zone->idGreenHouse) == true) {

                foreach (Sensor::where('idZone', '=', $id)->get() as $sensor) {
                    array_push($sensors, [
                        "idSensor" => $sensor->getAttributes()["idSensor"],
                        "name" => $sensor->getAttributes()["name"],
                        "description" => $sensor->getAttributes()["description"],
                        "typeData" => $sensor->getAttributes()["typeData"],
                        "idZone" => $sensor->getAttributes()["idZone"],
                    ]);
                }
            }
            else {
                return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
            }
        }
        if($sensors == null){
           return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
        }
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donnée Recuperer');

    }

    public function SearchGreenhouse($id)
    {
        $greenhouses = [];
        if(Controller::UserVerication($id) == true) {
            foreach (GreenHouse::where('idGreenHouse', '=', $id)->get() as $greenhouse) {
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
        }
        else {
            return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
        if($greenhouses == null){
            return Controller::sendError('Server Error', ['error' => 'Greenhouse not found'],500);
        }
        return Controller::sendResponse(['greenhouse' => $greenhouses ], 'Donnée Recuperer');

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
                        "typeFood" => $zone->getAttributes()["typeFood"],
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
        return Controller::sendResponse(['zone' => $Zones ], 'Donnée Recuperer');

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
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donnée Recuperer');

    }

    public function GetDataLastDay($idSensor)
    {
        $datas = [];
        $sens = Sensor::find($idSensor);
        if($sens != null) {
            $zone = Zone::find($sens->idZone);
            if ($zone != null) {
                if (Controller::UserVerication($zone->idGreenHouse) == true) {

        $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subDays(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)
            ->pluck('data','timestamp');
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
            return Controller::sendResponse(['valeur' => $datas ], 'Donnée Recuperer');

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
            //->pluck('data','timestamp');
        //$datas = DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 WEEK AND idSensor = :idSensor', ['idSensor' => $idSensor]);
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
        return Controller::sendResponse(['valeur' => $datas ], 'Donnée Recuperer');
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
        //DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 MONTH AND idSensor = :idSensor', ['idSensor' => $idSensor]);
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }
        return Controller::sendResponse(['valeur' => $datas ], 'Donnée Recuperer');
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
                    //->pluck('data','timestamp');

            //DB::select('select data, timestamp, idSensor from tblData where timestamp>=NOW()- INTERVAL 1 YEAR AND idSensor = :idSensor', ['idSensor' => $idSensor]);
                }
                else {
                    return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
                }
            }
        }

        return Controller::sendResponse(['valeur' => $datas ], 'Donnée Recuperer');
    }

    public function GetAvgDataGreenhouse($idGreenHouse, $typedata,$json = true)
    {
        if (Controller::UserVerication($idGreenHouse) == true) {
        $datas = DB::table('tblData')
            ->leftjoin('tblSensor', 'tblData.idSensor', '=', 'tblSensor.idSensor')
            ->leftjoin('tblZone', 'tblZone.idZone', '=', 'tblSensor.idZone')
            ->leftjoin('tblGreenHouse', 'tblGreenHouse.idGreenHouse', '=', 'tblZone.idGreenHouse')
            ->selectRaw('AVG(tblData.data) as valeur')
            ->where('timestamp', '>=', now()->subMinutes(30))
            ->where('tblSensor.typeData', '=', $typedata)
            ->where('tblGreenHouse.idGreenHouse', '=', $idGreenHouse)
            ->get();
        }
        else {
            return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
        if($json == true){
            return Controller::sendResponse(['valeur' => $datas ], 'Donnée Recuperer');
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
            return Controller::sendResponse(['valeur' => $datas ], 'Donnée Recuperer');
        }
        else{
            return $datas[0]->valeur;
        }
    }
    public function GetSensorsGreenhouse($idGreenhouse){
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
                ]);
            }
            if($sensors == null){
                return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
            }
            else{
                return Controller::sendResponse(['sensors' => $sensors], 'Donnée Recuperer');
            }

        }
        else {
            return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
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
        return Controller::sendResponse(['sensors' => $sensors ], 'Donnée Recuperer');
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
        return Controller::sendResponse(['sensors' => $sensors ], 'Donnée Recuperer');
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
                ->select('tblData.data', 'tblData.timestamp')
                ->where('idCompany', '=', $user->idCompany)
                ->where('timestamp', '>=', $temp)
                ->where('tblSensor.typeData', '=', $typeData)
                ->where('tblGreenHouse.idGreenHouse', '=', $idGreenhouse)
                ->orderBy('tblData.timestamp')
                ->pluck('tblData.data', 'tblData.timestamp');
            return Controller::sendResponse(['valeur' => $data], 'Donnée Recuperer');
        }
        else {
                return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }

    }
    public function GetGraphYear($typeData,$idGreenhouse){

        $user = Auth::user();

        if (Controller::UserVerication($idGreenhouse) == true) {
            $data = DB::table('tblData')
                ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
                ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
                ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
                ->selectRaw('AVG(tblData.data) as valeur,MONTH(timestamp) as mois')
                ->where('idCompany' ,'=',$user->idCompany)
                ->where('timestamp', '>=', now()->subYears(1))
                ->where('tblSensor.typeData','=',$typeData)
                ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
                ->groupBy('mois')->get();
        }
        else {
            return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
        return Controller::sendResponse(['valeur' => $data ], 'Donnée Recuperer');
    }
    public function GetGraphMonth($typeData,$idGreenhouse){

        $user = Auth::user();
        if (Controller::UserVerication($idGreenhouse) == true) {
        $data = DB::table('tblData')
            ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->selectRaw('AVG(tblData.data) as Valeur,DAY(timestamp) as Jour')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('timestamp', '>=', now()->subMonths(1))
            ->where('tblSensor.typeData','=',$typeData)
            ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
            ->groupBy('Jour')->get();
        }
        else
        {
        return Controller::sendError('Access denied', ['error' => 'Access denied'], 401);
        }
        return Controller::sendResponse(['valeur' => $data ], 'Donnée Recuperer');
    }
}
