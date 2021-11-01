<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\GreenHouse;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

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
        $greenhouses = [];
        foreach (GreenHouse::all() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
            ]);
        }

        return Controller::sendResponse($greenhouses, 'Donnée Recuperer');

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
                "idGreenHouse" => $zone->getAttributes()["idGreenhouse"]
            ]);
        }
        return Controller::sendResponse($zones, 'Donnée Recuperer');

    }
    //Posting data in database
    public function postData(Request $request){
        $data = new Data;

        $data->data = $request['data'];
        $data->idSensor = $request['sensor'];

        $data->save();

        $response = 'Accepted';
        return response($response, 201);
    }
    //Returning if you need to water the plant or not
    public function getWater(Request $request){
        $idZone = $request['zone'];
        $zone = Zone::find($idZone);

        //todo - Api call to check how much water the zone need

        $response = [
            'water' => $zone->water,
            'quantity' => 100
        ];

        return response($response, 201);
    }
}
