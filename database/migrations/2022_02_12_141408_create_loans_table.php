<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('approve_admin_id')->nullable();
            $table->unsignedDecimal('amount', 15);
            $table->unsignedInteger('duration')->comment('Number of the months');
            $table->unsignedDecimal('interest_rate', 5, 4);
            $table->unsignedDecimal('arrangement_fee');
            $table->unsignedInteger('user_id');
            $table->enum('status', ['pending', 'approve'])->default('pending');
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
        Schema::dropIfExists('loans');
    }
}
