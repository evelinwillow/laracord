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
        Schema::create('embeds', function (Blueprint $table) {
            $table->id();
            $table->string('template');
            $table->string('discord_id');
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('body')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('color');
            $table->string('footer_content')->nullable();
            $table->string('footer_url')->nullable();
            $table->string('image_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->boolean('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeds');
    }
};
