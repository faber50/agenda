<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_enderecos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cep',20);
            $table->string('rua',150);
            $table->string('numero',20);
            $table->string('bairro',100);
            $table->string('cidade',100);
            $table->string('estado',100);
            $table->integer('contato_id')->unsigned();
            $table->foreign('contato_id')->references('id')->on('tb_contatos');
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
        Schema::dropIfExists('tb_enderecos');
    }
}
