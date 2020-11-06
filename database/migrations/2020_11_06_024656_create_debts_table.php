<?php

use App\Enums\DebtStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->enum('status', DebtStatus::getKeys())->default(DebtStatus::PENDENTE);
            $table->decimal('price', 20, 2);
            $table->date('buy_date');
            $table->date('payment_start_date');
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('card_id')->references('id')->on('cards');
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
        Schema::dropIfExists('debts');
    }
}
