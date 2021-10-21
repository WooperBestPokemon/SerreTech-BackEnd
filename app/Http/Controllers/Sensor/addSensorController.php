<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addSensorController extends Controller
{
    public function index(){
        return view('addSensor');
    }

    public function insert(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'typeData'=>'required'
        ]);
        Sensor::create([
            'name'=> $request->input('name'),
            'idZone'=> 1,
            'description'=> $request->input('description'),
            'typeData'=> $request->input('typeData'),
            actif => 0
        ]);

        return redirect('/admin');
    }

    public function __invoke(){

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
        return view('addSensor',['zone' => $zones]);
    }
}
