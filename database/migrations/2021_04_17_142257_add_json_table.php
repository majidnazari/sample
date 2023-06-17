<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsonTable extends Migration
{
    public function up()
    {
        Schema::create('user_attributes', function (Blueprint $table) {
            // $table->id();
            // $table->bigInteger('user_id');
            // $table->longText('attributes');
            // $table->timestamps();

           $table->id();
           $table->bigInteger('user_id');
            $table->integer('age');
            $table->string('mobile')->index();
            $table->string('city');
            $table->string('country');
            $table->string('address')->index();
            $table->string('address2')->index();
            $table->string('last_visit_at');
            $table->integer('last_visit_timezone_type');
            $table->string('last_visit_timezone');
            $table->bigInteger('credit')->index();
            $table->boolean('gender');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_attributes');
    }
}
