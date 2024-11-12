<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // علاقة مع جدول users
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // علاقة مع جدول المنتجات
            $table->unsignedTinyInteger('rating'); // التقييم من 1 إلى 5
            $table->text('content')->nullable();
            $table->unsignedInteger('likes_count')->default(0); // عدد الإعجابات
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
