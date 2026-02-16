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
        Schema::create('about_translations', function (Blueprint $table) {
    // $table->foreignId('about_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('about_id')->nullable();
    $table->string('locale')->index();

    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->text('short_description')->nullable();
    $table->string('content_title')->nullable();
    $table->text('content_description')->nullable();
    $table->text('content_note')->nullable();

    $table->unique(['about_id', 'locale']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_translations');
    }
};