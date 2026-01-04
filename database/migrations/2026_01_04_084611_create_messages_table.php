<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->text('message');

            $table->timestamps();

            $table->foreign('complaint_id')
                ->references('complaint_id')
                ->on('complaints')
                ->cascadeOnDelete();

            $table->foreign('sender_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
