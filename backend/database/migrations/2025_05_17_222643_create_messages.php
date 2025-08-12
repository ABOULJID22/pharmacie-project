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
        Schema::create('messages', function (Blueprint $table) {
        $table->id('id_message');
        
        $table->text('message')->nullable();
        $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
        $table->foreignId('id_fils')->constrained('fils_discussions', 'id_fils')->onDelete('cascade');
        $table->foreignId('id_auteur')->constrained('users', 'id_user')->onDelete('cascade');
        $table->string('image_path')->nullable();
        $table->timestamp('date_envoi')->useCurrent();
        $table->boolean('statut_lecture')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
