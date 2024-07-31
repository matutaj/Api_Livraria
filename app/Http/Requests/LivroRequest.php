<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



class LivroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([

            "status"=> false,
            "erros"=>$validator ->errors()
        ],422));
    }
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nome"=>"required|max:50|string|unique:livros,nome",
            "descricao"=>"required|string",
            "preco"=>"required|numeric",
            "autor"=>"required|string",
            "dataLancamento"=>"required|date_format:Y-m-d",
            "quantidade"=>"required|numeric",
            "categoriaId"=>"required|integer|exists:categorias,id",
        ];
    }

    public function messages():array{
         return[
            "nome.required"=>"O nome do livro é Obrigatório",
            "nome.max"=>" O nome deve ter máximo :max caracter",
            "nome.string"=>"O nome deve ser uma string ou Caracter",
            "nome.unique"=>"Já existe este livro no banco de Dados",
            "descricao.required"=>"Deve ter uma descrição para o Livro",
            "preco.required"=>"O campo preço é obrigatório",
            "autor.required"=>"Precisa preencher o autor",
            "dataLancamento.required"=>"Coloca uma data de Lançamento",
            "dataLancamento.date"=>"Precisa colocar uma data Válida",
            "quantidade.required"=>"Insira a Quantidade de Livros",
            "categoriaId.required"=>"Insira o Id da Categoria do Livro",
            "categoriaId.exists"=>"Insira um Id válido para a categoria do livro",

         ];
    }
}
