<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('albums', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->string('title');
        $table->string('event')->nullable();
        $table->date('event_date')->nullable();
        $table->string('location')->nullable();
        $table->text('description')->nullable();

        // MVP Drive: link pegado por el fotógrafo
        $table->string('drive_url')->nullable();

        // Para el listado público
        $table->boolean('is_public')->default(false);

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
        Schema::dropIfExists('albums');
    }
}
