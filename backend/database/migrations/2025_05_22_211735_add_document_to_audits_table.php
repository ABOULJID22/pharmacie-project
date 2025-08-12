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
        Schema::table('audits', function (Blueprint $table) {
            $table->unsignedBigInteger('id_document')->nullable()->after('id_demandeur');
            $table->foreign('id_document')->references('id_document')->on('documents')->onDelete('set null');
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropForeign(['id_document']);
            $table->dropColumn('id_document');        });
    }
};
