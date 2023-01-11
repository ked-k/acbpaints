<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_item_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->float('sale_value')->default('0');
            $table->float('sale_value_pre')->default('0');
            $table->string('stock_code')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('machine_stocks');
    }
}
