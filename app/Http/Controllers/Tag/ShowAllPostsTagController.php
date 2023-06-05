<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ShowAllPostsTagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Tag $tag): View
    {
        $posts = Cache::remember('tag_'.$tag->title, now()->addMinutes(5), function() use($tag){ 
            return $tag->posts()
                        ->where('active', '=', 1)
                        ->whereDate('published_at', '<=', Carbon::now())
                        ->orderBy('published_at', 'desc')
                        ->paginate(10);
        });
        return view('tag.showAllPosts', compact('posts', 'tag'));
    }
}
