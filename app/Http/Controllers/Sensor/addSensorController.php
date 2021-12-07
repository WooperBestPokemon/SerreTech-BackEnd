<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\Zone;
use App\Models\GreenHouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class addSensorController extends Controller
{

    public function insert(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'typeData'=>'required'
        ]);
        Sensor::create([
            'name'=> $request->input('name'),
            'idZone'=> $request->input('idZone'),
            'description'=> $request->input('description'),
            'typeData'=> $request->input('typeData'),
            'actif' => 0
        ]);

        return redirect('/admin');
    }

    public function __invoke(){
        $user = Auth::user();
        $idCompany = $user['idCompany'];

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
        return view('addSensor',['zone' => $zones, 'user' => $user]);
    }
}
