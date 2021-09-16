<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addZoneController extends Controller
{
    public function index(){
        return view('addZone');
    }

    public function insert(Request $request){
        $name = $request->input('name');
        $description = $request->input('description');
        $typeFood = $request->input('typeFood');
        $idGreenhouse = $request->input('idGreenhouse');
        $img = $request->input('img');
        DB::insert('insert into tblZone (name, description, typeFood, idGreenhouse, img) values(?, ?, ?, ?, ?)',[$name, $description, $typeFood, $idGreenhouse, $img]);

        return redirect('/admin');
    }

    public function __invoke(){

        $greenhouses = DB::select('select * from tblGreenhouse');
        return view('addZone',['greenhouse' => $greenhouses]);
    }
}