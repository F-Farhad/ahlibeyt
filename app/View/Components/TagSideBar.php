<?php

namespace App\View\Components;

use App\Models\Tag;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\JoinClause;
use Illuminate\View\Component;

class TagSideBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
           $tags = Tag::query()
                        ->join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                        ->join('posts', function(JoinClause $join){             //for hard query use JoinClause
                            $join->on('post_tag.post_id', '=', 'posts.id')
                            ->where('posts.active', '=', true)
                            ->where('posts.published_at', '<=', Carbon::now());
                        })
                        ->select('tags.title', 'tags.slug') //, DB::raw('count(*) as total') //do it need to count?
                        ->groupBy('tags.id')
                        ->get();
        return view('components.tag-side-bar', compact('tags'));
    }
}
