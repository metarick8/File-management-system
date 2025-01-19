<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->unsignedBigInteger('ownerId');
            $table->unsignedBigInteger('groupId');
            $table->string('name');
            $table->string('extension');
            $table->boolean('accepted')->default(false);
            $table->boolean('isFree')->default(true);
            // $table->enum('status', ['available', 'underUse']);
            $table->string('path');
            $table->foreign('ownerId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('groupId')->references('id')->on('groups')->onDelete('cascade');
            $table->timestamps();
            // $table->unique(['groupId', 'name', 'extension']);
            // ensure uniqueness only when accepted api

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
