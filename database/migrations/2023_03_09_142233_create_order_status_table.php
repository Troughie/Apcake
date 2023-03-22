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
        Schema::create('order_status', function (Blueprint $table) {
            $table->increments('status_id');
            $table->string('name', 50)->default();
            $table->string('description', 200)->default();
            $table->timestamps();
        });
        DB::table('order_status')->insert(
            ['name' => 'loading'],
            ['description' => 'dang trong giai doan xu ly']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status');
    }
};
