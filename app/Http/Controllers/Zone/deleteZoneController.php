<?php

namespace App\Http\Controllers\Zone;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class deleteZoneController extends Controller
{
    public function __invoke($idZone){
        $data = Zone::findorFail($idZone);
        $data->delete();

        return redirect('/admin/zone/list');
    }
}
