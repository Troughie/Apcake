<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('orderdetail_id');
            $table->unsignedInteger('order_id')->default();

            $table->unsignedInteger('product_id')->default();

            $table->unsignedInteger('size_id')->default();

            $table->Integer('quantity')->default();
            $table->float('Price')->default();
            $table->timestamps();
        });
        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('size_id')->references('size_id')->on('sizes')->onDelete('cascade')->onUpdate('cascade');
            });
        }
        DB::table('order_details')->insert(
            ['quantity' => '2'],
            ['Price' => '2000']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};