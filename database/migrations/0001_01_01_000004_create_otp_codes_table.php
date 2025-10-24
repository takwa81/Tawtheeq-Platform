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
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('otp_code', 10);
            $table->enum('purpose', ['login', 'password_reset'])->default('login');
            $table->timestamp('expiration_time');
            $table->timestamp('used_at')->nullable();
            $table->boolean('is_used')->default(false);
            $table->enum('next_waiting_time', [0, 1, 2, 5, 10, 30, 60])->default(0);
            $table->integer('attempt_sequence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
