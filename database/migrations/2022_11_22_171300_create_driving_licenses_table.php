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
        Schema::create('driving_licenses', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable();
            $table->integer('nota')->nullable();
            $table->boolean('visiontest')->nullable();
            $table->string('license')->nullable();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->string('generadapor')->nullable();
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
        Schema::dropIfExists('driving_licenses');
    }
};
