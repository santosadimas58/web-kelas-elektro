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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('department');
            $table->string('tagline');
            $table->string('hero_title');
            $table->text('hero_description');
            $table->string('about_title');
            $table->text('about_text');
            $table->text('note');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('contact_location');
            $table->string('contact_instagram')->nullable();
            $table->text('contact_description');
            $table->string('cta_title');
            $table->text('cta_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
