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
        $zones = DB::select('select * from tblZone');
        $sensors = DB::select('select * from tblSensor');
        return view('viewGestion',['greenhouse' => $greenhouses, 'zone' => $zones, 'sensor' => $sensors]);
    }
}