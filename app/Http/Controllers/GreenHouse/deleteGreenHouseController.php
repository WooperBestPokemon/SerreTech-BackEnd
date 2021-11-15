<?php

namespace App\Http\Controllers\GreenHouse;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use Illuminate\Http\Request;

class deleteGreenHouseController extends Controller
{
    public function __invoke($idGreenhouse){
        $data = GreenHouse::findorFail($idGreenhouse);
        $data->delete();

        return redirect('/admin/gestion');
    }
}
