<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $latestPost = Cache::remember('latestPost', now()->addMinutes(5), function(){
            $latestPost = Post::query()
                        ->where('active', '=', true)
                        ->where('published_at', '<=', Carbon::now())
                        ->latest('published_at')
                        ->limit(1)
                        ->first();
        // });
        

        // $popularPosts = Cache::remember('popularPosts', now()->addMinutes(60), function(){
            // return Post::query()
            $popularPosts = Post::query()
                        ->where('active', '=', true)
                        ->where('published_at', '<=', Carbon::now())
                        ->orderBy('view_count', 'desc')
                        ->limit(5)
                        ->get(); 
        // });
        
        $idLatestPost = $latestPost->id ?? -1;      //if category have 1 post, which is last added on site, hide it, because it post will show how latest post
        // $latestPostInCategories = Cache::remember('latestPostsInCategory', now()->addMinutes(60), function() use($latestPost){
            $latestPostInCategories = Category::query()
                        ->whereHas('posts', function (Builder $query) use($idLatestPost){
                            $query
                                ->where('active', '=', true)
                                ->where('published_at', '<=', Carbon::now())
                                ->where('id', '<>', $idLatestPost);
                        })
                        ->select('categories.*')
                        ->selectRaw('MAX(posts.published_at) as max_date')
                        ->join('posts', 'categories.id', '=', 'posts.category_id')
                        ->orderBy('max_date', 'desc')
                        ->groupBy([
                            'categories.id',
                            'categories.title',
                            'categories.slug',
                            'categories.created_at',
                            'categories.updated_at',
                        ])
                        ->limit(3)
                        ->get();
        // });
        
        return view('main.main', compact('latestPost', 'popularPosts', 'latestPostInCategories'));
    }
}
