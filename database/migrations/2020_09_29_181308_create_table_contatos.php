<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContatos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_contatos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->binary('imagem')->nullable();
            $table->string('nome',50);
            $table->string('email',100);
            $table->string('telefone',25);
            $table->string('celular',25)->nullable();
            $table->boolean('favorito')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_contatos');
    }
}
