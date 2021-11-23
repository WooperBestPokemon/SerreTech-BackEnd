<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class gestionController extends Controller
{
    public function index(){
        return view('gestion');
    }

    public function __invoke(){

        $greenhouses = [] ;
        foreach(GreenHouse::all() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
            ]);
        }
            $zones = [] ;
        foreach(Zone::all() as $zone) {
            array_push($zones, [
                "idZone"=> $zone->getAttributes()["idZone"],
                "name" => $zone->getAttributes()["name"],
                "description" => $zone->getAttributes()["description"],
                "img" => $zone->getAttributes()["img"],
                "typeFood" => $this->getplant($zone->getAttributes()["typeFood"]),
                "idGreenHouse" => $zone->getAttributes()["idGreenHouse"]
            ]);
        }
        $sensors = [] ;
        foreach(Sensor::all() as $sensor) {
            array_push($sensors, [
                "idSensor" =>$sensor->getAttributes()["idSensor"],
                "name" => $sensor->getAttributes()["name"],
                "description" => $sensor->getAttributes()["description"],
                "typeData" => $sensor->getAttributes()["typeData"],
                "idZone" => $sensor->getAttributes()["idZone"]
            ]);
        }
        return view('viewGestion',['greenhouse' => $greenhouses, 'zone' => $zones, 'sensor' => $sensors]);
    }


}
