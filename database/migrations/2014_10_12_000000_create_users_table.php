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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('name', 50)->default();
            $table->string('email', 50)->default()->unique();
            $table->string('password')->default();
            $table->string('role')->default('USR');
            $table->unsignedInteger('rank_id')->default();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->boolean('is_banned')->default(false);
            $table->timestamp('banned_until')->nullable();
            $table->timestamps();
        });
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('rank_id')->references('rank_id')->on('rankings')->onDelete('cascade')->onUpdate('cascade');
            });
        }
        DB::table('users')->insert(
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345678'), 'role' => 'ADM'],

        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
