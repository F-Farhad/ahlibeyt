<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $latestPost = Post::query()
                        ->where('active', '=', true)
                        ->where('published_at', '<=', Carbon::now())
                        ->latest('published_at')
                        ->limit(1)
                        ->first();

        $popularPosts = Post::query()
                        ->where('active', '=', true)
                        ->where('published_at', '<=', Carbon::now())
                        ->orderBy('view_count', 'desc')
                        ->limit(5)
                        ->get();
        
        $popularCategories = Category::query()
                        ->with(['posts'])
                        ->whereHas('posts', function (Builder $query) {
                            $query
                                ->where('active', '=', true)
                                ->where('published_at', '<=', Carbon::now());
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

        return view('main.main', compact('latestPost', 'popularPosts', 'popularCategories'));
    }
}
