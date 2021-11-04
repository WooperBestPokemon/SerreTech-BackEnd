<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
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
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return Controller::sendResponse($success, 'User login successfully.');
        } else {
            return Controller::sendError('Unauthorised.', ['error' => 'Unauthorised', $request->all()]);
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
        $zones = [] ;
        foreach(Zone::where('idGreenHouse','=',$id)->get() as $zone) {
            array_push($zones, [
                "idZone" => $zone->getAttributes()["idZone"],
                "name" => $zone->getAttributes()["name"],
                "description" => $zone->getAttributes()["description"],
                "img" => $zone->getAttributes()["img"],
                "typeFood" => $zone->getAttributes()["typeFood"],
                "idGreenHouse" => $zone->getAttributes()["idGreenHouse"],
                "luminosite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'luminosite',false),
                "humidite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite',false),
                "humidite_sol" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite sol',false),
                "temperature" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'temperature',false),
            ]);
        }
        if($zones == null){
            return Controller::sendError('Server Error', ['error' => 'Zone not found'],500);
        }
        return Controller::sendResponse(['zone' => $zones ], 'Donnée Recuperer');

    }

    public function ViewSensor($id){

        $sensors = [] ;
        foreach(Sensor::where('idZone','=',$id)->get() as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->getAttributes()["idSensor"],
                "name" => $sensor->getAttributes()["name"],
                "description" => $sensor->getAttributes()["description"],
                "typeData" => $sensor->getAttributes()["typeData"],
                "idZone" => $sensor->getAttributes()["idZone"],
                "data"=>apiController::GetDataLastDay($sensor->getAttributes()["idSensor"],false),
            ]);
        }
        //if($sensors == null){
        //    return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
        //}
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donnée Recuperer');

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
                "luminosite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'luminosite',false),
                "humidite" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite',false),
                "humidite_sol" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'humidite sol',false),
                "temperature" => apiController::GetAvgDataGreenhouse($greenhouse->getAttributes()["idGreenHouse"], 'temperature',false),
            ]);
        }

        if($greenhouses == null){
            return Controller::sendError('Server Error', ['error' => 'Greenhouse not found'],500);
        }
        return Controller::sendResponse(['greenhouse' => $greenhouses ], 'Donnée Recuperer');

    }

    public function SearchZone($id)
    {
        $zones = [] ;
        foreach(Zone::where('idZone','=',$id)->get() as $zone) {
            array_push($zones, [
                "idZone" => $zone->getAttributes()["idZone"],
                "name" => $zone->getAttributes()["name"],
                "description" => $zone->getAttributes()["description"],
                "img" => $zone->getAttributes()["img"],
                "typeFood" => $zone->getAttributes()["typeFood"],
                "idZone" => $zone->getAttributes()["idZone"],
                "luminosite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'luminosite',false),
                "humidite" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite',false),
                "humidite_sol" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'humidite sol',false),
                "temperature" => apiController::GetAvgDataZone($zone->getAttributes()["idZone"], 'temperature',false),
            ]);
        }
        if($zones == null){
            return Controller::sendError('Server Error', ['error' => 'Zone not found'],500);
        }
        return Controller::sendResponse(['zone' => $zones ], 'Donnée Recuperer');

    }

    public function SearchSensor($id){

        $sensors = [] ;
        foreach(Sensor::where('idSensor','=',$id)->get() as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->getAttributes()["idSensor"],
                "name" => $sensor->getAttributes()["name"],
                "description" => $sensor->getAttributes()["description"],
                "typeData" => $sensor->getAttributes()["typeData"],
                "idZone" => $sensor->getAttributes()["idZone"],
                "data"=>apiController::GetDataLastDay($sensor->getAttributes()["idSensor"],false),
            ]);
        }
        //if($sensors == null){
        //    return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
        //}
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donnée Recuperer');

    }

    public function GetDataLastDay($idSensor,$json = true)
    {
        $datas = [];

        $datas = DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 DAY AND idSensor = :idSensor', ['idSensor' => $idSensor]);

        if($json == true){
            return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
        }
        else{
            if($datas != null){
                return $datas[0]->data;
            }

        }

    }

    public function GetDataLastWeek($idSensor)
    {
        $datas = [];

        $datas = DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 WEEK AND idSensor = :idSensor', ['idSensor' => $idSensor]);

        return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
    }

    public function GetDataLastMonth($idSensor)
    {
        $datas = [];

        $datas = DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 MONTH AND idSensor = :idSensor', ['idSensor' => $idSensor]);

        return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
    }

    public function GetDataLastYear($idSensor)
    {
        $datas = [];

        $datas = DB::select('select data, timestamp, idSensor from tblData where timestamp>=NOW()- INTERVAL 1 YEAR AND idSensor = :idSensor', ['idSensor' => $idSensor]);


        return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
    }

    public function GetAvgDataGreenhouse($idGreenHouse, $typedata,$json = true)
    {
        $datas = [];

        $datas = DB::select('SELECT AVG(tt.data) as data

     

        FROM tblData tt
        INNER JOIN
            (SELECT idSensor, MAX(timestamp) as MaxDateTime
            FROM tblData
            GROUP BY idSensor) groupedtt
        ON tt.idSensor = groupedtt.idSensor
        AND tt.timestamp = groupedtt.MaxDateTime WHERE tt.idSensor IN
        (SELECT idSensor FROM tblSensor WHERE typeData = :typedata AND idZone IN
        (SELECT idZone FROM tblZone WHERE idGreenHouse IN
        (SELECT idGreenHouse FROM tblGreenHouse WHERE idGreenHouse = :idGreenHouse)))',
           ['typedata' => $typedata, 'idGreenHouse' => $idGreenHouse]);
        if($json == true){
            return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
        }
        else{
            return $datas[0]->data;
        }
    }
    public function GetAvgDataZone($idZone, $typedata,$json = true)
    {
        $datas = [];

        $datas = DB::select('SELECT AVG(tt.data) as data
        FROM tblData tt
        INNER JOIN
            (SELECT idSensor, MAX(timestamp) as MaxDateTime
            FROM tblData
            GROUP BY idSensor) groupedtt
        ON tt.idSensor = groupedtt.idSensor
        AND tt.timestamp = groupedtt.MaxDateTime WHERE tt.idSensor IN
        (SELECT idSensor FROM tblSensor WHERE typeData = :typedata AND idZone IN
        (SELECT idZone FROM tblZone WHERE idZone = :idZone))',
        ['typedata' => $typedata, 'idZone' => $idZone]);
        if($json == true){
            return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
        }
        else{
            return $datas[0]->data;
        }
    }
    //Posting data in database
    public function postData(Request $request){
        $user = Auth::user();
        try {
            //Getting the ID of the company
            $company = DB::table('tblGreenHouse')
                ->leftjoin('tblZone','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
                ->leftjoin('tblSensor','tblZone.idZone','=','tblSensor.idZone')
                ->select('tblGreenHouse.idCompany')
                ->where('tblSensor.idSensor','=',$request['sensor'])
                ->pluck('idCompany');


            if($company[0] == $user['idCompany']){
                //The captor is owned by the company, so it's good
                $data = new Data;

                $data->data = $request['data'];
                $data->idSensor = $request['sensor'];
                $data->save();

                $response = 'Accepted';
                return response($response, 201);
            }
            else{
                //Not owned by the company
                $response = 'This captor is not owned by the company';
                return response($response, 401);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            $response = 'An error occurred';
            return response($response, 400);
        }
    }

    //Returning if you need to water the plant or not
    public function getWater(Request $request, $idZone){

        //todo - Api call to check how much water the zone need

        $user = Auth::user();
        try{
            $zone = Zone::find($idZone);
            //Getting the ID of the company
            $company = DB::table('tblGreenHouse')
                ->leftjoin('tblZone','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
                ->select('tblGreenHouse.idCompany')
                ->where('tblZone.idZone','=',$idZone)
                ->pluck('idCompany');

            if($company[0] == $user['idCompany']){

                //The zone is owned by the company, so it's good
                $response = [
                    'water' => $zone->water,
                    'quantity' => 300
                ];

                //update the water to false
                if($zone->water == 0){
                    $zone->water = 1;
                    $zone->save();
                }


                return response($response, 201);
            }
            else{
                //Not owned by the company
                $response = 'This captor is not owned by the company';
                return response($response, 401);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            $response = 'An error occurred';
            return response($response, 400);
        }
    }
    //Returning if you need to water the plant or not

}
