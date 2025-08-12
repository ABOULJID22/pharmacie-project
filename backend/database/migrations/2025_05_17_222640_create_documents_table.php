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
        Schema::create('documents', function (Blueprint $table) {
           $table->id('id_document');
        $table->string('nom_fichier');
        $table->string('type')->nullable();
        $table->text('url_storage')->nullable();
        $table->text('file_path')->nullable();
        $table->integer('file_size')->nullable();
        $table->integer('pages_count')->nullable();
        $table->string('status')->default('brouillon');
        $table->timestamp('date_upload')->useCurrent();
        $table->foreignId('id_uploader')->constrained('users', 'id_user')->onDelete('cascade');
        $table->timestamps();
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_models');
    }
};
