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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nomeCompleto');
            $table->date('DataNasc');
            $table->string('CPF')->unique();
            //$table->string('Email')->unique();
            //   $table->string('Senha');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('CEP');
            $table->string('Complemento');
            $table->string('NumeroEndereco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Users');
    }
};
