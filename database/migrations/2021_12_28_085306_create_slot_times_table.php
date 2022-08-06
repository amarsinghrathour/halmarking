<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_times', function (Blueprint $table) {
            $table->id();
            $table->string('slot_date_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status',100)->default('DEACTIVE')->comment('ACTIVE,USED,DELETED,DEACTIVE');
            $table->timestamps();
            $table->string('created_by',100)->default('Self');
            $table->string('updated_by',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slot_times');
    }
}
