<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('email')->unique();
            $table->string('user_name')->unique();
            $table->string('member_code')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('referral_url')->nullable();
            $table->string('password');
            $table->string('status',20)->default('ACTIVE');
            $table->string('kyc')->default('NOT UPLOADED');
            $table->string('fcm_token')->nullable();
            $table->string('credits')->default('0');
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}
