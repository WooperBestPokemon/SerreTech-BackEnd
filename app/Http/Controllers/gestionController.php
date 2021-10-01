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
        foreach(GreenHouse::all() as $data) {
            array_push($greenhouses, [
                "idGreenHouse" => $data->getAttributes()["idGreenHouse"],
                "name" => $data->getAttributes()["name"],
                "description" => $data->getAttributes()["description"],
                "img" => $data->getAttributes()["img"],
            ]);
        }
            $zones = [] ;
        foreach(Zone::all() as $data2) {
            array_push($zones, [
                "idZone"=> $data2->getAttributes()["idZone"],
                "name" => $data2->getAttributes()["name"],
                "description" => $data2->getAttributes()["description"],
                "img" => $data2->getAttributes()["img"],
                "typeFood" => $data2->getAttributes()["typeFood"],
                "idGreenHouse" => $data2->getAttributes()["idGreenhouse"]
            ]);
        }
        $sensors = [] ;
        foreach(Sensor::all() as $data3) {
            array_push($sensors, [
                "idSensor" =>$data3->getAttributes()["idSensor"],
                "name" => $data3->getAttributes()["name"],
                "description" => $data3->getAttributes()["description"],
                "typeData" => $data3->getAttributes()["typeData"],
                "idZone" => $data3->getAttributes()["idZone"]
            ]);
        }



        return view('viewGestion',['greenhouse' => $greenhouses, 'zone' => $zones, 'sensor' => $sensors]);
    }
}
