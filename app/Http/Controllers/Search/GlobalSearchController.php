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
            'search_expression' => 'regex:#^[а-яёА-ЯЁ 0-9]+$#u'            //надо ограничить до нескольких слов иначе запрос будет огромным 'regex:/^.+@.+$/i'
        ]);

        $data['search_expression'] = preg_replace('/\s+/', ' ', $data['search_expression']);

        $words = explode(' ', $data['search_expression']);

        $search_words = null;
                                //remove all single letter
        foreach($words as $word){
            if(\Illuminate\Support\Str::length($word) > 1){
                $search_words[] = $word;
            }
        }

        if(empty($search_words)){
            return redirect()->route('main');
        }

        // https://stackoverflow.com/questions/63657507/laravel-unable-to-get-array-of-strings-searched-from-the-database


        $posts = Post::query()
                    ->where('active', '=', true)
                    ->where('published_at', '<=', Carbon::now())
                    ->latest('published_at')
                    ->where(function($query) use ($data, $search_words) {
                        foreach ($search_words as $key => $value) {
                            if($key == 0){
                                $query->where('title', 'like', "%{$value}%")
                                ->orWhere('short_content', 'like', "%$value%")
                                ->orWhere("content", 'like',  "%$value%");
                            }else{
                                $query->orWhere('title', 'like', "%$value%")
                                ->orWhere('short_content', 'like', "%$value%")
                                ->orWhere("content", 'like',  "%$value%");
                            }
     
                        }
                    })
                    ->paginate(10);

        return view('search.search', compact('posts'));
    }
}
