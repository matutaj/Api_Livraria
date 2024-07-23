<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CategoriaRequest extends FormRequest
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

     protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "status"=>false,
            "erros"=>$validator ->errors()
        ],422));
     }

    public function rules(): array
    {
        $categoriaId = $this->route("categoria");
        
        return [
            //
            "nome"=> "required|unique:categorias,nome".($categoriaId ? $categoriaId->id : null),
        ];
    }
    public function messages():array{
        return [
            "nome.required"=>"O Campo nome é Obrigatório!",
            "nome.unique"=>"Já existe Esta categoria"
        ];
    }
}
