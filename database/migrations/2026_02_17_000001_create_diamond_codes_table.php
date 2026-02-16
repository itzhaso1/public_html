<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diamond_codes', function (Blueprint $table) {
            $table->id();

            // Code belongs to a "codes" product (service_type = codes)
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            // Code is delivered as result of a manual payment request
            $table->foreignId('manual_payment_request_id')
                ->nullable()
                ->constrained('manual_payment_requests')
                ->nullOnDelete();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('code')->unique();
            $table->string('image_path')->nullable();

            $table->enum('status', ['available', 'delivered'])->default('available');
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();

            $table->index(['product_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diamond_codes');
    }
};

