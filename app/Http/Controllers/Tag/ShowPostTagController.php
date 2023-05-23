<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowPostTagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Tag $tag, Post $post)
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

        $cookie_name = (\Illuminate\Support\Str::replace('.','',($request->ip())).'-'. $post->id);
        if(Cookie::get($cookie_name) == ''){                                                         //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60);                                                     //set the cookie
            $post->increment('view_count');                                                             //count the view

            return response()
                ->view('tag.showPost', compact('post', 'tag', 'next', 'prev'))
                ->withCookie($cookie);                                                                      //store the cookie
        }else{
            return view('tag.showPost', compact('post', 'tag', 'next', 'prev'));                        //this view is not counted
        }
    }
}
