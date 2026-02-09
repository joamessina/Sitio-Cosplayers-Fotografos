<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPortfolioCustomizationColumns extends Migration
{
    public function up()
    {
        Schema::table('cosplayer_profiles', function (Blueprint $table) {
            $table->string('portfolio_url')->nullable()->after('instagram');
            $table->string('location')->nullable()->after('portfolio_url');
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('caption');
        });
    }

    public function down()
    {
        Schema::table('cosplayer_profiles', function (Blueprint $table) {
            $table->dropColumn(['portfolio_url', 'location']);
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
}
