<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Post $post, string $searchExpression)
    {
        if(!$post->active || $post->published_at > Carbon::now()){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
        
        $cookie_name = (\Illuminate\Support\Str::replace('.','',($request->ip())).'-'. $post->id);
        if(Cookie::get($cookie_name) == ''){                                                            //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60);                                                    //set the cookie
            $post->increment('view_count');                                                             //count the view
            return response()
                ->view('search.show', compact('post', 'searchExpression'))
                ->withCookie($cookie);                                                                      //store the cookie
        }else{
            return view('search.show', compact('post', 'searchExpression'));                                //this view is not counted
        }
    }
}
