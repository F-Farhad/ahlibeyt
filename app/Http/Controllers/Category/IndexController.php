<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        $categories = Cache::remember('allPostsInCategory', now()->addMinutes(5), function(){ 
            return Category::query()
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
                        ->get();
        });
        return view('category.index', compact('categories'));
    }
}
