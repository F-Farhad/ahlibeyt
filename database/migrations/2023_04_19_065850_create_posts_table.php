<?php

use App\Models\Category;
use App\Models\User;
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
            $table->string('title', 2048);
            $table->string('slug', 2048);
            $table->string('thumbnail', 2048)->nullable();
            $table->json('content')->nullable();
            $table->boolean('active')->default(false);
            $table->datetime('published_at')->nullable();
            $table->foreignIdFor(Category::class, 'category_id');
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
