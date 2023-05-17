<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Category $category): View
    {
        $posts = $category->posts()
                            ->where('active', '=', 1)
                            ->whereDate('published_at', '<=', Carbon::now())
                            ->orderBy('published_at', 'desc')
                            ->paginate(10);
        return view('category.show', compact('posts', 'category'));
    }
}
