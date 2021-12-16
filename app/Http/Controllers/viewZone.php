<?php

namespace App\Http\Controllers;

use App\Models\GreenHouse;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class viewZone extends Controller
{
    public function index(){
        $user = Auth::user();



        return view('gestion',['user' => $user]);
    }
    public function __invoke(){

        $user = Auth::user();

        $greenhouses = [] ;
        foreach(GreenHouse::where('idCompany','=',$user->idCompany)->get() as $greenhouse) {
            array_push($greenhouses, [
                "idGreenHouse" => $greenhouse->getAttributes()["idGreenHouse"],
                "name" => $greenhouse->getAttributes()["name"],
                "description" => $greenhouse->getAttributes()["description"],
                "img" => $greenhouse->getAttributes()["img"],
                "idCompany" => $greenhouse->getAttributes()["idCompany"],
            ]);
        }
        $zones = [] ;
        foreach ($greenhouses as $greenhouse)
        {
            foreach(Zone::where('idGreenHouse','=',$greenhouse['idGreenHouse'])->get() as $zone) {
                array_push($zones, [
                    "idZone"=> $zone->getAttributes()["idZone"],
                    "name" => $zone->getAttributes()["name"],
                    "description" => $zone->getAttributes()["description"],
                    "img" => $zone->getAttributes()["img"],
                    "typeFood" => Controller::NamePlant($zone->getAttributes()["idZone"]),
                    "idGreenHouse" => $zone->getAttributes()["idGreenHouse"]
                ]);

            }
        }
        return view('listZone',['greenhouse' => $greenhouses, 'zone' => $zones, 'user' => $user]);
    }
}
