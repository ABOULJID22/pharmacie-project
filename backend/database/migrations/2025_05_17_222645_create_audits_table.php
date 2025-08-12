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
        Schema::create('audits', function (Blueprint $table) {
                $table->id('id_audit');
                $table->foreignId('id_demandeur')->constrained('users', 'id_user')->onDelete('cascade');
                $table->string('objet');
                $table->string('statut')->nullable();
                $table->text('rapport')->nullable();
                $table->timestamp('date_demande')->useCurrent();
                $table->timestamp('date_realisation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
