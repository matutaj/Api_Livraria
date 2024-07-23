<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->text("descricao");
            $table->double("preco");
            $table->string("edicao");
            $table->string("autor");
            $table->timestamp("dataLancamento");
            $table->double("quantidade");
            $table->string("imagem");
            $table->timestamps();

            $table->unsignedBigInteger("categoriaId");
            $table->foreign("categoriaId")->references("id")->on("categorias")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
