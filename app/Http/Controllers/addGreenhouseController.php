<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addGreenhouseController extends Controller
{
    public function index(){
        return view('addGreenhouse');
    }

    public function insert(Request $request) {
        $name = $request->input('name');
        $description = $request->input('description');
        $idCompany = $request->input('idCompany');
        DB::insert('insert into tblGreenhouse (name, description, idCompany) values(?, ?, ?)',[$name, $description, $idCompany]);

        return redirect('/admin');
     }

     public function __invoke(){

        $companys = DB::select('select * from tblCompany');
        return view('addGreenhouse',['company' => $companys]);
    }
}