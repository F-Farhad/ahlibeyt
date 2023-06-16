<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'key',
        'title',
        'thumbnail',
        'content',
        'active',
    ];

    public static function getTitle(string $key): string{
        $widget = Cache::remember('widget-' . $key, now()->addMinutes(1), function() use($key){
            return Widget::where('key', '=', $key)
                        ->where('active', '=', 1)
                        ->first();
        }); 

        if($widget){
            return $widget->title;
        }

        return '';
    }

    public static function getContent(string $key): string{
        $widget = Cache::remember('widget-' . $key, now()->addMinutes(1), function() use($key){
            return Widget::where('key', '=', $key)
                        ->where('active', '=', 1)
                        ->first();
        }); 

        if(!is_null($widget == null)){
            return $widget->content;
        }

        return '';
    }

    public static function getThumbnail(string $key): string{
        // $widget = Cache::remember('widget-' . $key, now()->addMinutes(1), function() use($key){
            $widget=  Widget::where('key', '=', $key)
                        ->where('active', '=', 1)
                        ->first();
            if($widget){
                return $widget->thumbnail;
            }
    
            return '';
        // }); 

        // if($widget){
        //     return $widget->content;
        // }

        // return '';
    }


}
