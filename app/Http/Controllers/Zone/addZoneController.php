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
            'typeFood'=>'required|int'
        ]);

        Zone::create([
            'name'=> $request->input('name'),
            'typeFood'=>$request->input('typeFood'),
            'idGreenHouse'=> $request->input('idGreenhouse'),
            'description'=> $request->input('description'),
            'img'=> $request->input('img'),
            'water'=> 0,
        ]);


        return redirect('/admin');
    }

    public function __invoke(){
        $user = Auth::user();
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
        $notif = Controller::getActiveNotification();
        return view('addZone',['allPlant' => $newsData, 'user' => $user, 'greenhouse' => $greenhouses, "notif" => $notif,"notifCount" => count($notif)]);
    }


}
