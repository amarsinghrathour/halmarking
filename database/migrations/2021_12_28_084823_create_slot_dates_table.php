<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_dates', function (Blueprint $table) {
            $table->id();
            $table->date('slot_date')->unique();
            $table->string('status',100)->default('ACTIVE');
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
        Schema::dropIfExists('slot_dates');
    }
}
