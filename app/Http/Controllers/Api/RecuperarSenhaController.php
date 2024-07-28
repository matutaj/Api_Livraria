<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Mail\SendEmailForgotPasswordCode;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RecuperarSenhaController extends Controller
{
    public function forgotPasswordCode(ForgotPasswordRequest $request){

        $user =User::where("email", $request->email)->first();

        if(!$user){

            //salvar log
            Log::warning("Tentativa de recuperar senha com e-mail não cadastrado.", ["email"=>$request->email]);

            return response()->json([
                "status"=>false,
                "message"=>"E-mail não encontrado!",
            ], 400);
        }
        try{
            //Recuperar os registros e senha do usuário
            $userPasswordResets=DB::table('password_reset_tokens')->where([
                ["email",$request->email]
            ]);

            //Se existir o token cadastrado para o usuário recuperar senha, excluir o mesmo
            if($userPasswordResets){
                $userPasswordResets->delete();
            }

            //Gerar o código com 6 dígitos
            $code=mt_rand(100000, 999999);

            //Criptografar o código para salvar no banco
            $token= Hash::make($code);

            //Salvar no Banco de Dados
            $userPasswordResets = DB::table('password_reset_tokens')->insert([
                "email"=> $request->email,
                "token"=>$token,
                "created_at"=>Carbon::now(),
            ]);

            //Enviar e-mail após cadastrar no banco de dados novo token recuperar

            if($userNewPasswordResets){

                //Receber a data atual;
                $currentDate = Carbon::now();

                //Adicionar uma Hora
                $oneHourLater = $currentDate->addHour();

                //Formatar data e hora
                $formattedTime = $oneHourLater->format("H:i");
                $formattedDate = $oneHourLater->format("d/m/y");

                //dados para enviar e-mail
                Mail::to($user->email)->send(new SendEmailForgotPasswordCode(
                    $user, $code, $formattedDate, $formattedTime
                ));
            }

            // Salvar log
            Log::info("Recuperar senha.", ["email"=> $request->email]);

            return response()->json([
                "status"=> true,
                "message"=> "Enviado o email com a instrução para recuperar a senha. 
                Acesse o seu e-mail para recuperar a senha",
            ],200);
        }catch(Exception $e){
            Log::warning("Erro ao recuperar senha.", ["email"=> $request->email,
            "error" => $e->getMessage()
        ]);

        return response()->json([
            "status"=>false,~
            "message"=> "erro ao recuperar senha. Tente mais tarde."
        ],400);
        }
    }
}
