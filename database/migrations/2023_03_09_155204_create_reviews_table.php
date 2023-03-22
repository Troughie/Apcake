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
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->unsignedInteger('product_id');

            $table->unsignedInteger('user_id');

            $table->integer('rating')->nullable();
            $table->string('comment', 500)->nullable();
            $table->date('reviewDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
