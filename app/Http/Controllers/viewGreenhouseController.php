<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\support\facades\auth;


class viewGreenhouseController extends Controller
{
    public function __invoke($idGreenhouse){

        $greenhouses = DB::select('select * from tblGreenhouse WHERE idGreenhouse = :idGreenhouse', ['idGreenhouse' => $idGreenhouse]);
        $zones = DB::select('select * from tblZone WHERE idGreenhouse = :idGreenhouse', ['idGreenhouse' => $idGreenhouse]);
        return view('viewGreenhouse',['greenhouse' => $greenhouses, 'zone' => $zones]);
    }
}
