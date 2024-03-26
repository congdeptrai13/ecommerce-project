<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("order_id");
            $table->string("transaction_id");
            $table->string("payment_method");
            $table->double("amount"); //5$
            $table->double("amount_real_currency"); //5$ = 450rs
            $table->string("amount_real_currency_name"); //5$ = 450rs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
