<?php

namespace App\Http\Controllers\Zone;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

         $greenhouses = [] ;
         foreach(GreenHouse::all() as $data) {
             array_push($greenhouses, [
                 "idGreenHouse" => $data->getAttributes()["idGreenHouse"],
                 "name" => $data->getAttributes()["name"],
                 "description" => $data->getAttributes()["description"],
                 "img" => $data->getAttributes()["img"],
             ]);
         }
        $zones = Zone::find($idZone);
         $url = 'http://api.pcst.xyz/api/searchAll/plant ';


         $response = file_get_contents($url);
         $newsData = json_decode($response);
        return view('editZone',['greenhouse' => $greenhouses, 'zones' => $zones,'allPlant' => $newsData]);
    }
}
