<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class editSensorController extends Controller
{
    public function index(){
        return view('editSensor');
    }

    public function update(Request $request, $idSensor) {

        $data = Sensor::find($idSensor);
        $data->name = $request->input('name')?? $data->name;
        $data->description = $request->input('description')??$data->description;
        $data->typeData = $request->input('typeData')??$data->typeData;
        $data->idZone = $request->input('idZone')??$data->idZone;
        $data->actif = 0;
        $data->save();
        return redirect('/admin');
     }

     public function __invoke($idSensor){

        $sensors = Sensor::find($idSensor);
         $zones = [] ;
         foreach(Zone::all() as $data2) {
             array_push($zones, [
                 "idZone"=> $data2->getAttributes()["idZone"],
                 "name" => $data2->getAttributes()["name"],
             ]);
         }
        return view('editSensor',['sensors' => $sensors, 'zone' => $zones]);
    }
}
