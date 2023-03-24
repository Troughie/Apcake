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
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('cart_id');
            $table->unsignedInteger('user_id')->default()->nullable();

            $table->unsignedInteger('product_id')->default();

            $table->Integer('quantity')->default();

            $table->timestamps();
        });

        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
