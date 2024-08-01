<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VendaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
protected function failedVAlidation(Validator $validator){
    throw new HttpResponseException(response()->json([
        "status"=> false,
        "erros"=>$validator ->errors()
    ], 422));
}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "quantidade"=>"required|numeric",
            "userId"=>"required|integer|exists:users,id",
            "livroId"=>"required|integer|exists:livros,id",
        ];
    }
    public function messages():array{

       return [
            "quantidade.required"=>" A quantidade é obrigatório",
            "quantidae.numeric"=>"A quantidade não deve ser uma string",
            "userId.required"=>"O id do Usuário é obrigatório",
            "userId.integer"=>"O id do Usuário Não deve ser string",
            "userId.exists"=>"O id do Usuário não  está cadastrado ",
            "livroId.required"=>"O Id do livro é obrigatório",
            "livroId.integer"=>"O id do Livro Não deve ser uma string",
            "livroId.exists"=>"O id deste livro não está cadastrado",
        ];
    }
}
