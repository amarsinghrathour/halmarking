<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_no',100);
            $table->string('product_type',100);
            $table->decimal('purity',10,2);
            $table->string('no_of_products',20);
            $table->string('lot_size',20);
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
        Schema::dropIfExists('jobs');
    }
}
