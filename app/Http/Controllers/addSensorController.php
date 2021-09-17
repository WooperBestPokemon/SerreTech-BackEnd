<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addSensorController extends Controller
{
    public function index(){
        return view('addSensor');
    }

    public function insert(Request $request){
        $name = $request->input('name');
        $description = $request->input('description');
        $typeData = $request->input('typeData');
        $idZone = $request->input('idZone');
        DB::insert('insert into tblSensor (name, description, typeData, idZone) values(?, ?, ?, ?)',[$name, $description, $typeData, $idZone]);

        return redirect('/admin');
    }

    public function __invoke(){

        $zones = DB::select('select * from tblZone');
        return view('addSensor',['zone' => $zones]);
    }
}