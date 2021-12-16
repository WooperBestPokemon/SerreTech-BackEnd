<?php

namespace App\Http\Controllers;

use App\Models\GreenHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class viewGreenhouse extends Controller
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
        return view('listGreenhouse',['greenhouse' => $greenhouses, 'user' => $user]);
    }
}
