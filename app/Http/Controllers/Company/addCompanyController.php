<?php

namespace App\Http\Controllers\Company;

use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class addCompanyController extends Controller
{
    public function __invoke(){
        $user = Auth::user();


        return view('addCompany',['user' => $user]);
    }

    public function insert(Request $request) {
    $request->validate([
        'name'=>'required|string',
        'nameCompany'=>'required|string',
        'email'=>'required|string',
        'password'=>'required|string',
        ]);


        Company::create([
            'name'=> $request->input('nameCompany'),
        ]);

        $name = $request->input('nameCompany');

        $companys = [];
        foreach(Company::where('name','=',$name)->get() as $company) {
            array_push($companys, [
                "idCompany" =>$company->getAttributes()["idCompany"],
            ]);
        }


        $idCompanys = array_key_last($companys);


        User::create([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make($request->input('password')),
            'permission'=> '4',
            'role'=> 'admin',
            'idCompany'=> $idCompanys,

        ]);
        return redirect('/admin');

     }

}
