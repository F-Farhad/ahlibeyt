<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        // $posts = Cache::remember('posts', now()->addMinutes(5), function(){ 
            $posts = Post::query()
                        ->where('active', '=', 1)
                        ->whereDate('published_at', '<=', Carbon::now())
                        ->orderBy('published_at', 'desc')
                        ->paginate(10);
        // });
        
        return view('post.index', compact('posts'));
    }
}
