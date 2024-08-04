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
            $table->string('title');
            $table->string('content');
            $table->string('body');
            $table->string('link_url');
            $table->integer('color');
            $table->string('footer_content');
            $table->string('footer_url');
            $table->string('image_url');
            $table->string('thumbnail_url');
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
