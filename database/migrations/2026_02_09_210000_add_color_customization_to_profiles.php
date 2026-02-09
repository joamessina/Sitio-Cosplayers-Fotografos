<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorCustomizationToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->string('primary_color')->default('#6366f1')->after('location');
            $table->string('secondary_color')->default('#a855f7')->after('primary_color');
        });

        Schema::table('cosplayer_profiles', function (Blueprint $table) {
            $table->string('primary_color')->default('#6366f1')->after('location');
            $table->string('secondary_color')->default('#a855f7')->after('primary_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->dropColumn(['primary_color', 'secondary_color']);
        });

        Schema::table('cosplayer_profiles', function (Blueprint $table) {
            $table->dropColumn(['primary_color', 'secondary_color']);
        });
    }
}