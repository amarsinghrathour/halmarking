<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assays', function (Blueprint $table) {
            $table->id();
            $table->string('mix_numbers',200);
            $table->string('job_no',100);
            $table->string('sample',100);
            $table->decimal('m1_weight',10,2);
            $table->decimal('m2_weight',10,2);
            $table->decimal('silver_weight',10,2);
            $table->decimal('cu_weight',10,2);
            $table->decimal('lead_weight',10,2);
            $table->decimal('purity',10,2);
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
        Schema::dropIfExists('assays');
    }
}
