<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;

class deleteSensorController extends Controller
{
    public function __invoke($idSensor){
        $data = Sensor::findorFail($idSensor);
        $data->delete();

        return redirect('/admin/gestion');
    }
}