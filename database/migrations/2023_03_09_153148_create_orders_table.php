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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->unsignedInteger('user_id')->default();

            $table->unsignedInteger('delivery_id')->default();

            $table->date('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('totalAmount')->default();
            $table->unsignedInteger('status_id')->default();

            $table->timestamps();
        });
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('delivery_id')->references('delivery_id')->on('delivery_addresses')->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('status_id')->references('status_id')->on('order_status')->onDelete('cascade')->onUpdate('cascade');
            });
        }
        DB::table('orders')->insert(
            ['totalAmount' => '2000']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
