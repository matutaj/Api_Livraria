<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Venda extends Model
{
    use HasFactory, Notifiable;

    protected $fillable=[
        "quantidade",
        "valorPago",
        "userId",
        "livroId",
    ];
}
