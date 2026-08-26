<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ORD-2026-XXXX
            $table->foreignId('quote_request_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('company_name');
            $table->string('email');
            $table->string('phone');
            $table->string('status')->default('قيد التجهيز'); // قيد التجهيز, تم الشحن, مكتمل, ملغي
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_status')->default('آجل / حسب الاتفاق');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
