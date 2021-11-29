<?php

namespace App\Http\Controllers\Employe;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class addEmployeController extends Controller
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

        return view('addEmploye',['user' => $users]);
    }

    public function insert(Request $request) {
    $request->validate([
        'name'=>'required|string',
        'email'=>'required|string',
        'password'=>'required|string',
        'permission'=>'required|string',
        'idCompany'=>'required|string',
        ]);


        User::create([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make($request->input('password')),
            'permission'=> $request->input('permission'),
            'idCompany'=> $request->input('idCompany'),

        ]);
        return redirect('/admin');

     }

     public function __invoke(){


        return view('addEmploye');
    }
}