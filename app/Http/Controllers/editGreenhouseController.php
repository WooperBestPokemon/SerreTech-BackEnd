<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class editGreenhouseController extends Controller
{
    public function index(){
        return view('addGreenhouse');
    }

    public function update(Request $request, $idGreenhouse) {
        $idGreenhouse = $request->input('idGreenhouse');
        $name = $request->input('name');
        $description = $request->input('description');
        $idCompany = $request->input('idCompany');
        $img = $request->input('img');
        DB::update('UPDATE  tblGreenhouse SET name = ?, description = ?, img = ?, idCompany = ? where idGreenhouse = ? ',[$name, $description, $img, $idCompany, $idGreenhouse]);

        return redirect('/admin');
     }

     public function __invoke($idGreenhouse){

        $companys = DB::select('select * from tblCompany');
        $greenhouses = DB::select('select * from tblGreenhouse WHERE idGreenhouse = :idGreenhouse', ['idGreenhouse' => $idGreenhouse]);
        return view('editGreenhouse',['greenhouse' => $greenhouses, 'company' => $companys]);
    }
}