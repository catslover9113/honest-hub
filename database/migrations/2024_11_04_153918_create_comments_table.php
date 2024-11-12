<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade'); // علاقة مع جدول reviews
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // علاقة مع جدول users
            $table->string('guest_name')->nullable(); // اسم الزائر إذا كان التعليق بدون تسجيل
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
