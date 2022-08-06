<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_sliders', function (Blueprint $table) {
           $table->collation = 'utf8mb4_bin';
            $table->id();
            $table->string('title',200)->nullable();
            $table->string('sub_title',200)->nullable();
            $table->text('image');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->string('status',200)->default('ACTIVE');
            $table->string('created_by',200);
            $table->string('updated_by',200)->nullable();
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
        Schema::dropIfExists('web_sliders');
    }
}
