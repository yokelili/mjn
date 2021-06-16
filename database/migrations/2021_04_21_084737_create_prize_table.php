<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称')->nullable();
            $table->string('image')->comment('图片')->nullable();
            $table->integer('stock')->comment('剩余库存')->default(0);
            $table->integer('total')->comment('总库存')->default(0);
            $table->integer('v')->comment('概率')->default(0);
            $table->string('channel')->comment('渠道')->nullable();
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
        Schema::dropIfExists('prize');
    }
}
