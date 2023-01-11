<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmedSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmed_sales', function (Blueprint $table) {
            $table->id();
            $table->float('total_amount')->default('0');
            $table->float('paid_amount')->default('0');
            $table->float('balance')->default('0');
            $table->string('payment_type')->default('cash');
            $table->string('sale_year')->nullable();
            $table->string('sale_month')->nullable();
            $table->string('sale_week')->nullable();
            $table->string('sale_code')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('customer_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('confirmed_sales');
    }
}
