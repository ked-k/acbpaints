<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->string('item_barcode')->nullable();
            $table->string('syscode')->uniqid();
            $table->foreignId('unit_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('subunit_id')->nullable();
            $table->float('cost_price')->nullable();
            $table->float('sale_price')->nullable();
            $table->float('margin')->nullable();
            $table->string('model_no')->nullable();
            $table->string('color')->nullable();
            $table->foreignId('uom_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('supplier_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('description')->nullable();
            $table->date('date_added')->nullable();
            $table->integer('is_active')->default(1);
            $table->float('qty_left')->default('0');
            $table->float('qty_held')->default('0');
            $table->string('stamp')->default('input');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('items');
    }
}
