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
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->increments('delivery_id');
            $table->unsignedInteger('user_id')->default();
            $table->string('fullname', 100)->default();
            $table->string('phone', 20)->nullable()->default();
            $table->string('province', 200)->nullable()->default();
            $table->string('street', 200)->nullable()->default();
            $table->string('district', 200)->nullable()->default();
            $table->string('ward', 200)->nullable()->default();
            $table->string('project', 200)->nullable()->default();
            $table->timestamps();
        });
        if (Schema::hasTable('delivery_addresses')) {
            Schema::table('delivery_addresses', function (Blueprint $table) {
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            });
        }
        DB::table('delivery_addresses')->insert(
            ['fullname' => 'tienngoc', 'phone' => '123445', 'province' => '', 'street' => '', 'district' => '', 'ward' => '', 'project' => ''],
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_addresses');
    }
};
