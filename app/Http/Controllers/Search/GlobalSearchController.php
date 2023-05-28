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
        $data = $request->validate([
            'search_expression' => 'required|string'
        ]);


        $posts = Post::query()
                    ->where('active', '=', true)
                    ->where('published_at', '<=', Carbon::now())
                    ->latest('published_at')
                    ->where(function($query) use ($data) {
                        $query->where('title', 'like', "%$data[search_expression]%")
                              ->orWhere('short_content', 'like', "%$data[search_expression]%")
                              ->orWhere("content", 'like',  "%$data[search_expression]%");
                    })
                    ->paginate(10);

        return view('search.search', compact('posts'));
    }
}
