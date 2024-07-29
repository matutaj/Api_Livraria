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
        

        $user = User::where("email", $request->email)->first();

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
 /**
     * Validar o código de recuperação de senha enviado pelo usuário.
     *
     * Este método valida o código de recuperação de senha enviado pelo usuário.
     * Utiliza o serviço ResetPasswordValidateCodeService para validar o código. Se o código for válido,
     * retorna uma resposta de sucesso. Caso contrário, retorna uma resposta de erro.
     *
     * @param ResetPasswordValidateCodeRequest $request O request contendo o e-mail e o código de recuperação de senha
     * @param ResetPasswordValidateCodeService $ResetPasswordValidateCodeService O serviço utilizado para validar o código de recuperação de senha
     * Injeção de Dependência: o Laravel automaticamente resolve e injeta uma instância dessa classe no método quando é chamado.
     * @return \Illuminate\Http\JsonResponse Resposta indicando sucesso ou falha na validação do código
     */
    public function resetPasswordValidateCode(ResetPasswordValidateCodeRequest $request, ResetPasswordValidateCodeService $resetPasswordValidateCode): JsonResponse
    {

        try{

            // Validar o código do token
            $validationResult = $resetPasswordValidateCode->resetPasswordValidateCode($request->email, $request->code);

            // Verificar o resultado da validação
            if(!$validationResult['status']){

                // Exibir mensagem de erro
                return response()->json([
                    'status' => false,
                    'message' => $validationResult['message'],
                ], 400);

            }

            // Recuperar os dados do usuário
            $user = User::where('email', $request->email)->first();

            // Verificar existe o usuário no banco de dados
            if(!$user){
                
                // Salvar log
                Log::notice('Usuário não encontrado.', ['email' => $request->email]);

                // Exibir mensagem de erro
                return response()->json([
                    'status' => false,
                    'message' => 'Usuário não encontrado!',
                ], 400);

            }
                
            // Salvar log
            Log::info('Código recuperar senha válido.', ['email' => $request->email]);

            return response()->json([
                'status' => true,
                'message' => 'Código recuperar senha válido!',
            ], 200);

        } catch (Exception $e){

            // Salvar log
            Log::warning('Erro validar código recuperar senha.', ['email' => $request->email, 'error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'Código inválido!',
            ], 400);
        }
        
    }

    /**
     * Resetar a senha do usuário com base no código de recuperação.
     *
     * Este método resetar a senha do usuário com base no código de recuperação enviado pelo usuário.
     * Utiliza o serviço ResetPasswordValidateCodeService para validar o código. Se o código for válido, atualiza a senha
     * do usuário no banco de dados e retorna uma resposta de sucesso com o token de acesso JWT.
     * Caso contrário, retorna uma resposta de erro.
     *
     * @param ResetPasswordCodeRequest $request O request contendo o e-mail, o código de recuperação de senha e a nova senha
     * @param ResetPasswordValidateCodeService $resetPasswordValidateCode O serviço utilizado para validar o código de recuperação de senha
     * Injeção de Dependência: o Laravel automaticamente resolve e injeta uma instância dessa classe no método quando é chamado.
     * @return \Illuminate\Http\JsonResponse Resposta indicando sucesso ou falha na resetar da senha do usuário
     */
    public function resetPasswordCode(ResetPasswordCodeRequest $request, ResetPasswordValidateCodeService $resetPasswordValidateCode): JsonResponse
    {

        try{

            // Validar o código do token
            $validationResult = $resetPasswordValidateCode->resetPasswordValidateCode($request->email, $request->code);

            // Verificar o resultado da validação
            if(!$validationResult['status']){
                
                // Exibir mensagem de erro
                return response()->json([
                    'status' => false,
                    'message' => $validationResult['message'],
                ], 400);

            }

            // Recuperar os dados do usuário
            $user = User::where('email', $request->email)->first();

            // Verificar existe o usuário no banco de dados
            if(!$user){
                
                // Salvar log
                Log::notice('Usuário não encontrado.', ['email' => $request->email]);

                // Exibir mensagem de erro
                return response()->json([
                    'status' => false,
                    'message' => 'Usuário não encontrado!',
                ], 400);

            }

            // Alterar a senha do usuário no banco de dados
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // gerar o token 
            $token = $user->first()->createToken('api-token')->plainTextToken;

            // Recuperar os registros recuperar senha do usuário
            $userPasswordResets = DB::table('password_reset_tokens')->where('email', $request->email);

            // Se existir token cadastrado para o usuário recuperar senha, excluir o mesmo
            if($userPasswordResets){
                $userPasswordResets->delete();
            }

            // Salvar log
            Log::info('Senha atualizada com sucesso.', ['email' => $request->email]);

            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token,
                'message' => 'Senha atualizada com sucesso!',
            ], 200);
        }catch(Exception $e){

            // Salvar log
            Log::warning('Senha não atualizada.', ['email' => $request->email, 'error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'Senha não atualizada!',
            ], 400);

        }
        
    }



}
