<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->text('nom',55);
            $table->string('image',255);
            $table->integer('quantite');
            $table->integer('quantiteMin');
            $table->string('categorie');
            $table->integer('prix_unitaire');
            $table->string('libelle', 255);
            $table->unsignedBigInteger('id_cat')->nullable();
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
        Schema::dropIfExists('produits');
    }
};
