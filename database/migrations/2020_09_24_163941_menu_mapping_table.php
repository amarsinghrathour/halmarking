<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MenuMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_mapping', function (Blueprint $table) {
             $table->id();
            $table->string('menu_id',45);
            $table->string('role_id',45)->default('1');
            $table->tinyInteger('add_access')->default('1');
            $table->tinyInteger('edit_access')->default('1');
            $table->tinyInteger('delete_access')->default('1');
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
        Schema::dropIfExists('menu_mapping');
    }
}
