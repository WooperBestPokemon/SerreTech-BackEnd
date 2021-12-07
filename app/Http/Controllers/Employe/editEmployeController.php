<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class editEmployeController extends Controller
{
    public function index(){
        return view('editEmploye');
    }

    public function update(Request $request, $idProfile) {

        $data = User::find($idProfile);
        $data->name = $request->input('name') ?? $data->name ;
        $data->email = $request->input('email')??$data->email;
        $data->permission = $request->input('permission')??$data->permission;
        $data->save();

        return redirect('/admin');
    }

    public function __invoke($idProfile){
        $users = Auth::user();
        $users2 = User::find($idProfile);
        return view('editEmploye',['user' => $users,'user2' => $users2]);

    }
}
