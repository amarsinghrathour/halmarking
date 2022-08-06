<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->date('appointment_date');
            $table->string('slot_time_id');
            $table->string('appointment_start_time');
            $table->string('appointment_end_time');
            $table->enum('instruments_required',['YES','NO'])->default('NO');
            $table->string('instruments')->nullable();
            $table->enum('vocal_required',['YES','NO'])->default('NO');
            $table->string('vocals')->nullable();
            $table->string('track_url')->nullable();
            $table->enum('dubbing_required',['YES','NO'])->default('NO');
            $table->string('dubbings')->nullable();
            $table->string('credits_used')->default('0');
            $table->string('status')->default('BOOKED')->comment('REJECTED,BOOKED,CLOSED,POSTPONED');
            $table->string('created_by',100)->default('Self');
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
        Schema::dropIfExists('appointments');
    }
}
