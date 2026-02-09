<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchIndexesToAlbums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            // Índice para optimizar búsquedas por fecha
            $table->index(['event_date']);

            // Índice de texto completo para búsquedas por título, descripción y evento
            // Nota: En MySQL usar fullText(), en PostgreSQL usar regular index
            $table->index(['title']);
            $table->index(['description']);
            $table->index(['event']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            // Eliminar índices
            $table->dropIndex(['event_date']);
            $table->dropIndex(['title']);
            $table->dropIndex(['description']);
            $table->dropIndex(['event']);
        });
    }
}
