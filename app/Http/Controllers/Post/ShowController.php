<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        if(!$post->active || $post->published_at > Carbon::now()){
            throw new NotFoundHttpException();
        }

        $next = Post::query()
                    ->where('active', '=', 1)
                    ->whereDate('published_at', '<=', Carbon::now())
                    ->orderBy('created_at', 'desc')
                    ->where('created_at', '<', $post->created_at)
                    ->limit(1)
                    ->first();

        $prev = Post::query()
                    ->where('active', 1)
                    ->whereDate('published_at', '<=', Carbon::now())
                    ->orderBy('created_at', 'asc')
                    ->where('created_at', '>', $post->created_at)
                    ->limit(1)
                    ->first();

        return view('post.show', compact('post', 'next', 'prev'));
    }
}
