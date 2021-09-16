<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class gestionController extends Controller
{
    public function index(){
        return view('gestion');
    }

    public function __invoke(){

        $greenhouses = DB::select('select * from tblGreenhouse');

        $zones = DB::select('SELECT g.*, z.name AS nameGreenhouse
        FROM tblZone AS g
        JOIN tblGreenhouse AS z ON g.idGreenhouse = z.idGreenhouse');

        $sensors = DB::select('SELECT g.*, z.name AS nameZone
        FROM tblSensor AS g
        JOIN tblZone AS z ON g.idZone = z.idZone;');

        return view('viewGestion',['greenhouse' => $greenhouses, 'zone' => $zones, 'sensor' => $sensors]);
    }
}