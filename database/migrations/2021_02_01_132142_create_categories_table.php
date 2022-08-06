<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title',45);
            $table->integer('parent_id')->default('0');
            $table->string('description',255)->nullable();
            $table->string('image',255)->nullable();
            $table->string('slug',255)->unique();
            $table->string('status')->default('ACTIVE');
            $table->integer('sort_order')->default('0');
            $table->enum('is_top',['Y','N'])->default('N');
            $table->string('created_by',100);
            $table->string('updated_by',100)->nullable();
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
        Schema::dropIfExists('categories');
    }
}
