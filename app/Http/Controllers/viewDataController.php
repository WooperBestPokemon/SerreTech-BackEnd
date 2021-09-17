<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\support\facades\auth;


class viewDataController extends Controller
{
    public function __invoke(){

        $datas = DB::select('select * from tblTest');
        return view('viewData',['data' => $datas]);
    }
}
