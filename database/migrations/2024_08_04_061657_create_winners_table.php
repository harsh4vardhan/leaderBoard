<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinnersTable extends Migration
{
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaderboard_user_id')->constrained('leaderboard_users')->onDelete('cascade');
            $table->integer('points');
            $table->timestamp('won_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('winners');
    }
}
