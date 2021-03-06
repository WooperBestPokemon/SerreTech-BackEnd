<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class gestionController extends Controller
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
                    "typeFood" => Controller::NamePlant($zone->getAttributes()["typeFood"]),
                    "idGreenHouse" => $zone->getAttributes()["idGreenHouse"]
                ]);

            }
        }
        $sensors = [] ;
        foreach($zones as $zone) {
            foreach (Sensor::where('idZone', '=', $zone['idZone'])->get() as $sensor) {
                array_push($sensors, [
                    "idSensor" => $sensor->getAttributes()["idSensor"],
                    "name" => $sensor->getAttributes()["name"],
                    "description" => $sensor->getAttributes()["description"],
                    "typeData" => $sensor->getAttributes()["typeData"],
                    "idZone" => $sensor->getAttributes()["idZone"]
                ]);
            }
        }
        $notif = Controller::getActiveNotification();
        return view('viewGestion',['greenhouse' => $greenhouses, 'zone' => $zones, 'sensor' => $sensors, 'user' => $user, "notif" => $notif,"notifCount" => count($notif)]);
    }


    public function employe(){
        $user = Auth::user();
        $employes = [] ;
        foreach(User::where('idCompany','=',$user->idCompany)->get() as $employe) {
            array_push($employes, [
                "idProfile" =>$employe->getAttributes()["idProfile"],
                "name" =>$employe->getAttributes()["name"],
                "email" =>$employe->getAttributes()["email"],
                "role" =>$employe->getAttributes()["role"],
                "idCompany" =>$employe->getAttributes()["idCompany"],
            ]);
        }
        $notif = Controller::getActiveNotification();
        return view('viewEmploye',['user' => $user, 'employe' => $employes, "notif" => $notif,"notifCount" => count($notif)]);
    }

    public function indexWelcome(){
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
                "permission" =>$user->getAttributes()["permission"]
            ]);
        }


        return view('welcome',['user' => $users]);
    }
}
