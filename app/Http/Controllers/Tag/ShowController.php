<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Tag $tag)
    {
        $posts = $tag->posts()
                            ->where('active', '=', 1)
                            ->whereDate('published_at', '<=', Carbon::now())
                            ->orderBy('published_at', 'desc')
                            ->paginate(10);
        return view('home', compact('posts'));
    }
}
