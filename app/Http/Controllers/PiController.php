<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Notification;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class PiController extends Controller
{
    // fonction de test
    public function testdejonnhytest(Request $request){
        $request['veggie'];
        $url = 'http://apipcst.xyz/api/searchAll/plant';
        $response = file_get_contents($url);
        //$newsData = json_decode($response, true);
        $test = collect(json_decode($response, true));

        //$test1 = $test->where('id',1)->data;
        dd($test);
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

            // Verify if data sent is in a correct humidity (Sensor : 4)

            // Temperature Test
            // Verify if data sent is in a correct temperature (Sensor : 1)
            if($typeData[0] == "temperature"){

                $notification = Notification::find($data['idSensor']);
                $status = $notification->alerteStatus;

                //Status 0 = Problem
                //Status 1 = idle

                // Look if there is a fire or ice
                if($data['data'] <  $veggie_data["favorableConditions"][0]["min"] || $data['data'] >  $veggie_data["favorableConditions"][0]["max"]){
                    // Update the database if something has changed
                        //Ice
                    if($data['data'] <  $veggie_data["favorableConditions"][0]["min"]){
                        $notification->description = 'The air is too cold';
                        $notification->alerteStatus = 0;
                        $notification->save();
                    }
                    //Fire
                    else{
                        $notification->description = 'The air is too hot';
                        $notification->alerteStatus = 0;
                        $notification->save();
                    }
                }
                // No problem
                else{
                    //Previously problematic
                    if($status == 0){
                        $notification->description = 'Everything is fine';
                        $notification->alerteStatus = 1;
                        $notification->save();
                    }
                }
            }
            elseif($typeData[0] == "humidite sol"){

                $notification = Notification::find($data['idSensor']);
                $status = $notification->alerteStatus;

                //Status 0 = Problem
                //Status 1 = idle

                if($data['data'] <  $veggie_data["favorableConditions"][1]["min"] || $data['data'] >  $veggie_data["favorableConditions"][1]["max"]){
                    //Dry
                    if($data['data'] <  $veggie_data["favorableConditions"][1]["min"]){
                        $notification->description = 'The ground is too dry';
                        $notification->alerteStatus = 0;
                        $notification->save();
                    }
                    //Wet
                    else{
                        $notification->description = 'The ground is too wet';
                        $notification->alerteStatus = 0;
                        $notification->save();
                    }
                }
                // No problem
                else{
                    //Previously problematic
                    if($status == 0){
                        $notification->description = 'Everything is fine';
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
