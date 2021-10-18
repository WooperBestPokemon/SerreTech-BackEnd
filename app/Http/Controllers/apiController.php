<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class apiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("json.response");
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return Controller::sendResponse($success, 'User login successfully.');
        }
        else{
            return Controller::sendError('Unauthorised.', ['error'=>'Unauthorised',$request->all()]);
        }
    }
}
