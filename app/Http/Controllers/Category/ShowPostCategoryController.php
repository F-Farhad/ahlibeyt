<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowPostCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Category $category, Post $post)
    {
        if(!$post->active || $post->published_at > Carbon::now()){
            throw new NotFoundHttpException();
        }

        $next = $category->posts
                ->where('active', '=', 1)
                ->where('published_at', '<=', Carbon::now())
                ->sortByDesc('published_at')
                ->firstWhere('published_at', '<', $post->published_at);
                
        $prev = $category->posts
                ->where('active', '=', 1)
                ->where('published_at', '<=', Carbon::now())
                ->sortBy('published_at')
                ->firstWhere('published_at', '>', $post->published_at);

                
        $cookie_name = (\Illuminate\Support\Str::replace('.','',($request->ip())).'-'. $post->id);
            if(Cookie::get($cookie_name) == ''){                                                               //check if cookie is set
                $cookie = cookie($cookie_name, '1', 60);                                                     //set the cookie
                $post->increment('view_count');                                                             //count the view

                return response()
                    ->view('category.showPost', compact('post', 'category', 'next', 'prev'))
                    ->withCookie($cookie);                                                                      //store the cookie
            }else{
                return view('category.showPost', compact('post', 'category', 'next', 'prev'));                    //this view is not counted
            }
    }
}
