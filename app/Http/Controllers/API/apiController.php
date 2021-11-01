<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return Controller::sendError('Unauthorised.', ['error' => 'Unauthorised','user'=> $request->email]);
        }
    }

    public function ViewGreenHouses()
    {
        $greenhouses = [];
        foreach (GreenHouse::all() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
                'alerte'=> ['alerte'=> true, 'message' => 'Trop chaud']
            ]);
        }

        return Controller::sendResponse(['GreenHouse' =>$greenhouses], 'Donnée Recuperer');

    }

    public function ViewZones($id)
    {
        $zones = [] ;
        foreach(Zone::where('idGreenHouse','=',$id)->get() as $zone) {
            array_push($zones, [
                "idZone" => $zone->getAttributes()["idZone"],
                "name" => $zone->getAttributes()["name"],
                "description" => $zone->getAttributes()["description"],
                "img" => $zone->getAttributes()["img"],
                "typeFood" => $zone->getAttributes()["typeFood"],
                "idGreenHouse" => $zone->getAttributes()["idGreenhouse"]
            ]);
        }
        if($zones == null){
            return Controller::sendError('Server Error', ['error' => 'Zone not found'],500);
        }
        return Controller::sendResponse(['zone' => $zones ], 'Donnée Recuperer');

    }

    public function ViewSensors($id){

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
        return Controller::sendResponse(['sensors' => $sensors,'id'=> $id ], 'Donnée Recuperer');

    }


}

