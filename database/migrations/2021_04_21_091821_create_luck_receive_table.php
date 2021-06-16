<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuckReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luck_receive', function (Blueprint $table) {
            $table->id();
            $table->string('openid');
            $table->integer('prizeid')->comment('奖品id')->nullable();
            $table->date('date')->comment('领取时间')->nullable();
            $table->boolean('is_receive')->default(0)->comment('是否领取奖品 0：否 1：是');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->engine = 'InnoDB';
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
        Schema::dropIfExists('luck_receive');
    }
}
