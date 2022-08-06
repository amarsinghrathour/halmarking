<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_menus', function (Blueprint $table) {
            $table->collation = 'utf8mb4_bin';
            $table->id();
            $table->integer('sort_order')->nullable();
            $table->integer('sub_sort_order')->nullable();
            $table->integer('parent_id')->default(0);
            $table->integer('type');
            $table->string('name',200);
            $table->string('external_link',200)->nullable();
            $table->string('link',200)->nullable();
             $table->integer('page_id')->nullable();
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
        Schema::dropIfExists('web_menus');
    }
}
