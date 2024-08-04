<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToWinnersTable extends Migration
{
    public function up()
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->string('name')->nullable(); // Adjust the type as needed
        });
    }

    public function down()
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
