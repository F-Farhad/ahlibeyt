<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'array',
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'short_content',
        'content',
        'active',
        'published_at',
        'user_id',
        'category_id',
        'view_count',
    ];

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function tags():BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function getFormattedDate(){
        return Carbon::parse($this->published_at);
    }

    public function getThumbnail(){
        return '/storage/' . $this->thumbnail;
    }

    /**
     * return text from json column
     * */
    public function getContent():string{
        $content = '';
        $arrBloks = json_decode($this->content, true);

        foreach($arrBloks as $arrBlock){
            if($arrBlock['type'] == 'content'){
                $content.= $arrBlock['data']['content'];
            }
        }
        return $content;
    }

    /**
     * returns paragraph with mark text
     * now is not working
     */
    public static function getMarkedParagraph($text, $searchExpressive){
        $searchExpressive = preg_replace('#\s+#', ' ', $searchExpressive);                //removing whitespace, tabulation
        $positionExpressive = mb_stripos($text, $searchExpressive);                      //search begin position
        $resultExpressive =  mb_substr($text, $positionExpressive);                  //get paragraph included search expressive
        
        
        $resultExpressive = self::getMarkedText($resultExpressive, $searchExpressive);

        return $resultExpressive;
    }


    /**
     * the first argument takes a string, the second a substring to marked the text
     * '<span class="bg-[#4ade80] rounded">' - при поиске английских слов находит эту строку
     */
    public static function getMarkedText($text, $searchExpressive){
        $searchExpressive = preg_replace('#\s+#', ' ', $searchExpressive);                //removing whitespace, tabulation

        $words = explode(' ', $searchExpressive);

        //remove all single letter
        //If the callback function returns true, the current value from array is returned into the result array.
        $words = array_filter($words, function ($v){
            return \Illuminate\Support\Str::length($v) > 1;
        });

        //create marked words
        foreach($words as $key => $value){
                $marked_words[$key] = '<span class="bg-green-400 rounded">' . $value . '</span>';
        }

        //create regex array
        foreach($words as $key => $word){
            $words[$key] = "#$word#iu";
        }

        $resultExpressive = preg_replace($words, $marked_words, $text);

        return $resultExpressive;
    }


}
