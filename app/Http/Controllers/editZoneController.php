<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class editZoneController extends Controller
{
    public function index(){
        return view('editZone');
    }

    public function update(Request $request, $idZone) {
        $idZone = $request->input('idZone');
        $name = $request->input('name');
        $description = $request->input('description');
        $typeFood = $request->input('typeFood');
        $idgreenhouse = $request->input('idGreenhouse');
        $img = $request->input('img');
        DB::update('UPDATE  tblZone SET name = ?, description = ?, typeFood = ?, img = ?, idCompany = ? where idZone = ? ',[$name, $description, $typeFood, $img, $idCompany, $idGreenhouse]);

        return redirect('/admin');
     }

     public function __invoke($idZone){

        $greenhouses = DB::select('select * from tblGreenhouse');
        $zones = DB::select('select * from tblZone WHERE idZone = :idZone', ['idZone' => $idZone]);
        return view('viewGreenhouse',['greenhouse' => $greenhouses, 'zone' => $zones]);
    }
}