<?php

namespace App\Http\Controllers\Zone;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class addZoneController extends Controller
{
    public function index(){
        return view('addZone');
    }

    public function insert(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'typeFood'=>'required|string'
        ]);

        Zone::create([
            'name'=> $request->input('name'),
            'typeFood'=>$request->input('typeFood'),
            'idGreenHouse'=> 2,
            'description'=> $request->input('description'),
            'img'=> $request->input('img'),
            'water'=> 0,
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
                 "name" => $data->getAttributes()["name"],
                 "description" => $data->getAttributes()["description"],
                 "img" => $data->getAttributes()["img"],
                 "idCompany" => $data->getAttributes()["idCompany"],
             ]);
         }


        $url = 'http://apipcst.xyz/api/searchAll/plant ';
        $response = file_get_contents($url);
        $newsData = json_decode($response);
        return view('addZone',['allPlant' => $newsData, 'user' => $users, 'greenhouse' => $greenhouses]);
    }


}
