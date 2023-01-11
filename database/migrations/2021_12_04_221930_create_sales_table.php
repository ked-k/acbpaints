<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('item_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->float('sale_price')->default('0');
            $table->float('qty_given')->default('0');
            $table->float('total_amount')->default('0');
            $table->float('discount')->default('0');
            $table->string('payment_type')->default('cash');
            $table->string('item_state')->default('open');
            $table->string('sale_year')->nullable();
            $table->string('sale_month')->nullable();
            $table->string('sale_week')->nullable();
            $table->string('sale_code')->nullable();
            $table->float('is_active')->default('0');
            $table->foreignId('users_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('sales');
    }
}
