<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Post $post)
    {
        if(!$post->active || $post->published_at > Carbon::now()){
            throw new NotFoundHttpException();
        }

        $next = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $prev = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)
            ->first();

        $cookie_name = (\Illuminate\Support\Str::replace('.','',($request->ip())).'-'. $post->id);
        if(Cookie::get($cookie_name) == ''){                                                            //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60);                                                    //set the cookie
            $post->increment('view_count');                                                             //count the view
            return response()
                ->view('post.show', compact('post', 'next', 'prev'))
                ->withCookie($cookie);                                                                      //store the cookie
        }else{
            return view('post.show', compact('post', 'next', 'prev'));                                  //this view is not counted
        }
    }
}
