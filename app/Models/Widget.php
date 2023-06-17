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

    /**
     * @var string $key - uniq key a widget
     * @var string $field - field from the table widgets
     * 
     */
    public static function getWidget(string $key, string $field) {
        // $widget = Cache::remember('widget-' . $key, now()->addMinutes(1), function() use($key){
        $widget = Widget::where('key', '=', $key)
                        ->where('active', '=', 1)
                        ->first();
        // });

        if(isset($widget, $widget->$field)){
            return $widget->$field;
        }

        return '';
    }
}
