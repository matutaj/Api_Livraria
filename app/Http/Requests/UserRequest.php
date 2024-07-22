<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */


      /**
     * Get the validation rules that apply to the request.
     * @throws \ Illuminate\Http\Exceptions\HttpResponseException;
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    
    //Manipular Falha de validação e retornar uma resposta JSON com os erros Válidos
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([

            "status"=> false,
            "erros"=>$validator ->errors()
        ],422));
    }
   

    public function rules(): array
    {
        // Recuperar o id do Usuário enviado na Url
        $userId = $this->route("user");
        //Retornar os níveis de erros
        return [
           "name"=> "required",
           "email"=>"required|email|unique:users,email".($userId ? $userId->id : null),
           "password"=> "required|min:6"
        ];
    }

    // Tratamento de erro nas mensagens 

    public function messages():array{
        return [
            "name.required"=> "O Campo nome é obrigatório!",
            "email.required"=>"O Campo e-mial é Obrigatório!",
            "email.email"=>"Precisa de Mandar um email válido!",
            "email.unique"=>"O e-mail já está casatrado!",
            "password.required"=> "A senha é obrigatória",
            "password.min"=> "a senha deve ter no mínimo 6 dígitos",
        ];
    }

}
