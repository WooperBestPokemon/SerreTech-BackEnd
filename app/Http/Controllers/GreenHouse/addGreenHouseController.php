<?php

namespace App\Http\Controllers\GreenHouse;

use App\Models\GreenHouse;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class addGreenhouseController extends Controller
{
    public function index(){
        $user = Auth::user();
        $idProfile = Auth::id();
        $users = [] ;
        foreach(User::where('idProfile','=',$idProfile)->get() as $user) {
            array_push($users, [
                "idProfile" =>$user->getAttributes()["idProfile"],
                "name" =>$user->getAttributes()["name"],
                "email" =>$user->getAttributes()["email"],
                "role" =>$user->getAttributes()["role"],
                "idCompany" =>$user->getAttributes()["idCompany"],
                "permission" =>$user->getAttributes()["permission"],
            ]);
        }

        return view('addGreenhouse',['user' => $users]);
    }

    public function insert(Request $request) {
    $request->validate([
        'name'=>'required|string',
        'description'=>'required|string'
        ]);


        GreenHouse::create([
            'name'=> $request->input('name'),
            'idCompany'=> 1,
            'description'=> $request->input('description'),
            'img'=> $request->input('img'),

        ]);
        return redirect('/admin');

     }

     public function __invoke(){

        $user = Auth::user();
        $idProfile = Auth::id();
        $users = [] ;
        foreach(User::where('idProfile','=',$idProfile)->get() as $user) {
            array_push($users, [
                "idProfile" =>$user->getAttributes()["idProfile"],
                "name" =>$user->getAttributes()["name"],
                "email" =>$user->getAttributes()["email"],
                "role" =>$user->getAttributes()["role"],
                "idCompany" =>$user->getAttributes()["idCompany"],
                "permission" =>$user->getAttributes()["permission"],
            ]);
        }

        return view('addGreenhouse',['user' => $users]);
    }
}
