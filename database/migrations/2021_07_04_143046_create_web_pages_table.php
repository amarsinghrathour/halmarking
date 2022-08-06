<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_contents', function (Blueprint $table) {
           $table->collation = 'utf8mb4_bin';
            $table->id();
            $table->string('title',200);
            $table->string('url',500)->unique();
            $table->text('description')->nullable();
            $table->string('template',200)->default('blog_detail');
            $table->string('category_id',500)->nullable();
            $table->string('sub_category_id',500)->nullable();
            $table->string('status',200)->default('ACTIVE');
            $table->string('meta_title',500)->nullable();
            $table->string('meta_description',500)->nullable();
            $table->string('meta_key_word',500)->nullable();
            $table->text('sidebar')->nullable();
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
        Schema::dropIfExists('web_pages');
    }
}
