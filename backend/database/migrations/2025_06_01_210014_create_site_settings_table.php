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
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('x')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('image_accueil')->nullable();
            $table->text('text_propos')->nullable();
            $table->string('title_propos')->nullable();
            $table->string('img1_propos')->nullable();
            $table->string('img2_propos')->nullable();
            $table->string('img3_propos')->nullable();
            $table->string('img4_propos')->nullable();
            $table->string('video_service')->nullable();
            $table->text('text_service')->nullable();
            $table->string('title_service')->nullable();
            $table->text('text_contact')->nullable();
            $table->string('title_contact')->nullable();
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
