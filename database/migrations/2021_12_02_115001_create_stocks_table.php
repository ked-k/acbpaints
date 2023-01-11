<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->float('stock_qty')->default('0');
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('stock_code')->nullable();
            $table->decimal('unit_cost')->nullable();
            $table->decimal('total_cost')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('supplier_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('user_id')->default('1');
            $table->integer('is_active')->default(0);
            $table->date('date_added')->nullable();
            $table->string('stock_year')->nullable();
            $table->string('stock_month')->nullable();
            $table->string('stock_week')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
