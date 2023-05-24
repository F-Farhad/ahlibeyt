<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'array',
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'short_content',
        'content',
        'active',
        'published_at',
        'user_id',
        'category_id',
        'view_count',
    ];

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function tags():BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function getFormattedDate(){
        return Carbon::parse($this->published_at);
    }

    public function getThumbnail(){
        if(str_starts_with($this->thumbnail, 'http')){
            return $this->thumbnail;
        }
            return '/storage/' . $this->thumbnail;
    }

}
