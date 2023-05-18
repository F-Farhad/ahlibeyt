<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Tag $tag, Post $post)
    {
        if(!$post->active || $post->published_at > Carbon::now()){
            throw new NotFoundHttpException();
        }

        $next = $tag->posts
                ->where('active', '=', 1)
                ->where('published_at', '<=', Carbon::now())
                ->sortByDesc('created_at')
                ->firstWhere('created_at', '<', $post->created_at);
                
        $prev = $tag->posts
                ->where('active', '=', 1)
                ->where('published_at', '<=', Carbon::now())
                ->sortBy('created_at')
                ->firstWhere('created_at', '>', $post->created_at);

        return view('tag.show', compact('post', 'tag', 'next', 'prev'));
    }
}
