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
        Schema::create('faqs', function (Blueprint $table) {
             $table->id('id_question');
            $table->text('question');
            $table->text('reponse')->nullable();
            $table->enum('cible', ['publique', 'adherent'])->default('publique');
            $table->boolean('visible')->default(true);
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
