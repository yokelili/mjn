<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWxUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_user', function (Blueprint $table) {
            $table->id();
            $table->string('openid');
            $table->string('store')->comment('门店')->nullable();
            $table->integer('change_num')->comment('中奖机会')->default(0);
            $table->integer('status')->default(104)->comment('是否为会员 104：否 100：是');
            $table->string('verify')->default(0)->comment('防伪码');
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
        Schema::dropIfExists('wx_user');
    }
}
