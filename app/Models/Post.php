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
     * @var
     * string content
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
     */
    public static function getMarkedParagraph($text, $searchExpressive){
        $searchExpressive = preg_replace('/\s+/', ' ', $searchExpressive);                //remove space
        $positionExpressive = mb_stripos($text, $searchExpressive);                      //search begin position
        $resultExpressive =  mb_substr($text, $positionExpressive, 300) ;                  //get paragraph included search expressive
        
        
        $resultExpressive = self::getMarkedText($resultExpressive, $searchExpressive);

        return $resultExpressive;
    }


    /**
     * the first argument takes a string, the second a substring to marked the text
     * '<span class="bg-[#4ade80] rounded">' - при поиске английских слов находит эту строку
     */
    public static function getMarkedText($text, $searchExpressive){
        $searchExpressive = preg_replace('/\s+/', ' ', $searchExpressive);                //remove space
        // dd($searchExpressive);

        $words = explode(' ', $searchExpressive);

        foreach($words as $key => $value){
            $marked_words[$key] = '<span class="bg-[#4ade80] rounded">' . $value . '</span>';
        }

        foreach($words as $key => $word){
            $words[$key] = "#$word#iu";
        }

        $resultExpressive = preg_replace($words, $marked_words, $text);

        return $resultExpressive;
    }


}
