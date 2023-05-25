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
                    // ->where('active', '=', true)
                    // ->where('published_at', '<=', Carbon::now())
                    // ->latest('published_at')
                    ->where(function($query) use ($q) {
                        // $query->where('title', 'like', "%$q%")
                        //       ->orWhere('short_content', 'like', "%$q%")
                        $query->where("content->data->content", 'like', "%$q%");
                        // $query->whereJsonContains("content", [['type' => 'content','data' => ['content' => "%$q%"]]]);
                    })
                    ->paginate(10);  
                    // ->dd();
                    // $result = Table::where(“json_data->$id” ,$reqid)->get();
                    //->whereJsonContains('to', [['emailAddress' => ['address' => 'test@example.com']]])
                    // https://stackoverflow.com/questions/74202855/search-in-json-column-not-working-in-laravel
                    // https://stackoverflow.com/questions/70324385/json-column-query-using-laravel-builder

        return view('search.search', compact('posts'));
    }
}
