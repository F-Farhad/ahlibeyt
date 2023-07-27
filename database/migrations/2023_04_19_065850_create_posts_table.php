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
            $table->string('title');
            $table->string('slug')->unique('posts_slug_unique');
            $table->string('thumbnail')->nullable();
            $table->text('short_content');
            $table->json('content')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->boolean('active')->default(false);
            $table->datetime('published_at')->nullable();
            $table->foreignIdFor(Category::class, 'category_id')->index('posts_category_id_index')->constrained();
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
