<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Tag $tag): View
    {
        $posts = $tag->posts()
                            ->where('active', '=', 1)
                            ->whereDate('published_at', '<=', Carbon::now())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        return view('tag.index', compact('posts', 'tag'));
    }
}
