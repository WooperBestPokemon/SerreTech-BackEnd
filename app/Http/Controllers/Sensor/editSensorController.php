<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\GreenHouse;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
         $data = DB::table('tblZone')
             ->leftjoin('tblGreenHouse','tblGreenHouse.idGreenHouse','=','tblZone.idGreenHouse')
             ->where('idCompany' ,'=',$user->idCompany)
             ->get();
         $zones = [] ;
         foreach($data as $data2) {
             array_push($zones, [
                 "idZone"=> $data2->idZone,
                 "name" => $data2->name,
                 "description" => $data2->description,
                 "img" => $data2->img,
                 "typeFood" => $data2->typeFood,
                 "idGreenHouse" => $data2->idGreenHouse
             ]);
         }



        $sensors = Sensor::find($idSensor);
        return view('editSensor',['sensors' => $sensors, 'zone' => $zones, 'user' => $user]);
    }
}
