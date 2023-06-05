<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ShowAllPostsCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Category $category): View
    {
        $posts = Cache::remember('category_'.$category->title, now()->addMinutes(5), function() use($category){
            return $category->posts()
                            ->where('active', '=', 1)
                            ->whereDate('published_at', '<=', Carbon::now())
                            ->orderBy('published_at', 'desc')
                            ->paginate(10);
        });
        return view('category.showAllPosts', compact('posts', 'category'));
    }
}
