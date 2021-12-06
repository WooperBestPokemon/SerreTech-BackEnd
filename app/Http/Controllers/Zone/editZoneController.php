<?php

namespace App\Http\Controllers\Zone;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class editZoneController extends Controller
{
    public function index(){
        return view('editZone');
    }

    public function update(Request $request, $idZone) {
        $data = Zone::find($idZone);
        $data->name = $request->input('name')?? $data->name;
        $data->description = $request->input('description')??$data->description;
        $data->typeFood = $request->input('typeFood')??$data->typeFood;
        $data->img = $request->input('img')??$data->img;
        $data->idGreenhouse = $request->input('idGreenhouse')??$data->idGreenhouse;
        $data->save();

        return redirect('/admin');
     }

     public function __invoke($idZone){
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
                 "name" => $data->getAttributes()["name"],
                 "description" => $data->getAttributes()["description"],
                 "img" => $data->getAttributes()["img"],
                 "idCompany" => $data->getAttributes()["idCompany"],
             ]);
         }

        $zones = Zone::find($idZone);
         $url = 'http://apipcst.xyz/api/searchAll/plant ';


         $response = file_get_contents($url);
         $newsData = json_decode($response);
        return view('editZone',['greenhouse' => $greenhouses, 'zones' => $zones,'allPlant' => $newsData,'user' => $users]);
    }
}
