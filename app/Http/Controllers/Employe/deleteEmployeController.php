<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class deleteEmployeController extends Controller
{
    public function __invoke($idUser){
        $data = User::findorFail($idUser);
        $data->delete();

        return redirect('/admin/employe');
    }
}