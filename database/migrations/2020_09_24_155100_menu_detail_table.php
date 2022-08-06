<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MenuDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_detail', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('url',100)->nullable();
            $table->double('menu_order',22,0)->nullable();
            $table->integer('parent_id')->default('0');
            $table->string('icon',100)->nullable();
            $table->string('title',100)->nullable();
            $table->enum('is_top', ['Y','N'])->default('N');
            $table->string('created_by',100)->default('Self');
            $table->string('updated_by',100)->nullable();
            $table->string('status')->default('ACTIVE');
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
        Schema::dropIfExists('menu_detail');
    }
}
