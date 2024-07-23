<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){

        //validar o emial e senha do usuároio
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            //Recuperar os dados do Usuário
            $user =Auth::user();

            //Retornar um tokem
           $token= $request->user()->createToken("api-token")->plainTextToken;

            return response()->json([
                "status"=> true,
                "token"=> $token,
                "user"=>$user,
            ],201);
        }else{
            return response()->json([
                "status"=> false,
                "message"=>"Login ou senha Incorreta"
            ],404);
        };
    }
}
