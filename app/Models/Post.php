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
        $positionExpressive = mb_stripos($text, $searchExpressive);                      //search begin position
        $resultExpressive = mb_substr($text, $positionExpressive, 200);                  //get paragraph included search expressive
        
        
        $resultExpressive = self::getMarkedText($resultExpressive, $searchExpressive);

        return $resultExpressive;
    }


    /**
     * the first argument takes a string, the second a substring to marked the text
     */
    public static function getMarkedText($text, $searchExpressive){

        $replace = "<span class='bg-green-400 rounded'>" . $searchExpressive . "</span>";
        $resultExpressive = preg_replace('#.*' . $searchExpressive . '.*?#iu', $replace, $text);

        return $resultExpressive;
    }




}
