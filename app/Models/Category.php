<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
    ];

    public function posts():HasMany{
        return $this->hasMany(Post::class);
    }

    public function publishedPosts($latestPost):HasMany{
        return $this->hasMany(Post::class)
                    ->where('id', '<>', $latestPost->id)
                    ->where('active', '=', 1)
                    ->whereDate('published_at', '<=', Carbon::now())
                    ->latest('published_at');
    }
}
