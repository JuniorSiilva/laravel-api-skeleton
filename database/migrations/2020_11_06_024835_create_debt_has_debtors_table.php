<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtHasDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt_has_debtors', function (Blueprint $table) {
            $table->unsignedBigInteger('debt_id');
            $table->unsignedBigInteger('debtor_id');
            $table->primary(['debt_id', 'debtor_id']);
            $table->foreign('debt_id')->references('id')->on('debts');
            $table->foreign('debtor_id')->references('id')->on('debtors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debt_has_debtors');
    }
}
