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
     * don't work: 
     * 1. with single letter
     * 2. with english alphabet 
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'search_expression' => 'required|regex:#^[а-яёА-ЯЁ 0-9]+$#u'                                 //restrict count words?
        ]);

        $data['search_expression'] = preg_replace('/\s+/', ' ', $data['search_expression']);            //removing whitespace & tabulation

        $words = explode(' ', $data['search_expression']);

        $search_words = null;
                                
        foreach($words as $word){                               //removing all single letter
            if(\Illuminate\Support\Str::length($word) > 2){
                $search_words[] = $word;
            }
        }
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
