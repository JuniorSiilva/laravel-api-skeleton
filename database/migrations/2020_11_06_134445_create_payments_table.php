<?php

use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 20, 2);
            $table->unsignedInteger('installment')->default(1);
            $table->enum('status', PaymentStatus::getKeys())->default(PaymentStatus::PENDENTE);
            $table->date('payment_date');
            $table->date('receipt_date')->nullable();
            $table->unsignedBigInteger('debt_id');
            $table->unsignedBigInteger('debtor_id');

            $table->unsignedBigInteger('owner_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('debtor_id')->references('id')->on('debtors');
            $table->foreign('debt_id')->references('id')->on('debts');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
