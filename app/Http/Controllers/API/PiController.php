<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Notification;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Not;
use Psy\Util\Json;

class PiController extends Controller
{
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
                $this->VerifyData($data);
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

    // Verify data before post and create a notification if data is too high/too low
    public function VerifyData($data){
        try {
            //Status 0 = Problem
            //Status 1 = idle

            // Permet de trouver l'id de la plante qui correspond à le typeFood dans la BD
            $veggie = DB::table('tblZone')
                ->join('tblSensor','tblZone.idZone','=','tblSensor.idZone')
                ->select('tblZone.typeFood')
                ->where('tblSensor.idSensor','=',$data['idSensor'])
                ->pluck('typeFood');

            // Va chercher le package contenant les informations de la plante dont on a besoin
            $url = 'http://apipcst.xyz/api/search/package/'.$veggie[0];

            // Va chercher la plante
            $response = file_get_contents($url);
            $veggie_data = json_decode($response, true);

            // Looking for the sensor if it is the one of temperature
            $typeData = DB::table('tblSensor')
            ->select('tblSensor.typeData')
            ->where('tblSensor.idSensor','=',$data['idSensor'])
            ->pluck('typeData');

            // Look for the latest notification
            $notification = Notification::find($data['idSensor']);
            if($notification != null) {
                $notification = $notification->latest()->first();
                $status = $notification->alerteStatus;
            }
            else{
                $status = 1;
            }
            if($status == 0){
                if($typeData[0] == "temperature" && ($data['data'] > $veggie_data["favorableConditions"][0]["min"] && $data['data'] < $veggie_data["favorableConditions"][0]["max"])) {
                        $notification->alerteStatus = 1;
                        $notification->save();
                }
                else if($typeData[0] == "humidite sol" && ($data['data'] > $veggie_data["favorableConditions"][1]["min"] && $data['data'] < $veggie_data["favorableConditions"][1]["max"])) {
                        $notification->alerteStatus = 1;
                        $notification->save();
                }
            }
            // Temperature Test
            // Verify if data sent is in a correct temperature
            else if($typeData[0] == "temperature"){

                if($data['data'] < $veggie_data["favorableConditions"][0]["min"]){
                    Notification::create([
                        "idSensor"=>$data["idSensor"],
                        "description"=>"The air is too cold",
                        "alerteStatus"=> 0
                    ]);
                }
                else if($data['data'] > $veggie_data["favorableConditions"][0]["max"]){
                    Notification::create([
                        "idSensor"=>$data["idSensor"],
                        "description"=>"The air is too hot",
                        "alerteStatus"=> 0
                    ]);
                }
            }
            // Humidity Test
            // Verify if data sent is in a correct humidity for the ground
            else if($typeData[0] == "humidite sol"){

                if($data['data'] < $veggie_data["favorableConditions"][1]["min"] || $data['data'] > $veggie_data["favorableConditions"][1]["max"]){
                    //Dry
                    if($data['data'] < $veggie_data["favorableConditions"][1]["min"]){
                        Notification::create([
                            "idSensor"=>$data["idSensor"],
                            "description"=>"The ground is too dry",
                            "alerteStatus"=> 0
                        ]);
                    }
                    //Wet
                    else{
                        Notification::create([
                            "idSensor"=>$data["idSensor"],
                            "description"=>"The ground is too wet",
                            "alerteStatus"=> 0
                        ]);
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
    public function setWater(Request $request, $idZone){

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

                //update the water to true
                $zone->water = 0;
                $zone->save();


                return response('Accepted', 201);
            }
            else{
                //Not owned by the company
                $response = 'This zone is not owned by the company';
                return response($response, 401);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            $response = 'An error occurred';
            return response($response, 400);
        }
    }
}
