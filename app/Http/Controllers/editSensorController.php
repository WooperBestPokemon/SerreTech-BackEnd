<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class editSensorController extends Controller
{
    public function index(){
        return view('editSensor');
    }

    public function update(Request $request, $idZone) {
        $idSensor = $request->input('idSensor');
        $name = $request->input('name');
        $description = $request->input('description');
        $typeData = $request->input('typeData');
        $idZone = $request->input('idZone');
        DB::update('UPDATE  tblSensor SET name = ?, description = ?, typeData = ?, idZone = ? where idSensor = ? ',[$name, $description, $typeData, $idZone, $idSensor]);

        return redirect('/admin');
     }

     public function __invoke($idSensor){

        $zones = DB::select('select * from tblZone');
        $sensors = DB::select('select * from tblSensor WHERE idSensor = :idSensor', ['idSensor' => $idSensor]);
        return view('editSensor',['sensor' => $sensors, 'zone' => $zones]);
    }
}