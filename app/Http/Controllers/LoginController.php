<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        $user = User::where('email', $request->email)->first();
        
        if($user != '' || $user != null){
            if($user->status == 0){
                return "2";
            }
        }
        else{
            return "3";
        }
        if(!Auth::validate($credentials)){
            return "0";
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return '1';
    }

    protected function authenticated(Request $request, $user) 
    {
        return redirect()->intended();
    }
}
