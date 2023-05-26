<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlobalSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $q = $request->get('q');

        $posts = Post::query()
                    ->where('active', '=', true)
                    ->where('published_at', '<=', Carbon::now())
                    ->latest('published_at')
                    ->where(function($query) use ($q) {
                        $query->where('title', 'like', "%$q%")
                              ->orWhere('short_content', 'like', "%$q%")
                              ->orWhere("content", 'like',  "%$q%");
                    })
                    ->paginate(10);

        return view('search.search', compact('posts'));
    }
}
