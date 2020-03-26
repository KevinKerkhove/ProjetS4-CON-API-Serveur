<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartieTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('partie', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->int('score')->nullable(false);
            $table->date('time')->nullable(false);
            $table->int('ennemiesKilled')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Tache');
    }
}
