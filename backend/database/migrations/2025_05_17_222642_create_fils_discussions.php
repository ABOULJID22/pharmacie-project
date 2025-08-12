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
        Schema::create('fils_discussions', function (Blueprint $table) {
            $table->id('id_fils');
            $table->string('sujet');
            $table->foreignId('id_createur')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_participant')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fils_discussions');
    }
};
