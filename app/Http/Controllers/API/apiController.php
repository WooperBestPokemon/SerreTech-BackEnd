<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Laravel\Passport\Token;
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
        foreach(Zone::find($id) as $zone) {
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

    public function SearchSensor($id){

        $sensors = [] ;
        foreach(Sensor::where('idSensor','=',$id)->get() as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->getAttributes()["idSensor"],
                "name" => $sensor->getAttributes()["name"],
                "description" => $sensor->getAttributes()["description"],
                "typeData" => $sensor->getAttributes()["typeData"],
                "idZone" => $sensor->getAttributes()["idZone"],
                "data"=>apiController::GetAvgDataSensor($sensor->getAttributes()["idSensor"]),
            ]);
        }
        //if($sensors == null){
        //    return Controller::sendError('Server Error', ['error' => 'Sensor not Found'],500);
        //}
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donnée Recuperer');

    }

    public function GetDataLastDay($idSensor)
    {
        $datas = [];
        $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subDays(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)
            ->pluck('data','timestamp');

            return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');

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
        $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subWeeks(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)->get();
            //->pluck('data','timestamp');
        //$datas = DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 WEEK AND idSensor = :idSensor', ['idSensor' => $idSensor]);

        return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
    }

    public function GetDataLastMonth($idSensor)
    {
        $datas = [];


        $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subMonths(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)->get();
            //->pluck('data','timestamp');
        //DB::select('select data, timestamp, idSensor from tblData where timestamp>= NOW()- INTERVAL 1 MONTH AND idSensor = :idSensor', ['idSensor' => $idSensor]);

        return Controller::sendResponse(['data' => $datas ], 'Donnée Recuperer');
    }

    public function GetDataLastYear($idSensor)
    {
        $datas = [];

        $datas = DB::table('tblData')
            ->select('data','timestamp','idSensor')
            ->where('timestamp', '>=', now()->subYears(1))
            ->where('timestamp', '<=', now())
            ->where('idSensor' ,'=',$idSensor)->get();
            //->pluck('data','timestamp');

            //DB::select('select data, timestamp, idSensor from tblData where timestamp>=NOW()- INTERVAL 1 YEAR AND idSensor = :idSensor', ['idSensor' => $idSensor]);


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
    public function GetSensorsGreenhouse($idGreenhouse){
        $user = Auth::user();
        $data = DB::table('tblSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->select('tblSensor.idSensor','tblSensor.name','tblSensor.description','tblSensor.typeData','tblSensor.idZone','tblGreenHouse.idGreenHouse')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('tblGreenHouse.idGreenHouse','=',$idGreenhouse)
            ->get();

        $sensors = [] ;
        foreach($data as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->idSensor,
                "name" => $sensor->name,
                "description" => $sensor->description,
                "typeData" => $sensor->typeData,
                "idZone" => $sensor->idZone,
                "idGreenhouse"=>$sensor->idGreenHouse,
                "data"=>apiController::GetAvgDataSensor($sensor->idSensor,false),
            ]);
        }
        return Controller::sendResponse(['sensors' => $sensors ], 'Donnée Recuperer');
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
                "description" => $sensor->description,
                "typeData" => $sensor->typeData,
                "idZone" => $sensor->idZone,
                "data"=>apiController::GetAvgDataSensor($sensor->idSensor,false),
            ]);
        }
        return Controller::sendResponse(['sensors' => $sensors ], 'Donnée Recuperer');
    }

    // code Graph
    public function GetGraph($typeData,$idGreenhouse,$temps){
        if($temps == 1) $temp = now()->subHour(1);
        if($temps == 2) $temp = now()->subday(1);
        if($temps == 3)$temp = now()->subWeeks(1);
        $user = Auth::user();
        $data = DB::table('tblData')
            ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->select('tblData.data','tblData.timestamp')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('timestamp', '>=', $temp)
            ->where('tblSensor.typeData','=',$typeData)
            ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
            ->orderBy('tblData.timestamp')
            ->pluck('tblData.data','tblData.timestamp');

        return Controller::sendResponse(['valeur' => $data ], 'Donnée Recuperer');
    }
    public function GetGraphYear($typeData,$idGreenhouse){

        $user = Auth::user();

            $data = DB::table('tblData')
                ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
                ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
                ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
                ->selectRaw('AVG(tblData.data) as valeur,MONTH(timestamp) as mois')
                ->where('idCompany' ,'=',$user->idCompany)
                ->where('timestamp', '>=', now()->subYear(1))
                ->where('tblSensor.typeData','=',$typeData)
                ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
                ->groupBy('mois')->get();


        return Controller::sendResponse(['valeur' => $data ], 'Donnée Recuperer');
    }
    public function GetGraphMonth($typeData,$idGreenhouse){

        $user = Auth::user();

        $data = DB::table('tblData')
            ->leftjoin('tblSensor','tblData.idSensor','=','tblSensor.idSensor')
            ->leftjoin('tblZone','tblZone.idZone','=','tblSensor.idZone')
            ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
            ->selectRaw('AVG(tblData.data) as Valeur,DAY(timestamp) as Jour')
            ->where('idCompany' ,'=',$user->idCompany)
            ->where('timestamp', '>=', now()->subMonth(1))
            ->where('tblSensor.typeData','=',$typeData)
            ->where('tblGreenHouse.idGreenHouse' ,'=',$idGreenhouse)
            ->groupBy('Jour')->get();


        return Controller::sendResponse(['valeur' => $data ], 'Donnée Recuperer');
    }
    //--Code test jacob

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
                //$this->VerifyData($data);
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
            return response($ex, 400);
        }
    }

    public function VerifyData($data){

        try {

            // Looking for the sensor if it is the one of temperature
            $typeData = DB::table('tblSensor')
            ->select('tblSensor.typeData')
            ->where('tblSensor.idSensor','=',$data['sensor'])
            ->pluck('typeData');

            // Verify if data sent is in a correct temperature
            if($typeData[0] == "humidite sol"){

                $notification = Notification::find($id);
                $status = $notification->alerteStatus;

                //Status 0 = On Fire
                //Status 1 = idle

                // Look if there is a fire
                if($data > 50){
                    // Update the database if something has changed
                    if($status == 1){
                        $notification->description = '7.8/10 too much water -IGN';
                        $notification->alerteStatus = 0;
                        $notification->save();
                    }         
                }
                // No fire
                else{
                    //Previously on fire
                    if($status == 0){
                        $notification->description = 'Everything is fine :)';
                        $notification->alerteStatus = 1;
                        $notification->save();
                    }
                }        
            } 
        }
        catch(\Illuminate\Database\QueryException $ex){
            // Return the exception and the error 
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
                   
            if($company[0] == $user->idCompany){
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

        public function getuser (Request $request){

            $user = Auth::user();
            dd($user);
        }
    //Returning if you need to water the plant or not
 
}
