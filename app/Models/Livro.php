<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Livro extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "nome",
        "descricao",
        "preco",
        "edicao",
        "autor",
        "dataLancamento",
        "quantidade",
        "imagem",
        "categoriaId",
    ];
}
