<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuckDrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luck_draw', function (Blueprint $table) {
            $table->id();
            $table->string('openid');
            $table->integer('prizeid')->comment('奖品id')->nullable();
            $table->string('type')->comment('抽奖类型')->nullable();
            $table->boolean('is_luck')->default(0)->comment('是否中奖 0：否 1：是');
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
        Schema::dropIfExists('luck_draw');
    }
}
