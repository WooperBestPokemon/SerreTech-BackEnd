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
            'actif' => 0
        ]);

        return redirect('/admin');
    }

    public function __invoke(){
        $user = Auth::user();
        $idProfile = Auth::id();
        $users = [] ;
        foreach(User::where('idProfile','=',$idProfile)->get() as $user) {
            array_push($users, [
                "idProfile" =>$user->getAttributes()["idProfile"],
                "name" =>$user->getAttributes()["name"],
                "email" =>$user->getAttributes()["email"],
                "role" =>$user->getAttributes()["role"],
                "idCompany" =>$user->getAttributes()["idCompany"],
                "permission" =>$user->getAttributes()["permission"],
            ]);
        }
        $idCompany = $user['idCompany'];

        $greenhouses = [] ;
         foreach(GreenHouse::where('idCompany','=',$idCompany)->get() as $data) {
             array_push($greenhouses, [
                 "idGreenHouse" => $data->getAttributes()["idGreenHouse"],
             ]);
         }



        $zones = [] ;
        foreach(Zone::whereIN('idGreenHouse', $greenhouses)->get() as $data2) {
            array_push($zones, [
                "idZone"=> $data2->getAttributes()["idZone"],
                "name" => $data2->getAttributes()["name"],
                "description" => $data2->getAttributes()["description"],
                "img" => $data2->getAttributes()["img"],
                "typeFood" => $data2->getAttributes()["typeFood"],
                "idGreenHouse" => $data2->getAttributes()["idGreenHouse"]
            ]);
        }
        return view('addSensor',['zone' => $zones, 'user' => $users]);
    }
}
