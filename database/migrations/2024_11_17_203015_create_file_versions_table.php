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
        Schema::create('file_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('editorId');
            $table->unsignedBigInteger('fileInfoId');
            $table->string('path')->nullable();
            $table->foreign('editorId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fileInfoId')->references('id')->on('file_infos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_versions');
    }
};
