<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['page', 'section', 'key', 'value'];

    public static function get($page, $section, $key, $default = '')
    {
        $content = self::where('page', $page)
            ->where('section', $section)
            ->where('key', $key)
            ->first();
        
        return $content ? $content->value : $default;
    }
}
