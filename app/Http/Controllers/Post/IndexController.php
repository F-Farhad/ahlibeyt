<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        $posts = Post::query()
                    ->where('active', '=', 1)
                    ->whereDate('published_at', '<', Carbon::now())
                    ->orderBy('published_at', 'desc')
                    ->paginate(1);
        return view('home', compact('posts'));
    }
}