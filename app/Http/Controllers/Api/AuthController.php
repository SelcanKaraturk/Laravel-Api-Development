<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //Dynamic Authentication

    public function login(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'password'=>'required'
        ]);

        $user=User::where('email',$request->email)->first();
        if ($user){
            $user->update([
                'api_token'=>Str::random(60)
            ]);
        }
    }
}
