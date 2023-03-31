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

        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('name', 100)->default();
            $table->float('price')->default();
            $table->string('description', 200)->nullable();
            $table->integer('quantity')->default();
            $table->integer('size')->default();
            $table->string('image');
            $table->unsignedInteger('category_id')->default();
            $table->timestamps();
        });
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            });
        }
        DB::table('products')->insert(
            ['name' => 'banh mi'],
            ['price' => '10'],
            ['description' => 'aaaaaa'],
            ['quantity' => '10']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
