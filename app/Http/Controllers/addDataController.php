<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addDataController extends Controller
{
    public function index(){
        return view('addData');
    }

    public function insert(Request $request) {
        $value = $request->input('value');
        DB::insert('insert into tblTest (value) values(?)',[$value]);

        return redirect('/viewData');
     }
}