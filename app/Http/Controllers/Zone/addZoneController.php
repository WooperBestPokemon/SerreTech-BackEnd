<?php

namespace App\Http\Controllers\Zone;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addZoneController extends Controller
{
    public function index(){
        return view('addZone');
    }

    public function insert(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'typeFood'=>'required|string'
        ]);

        Zone::create([
            'name'=> $request->input('name'),
            'typeFood'=>$request->input('typeFood'),
            'idGreenHouse'=> 1,
            'description'=> $request->input('description'),
            'img'=> $request->input('img'),
            'water'=> 0,
        ]);


        return redirect('/admin');
    }

    public function __invoke(){

        $url = 'http://apipcst.xyz/api/searchAll/plant ';
        $response = file_get_contents($url);
        $newsData = json_decode($response);
        return view('addZone',['allPlant' => $newsData]);
    }


}
