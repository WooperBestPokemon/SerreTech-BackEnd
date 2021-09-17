<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\support\facades\auth;


class viewZoneController extends Controller
{
    public function __invoke($idZone){

        $zones = DB::select('select * from tblZone WHERE idZone = :idZone', ['idZone' => $idZone]);
        $sensors = DB::select('select * from tblSensor WHERE idZone = :idZone', ['idZone' => $idZone]);
        return view('viewZone',['zone' => $zones, 'sensor' => $sensors]);
    }
}
