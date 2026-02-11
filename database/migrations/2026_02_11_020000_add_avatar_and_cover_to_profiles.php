<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarAndCoverToProfiles extends Migration
{
    public function up()
    {
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('secondary_color');
            $table->string('cover_path')->nullable()->after('avatar_path');
        });

        Schema::table('cosplayer_profiles', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('secondary_color');
            $table->string('cover_path')->nullable()->after('avatar_path');
        });
    }

    public function down()
    {
        Schema::table('photographer_profiles', function (Blueprint $table) {
            $table->dropColumn(['avatar_path', 'cover_path']);
        });

        Schema::table('cosplayer_profiles', function (Blueprint $table) {
            $table->dropColumn(['avatar_path', 'cover_path']);
        });
    }
}
