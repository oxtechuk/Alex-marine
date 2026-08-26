<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();
            $table->text('short_desc_ar')->nullable();
            $table->longText('full_desc_ar')->nullable();
            $table->json('specifications')->nullable(); // key-value pairs e.g. material, certification, weight
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('availability_status')->default('متوفر في المخزن'); // status string
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
