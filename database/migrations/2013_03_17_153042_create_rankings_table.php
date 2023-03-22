<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->increments('rank_id');
            $table->string('rank_name')->default('Vip đồng');
            $table->string('rank_logo')->default('1');
            $table->timestamps();
        });

        DB::table('rankings')->insert(
            ['rank_name' => 'Vip đồng'],
            ['rank_logo' => '1'],
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};
