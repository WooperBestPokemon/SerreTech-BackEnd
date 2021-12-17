<?php

namespace App\Http\Controllers\GreenHouse;

use App\Http\Controllers\Controller;
use App\Models\GreenHouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class editGreenhouseController extends Controller
{
    public function index(){
        return view('addGreenhouse');
    }

    public function update(Request $request, $idGreenhouse) {

        $data = GreenHouse::find($idGreenhouse);
        $data->name = $request->input('name') ?? $data->name ;
        $data->description = $request->input('description')??$data->description;
        $data->img = $request->input('img') ??$data->img;
        $data->save();

        return redirect('/admin');
     }

     public function __invoke($idGreenhouse){
        $users = Auth::user();
         $notif = Controller::getActiveNotification();
        return view('editGreenhouse',GreenHouse::find($idGreenhouse)->getAttributes(),['user' => $users, "notif" => $notif,"notifCount" => count($notif)]);
    }
}
