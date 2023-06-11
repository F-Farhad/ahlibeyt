<?php

namespace App\View\Components;

use App\Models\Category;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class SideBar extends Component
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
        // $categories = Cache::remember('sidebarCategory', now()->addMinutes(5), function(){ 
            $categories = Category::query()
                        ->join('posts', function(JoinClause $join){             //for hard query use JoinClause
                            $join->on('categories.id', '=', 'posts.category_id')
                            ->where('posts.active', '=', true)
                            ->where('posts.published_at', '<=', Carbon::now());
                        })
                        ->select('categories.title', 'categories.slug') //, DB::raw('count(*) as total') //do it need to count?
                        ->groupBy('categories.id')
                        ->get();
        // });
        return view('components.side-bar', compact('categories'));
    }
}
