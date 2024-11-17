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
        Schema::create('file_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ownerId')->references('id')->on('users');
            $table->foreignId('groupId')->references('id')->on('groups');
            $table->string('name');
            $table->string('extension');
            $table->enum('status', ['available', 'underUse']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_infos');
    }
};
