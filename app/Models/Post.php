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
     */
    public static function getMarkedParagraph($text, $searchExpression):string{

        $arraySearchExpression = self::getArraySearchExpression($searchExpression);

        //create regex array
        foreach($arraySearchExpression as $key => $word){
            $arraySearchExpression[$key] = "#\.?[^\.]*?($word)+.*?(?=\.)#iu";       //ищем до первой точки, пропуская все что не является точкой,искомое слово,пропускаю все слова после искомого, до первой точки
        }

        //kak tolko budet naydeno vyrazenie ili slovo, vyhodim iz cikla
        foreach($arraySearchExpression as $reg){
            preg_match($reg, $text, $arr);

            if(!empty($arr)){
                $text = str_replace('.', '', $arr[0] );     //удаляю точку в начале найденой подстроки
                break;
            }
        }

        //if arr empty return empty line, else will output all text from the post
        if (empty($arr)){
            return '';
        }

        $resultExpression = self::getMarkedText($text, $searchExpression);

        return $resultExpression;
    }


    /**
     * the first argument takes a string, the second a substring to marked the text
     * '<span class="bg-[#4ade80] rounded">' - при поиске английских слов находит эту строку
     */
    public static function getMarkedText($text, $searchExpression):string{

        $words = self::getArraySearchExpression($searchExpression);

        //create regular array
        foreach($words as $key => $value){
                $marked_words[$key] = '<span class="bg-hoverGreen rounded">' . $value . '</span>';
        }

        //create regex array
        foreach($words as $key => $word){
            $words[$key] = "#$word#iu";
        }

        $resultExpression = preg_replace($words, $marked_words, $text);

        return $resultExpression;
    }

    /**
     * This function get string and after returned an array strings
     */
    private static function getArraySearchExpression(string $searchExpression):array{
        $searchExpression = preg_replace('#\s+#u', ' ', $searchExpression);                                          //removing whitespace, tabulation
        $searchExpression = preg_replace("#[^а-яёА-ЯЁ 0-9]#u", '', $searchExpression);                            //deleting all characters except letters

        $words = explode(' ', $searchExpression);

        //remove all single letter
        //If the callback function returns true, the current value from array is returned into the result array.
        $arraySearchExpression = array_filter($words, function ($v){
            return \Illuminate\Support\Str::length($v) > 2;
        });

        //added full expression in array
        array_unshift($arraySearchExpression, $searchExpression);

        return $arraySearchExpression;
    }


}
