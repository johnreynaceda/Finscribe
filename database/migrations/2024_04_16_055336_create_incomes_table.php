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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->double('total_sales')->nullable();
            $table->double('total_transaction')->nullable();
            $table->double('total_discount')->nullable();
            $table->double('discount')->nullable();
            $table->double('tax')->nullable();
            $table->double('gross_profit')->nullable();
            $table->double('gross_profit_percentage')->nullable();
            $table->double('total_sales_returned')->nullable();
            $table->double('net_sales')->nullable();
            $table->double('average_net_sales')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
