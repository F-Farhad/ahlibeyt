<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
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
                ->sortByDesc('published_at')
                ->firstWhere('published_at', '<', $post->published_at);

        $prev = $tag->posts
                ->where('active', '=', 1)
                ->where('published_at', '<=', Carbon::now())
                ->sortBy('published_at')
                ->firstWhere('published_at', '>', $post->published_at);

        return view('tag.show', compact('post', 'tag', 'next', 'prev'));
    }
}
