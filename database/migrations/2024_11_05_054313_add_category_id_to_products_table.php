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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->after('image'); // بعد عمود الصورة
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        // تحقق إذا كان العمود موجودًا قبل محاولة حذفه
        if (Schema::hasColumn('products', 'category_id')) {
            $table->dropForeign(['category_id']); // حذف العلاقة إذا كانت موجودة
            $table->dropColumn('category_id'); // حذف العمود
        }
    });
}


};
