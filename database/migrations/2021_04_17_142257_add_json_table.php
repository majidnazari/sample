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
            $table->string('mobile');
            $table->string('city');
            $table->string('country');
            $table->string('address');
            $table->string('address2');
            $table->timestamp('last_visit');
            $table->bigInteger('credit');
            $table->boolean('gender');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_attributes');
    }
}
