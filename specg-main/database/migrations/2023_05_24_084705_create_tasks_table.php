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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('taskname');
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('projectid')->nullable();
            $table->unsignedBigInteger('creatorid')->nullable();
            $table->unsignedBigInteger('assigneeid')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('projectid')->references('id')->on('projects')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('creatorid')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('assigneeid')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
