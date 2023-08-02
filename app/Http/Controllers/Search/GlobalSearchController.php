<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'search_expression' => 'required|regex:#^[а-яёА-ЯЁ 0-9 \s\-".:,\'_]+$#u'
        ]);

        $search_expression = preg_replace('#\s+#u', ' ', $data['search_expression']);                                //deleting whitespace & tabulation
        
        $search_expression = preg_replace("#[^а-яёА-ЯЁ 0-9]#u", '', $search_expression);  
                                  //deleting all characters except letters
        $words = explode(' ', mb_strtolower($search_expression));

        $search_words = null;

        $search_words = array_filter($words, fn($n)=>\Illuminate\Support\Str::length($n) > 2);                       //deleting all letter < 2

        $posts = collect();
        if(empty($search_words)){
            return view('search.search', compact('posts'));
        }


        $posts = Post::query()
                    ->where('active', '=', true)
                    ->where('published_at', '<=', Carbon::now())
                    ->latest('published_at')
                    ->where(function($query) use ($search_words) {
                        foreach ($search_words as $key => $value) {
                            if($key == 0){
                                $query->where('title', 'LIKE', '%'. $value .'%')
                                ->orWhere('short_content', 'LIKE', '%'. $value .'%')
                                ->orWhere("content", 'LIKE',  '%'.$value .'%');
                            }else{
                                $query->orWhere('title', 'LIKE', '%'. $value .'%')
                                ->orWhere('short_content', 'LIKE', '%'. $value .'%')
                                ->orWhere("content", 'LIKE',  '%'. $value .'%');
                            }
     
                        }
                    })
                ->paginate(10);

        return view('search.search', compact('posts'));
    }
}
