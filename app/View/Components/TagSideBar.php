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
        $collections = Tag::query()
                        ->join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                        ->join('posts', function(JoinClause $join){             //for hard query use JoinClause
                            $join->on('post_tag.post_id', '=', 'posts.id')
                            ->where('posts.active', '=', true)
                            ->where('posts.published_at', '<=', Carbon::now());
                        })
                        ->select('tags.title', 'tags.slug') //, DB::raw('count(*) as total') //do it need to count?
                        ->groupBy([
                            'tags.id',
                            'tags.title',
                            'tags.slug',
                            'tags.created_at',
                            'tags.updated_at',
                        ])
                        ->get();

        $header = trans('ahlibeyt.all_tags');
        $route = 'tag.showAllPosts';
        $req = 'tag';
        return view('components.side-bar', compact('collections', 'header', 'route', 'req'));
    }
}
