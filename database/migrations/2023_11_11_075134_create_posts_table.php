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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('logo')->nullable();
            $table->text('body')->nullable();
            $table->string('tags')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->integer('upvote')->nullable()->default(0);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
