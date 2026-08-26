<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->string('client_name')->nullable(); // e.g. Alexandria Petroleum Co., MV Sea Star
            $table->string('vessel_type')->nullable(); // e.g. Cargo Vessel, Oil Tanker, Luxury Yacht
            $table->string('location_ar')->nullable(); // e.g. ميناء الإسكندرية
            $table->string('location_en')->nullable(); // e.g. Port of Alexandria, Egypt
            $table->string('duration')->nullable();    // e.g. 5 أيام عمل
            $table->text('short_desc_ar')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->json('specifications')->nullable(); // JSON key-values e.g. Capacity, Standard, Classification
            $table->string('main_image')->nullable();
            $table->string('video_url')->nullable();
            $table->json('gallery_images')->nullable(); // Array of image URLs/paths
            $table->string('before_image')->nullable(); // For Before/After interactive slider
            $table->string('after_image')->nullable();  // For Before/After interactive slider
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_projects');
    }
};
