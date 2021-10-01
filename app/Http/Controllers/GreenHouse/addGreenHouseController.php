<?php

namespace App\Http\Controllers\GreenHouse;

use App\Models\GreenHouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addGreenhouseController extends Controller
{
    public function index(){
        return view('addGreenhouse');
    }

    public function insert(Request $request) {
    $request->validate([
        'name'=>'required|string',
        'img'=>'required',
        'description'=>'required|string'
    ]);


        GreenHouse::create([
            'name'=> $request->input('name'),
            'idCompany'=> 1,
            'description'=> $request->input('description'),
            'img'=> $request->input('img'),

        ]);
        return redirect('/');

     }

     public function __invoke(){


        return view('addGreenhouse');
    }
}
