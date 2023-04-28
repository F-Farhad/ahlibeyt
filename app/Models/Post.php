<?php

namespace App\Models;

use Doctrine\DBAL\Types\JsonType;
use Illuminate\Database\Eloquent\Casts\Json;
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
    ];

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function tags():BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function getFormattedDate(){
        return $this->published_at->format('F jS Y');
    }

    public function getThumbnail(){
        if(str_starts_with($this->thumbnail, 'http')){
            return $this->thumbnail;
        }
            return '/store/' . $this->thumbnail;
    }

}
