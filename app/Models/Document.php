<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Tags\HasTags;

class Document extends Model
{
    use HasTags;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $dates = ['date'];

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    /**
     * @param Builder $query
     * @param $tags
     */
    public function scopeByTag(Builder $query, $tags)
    {
        if (! is_array($tags)) {
            $tags = [$tags];
        }

        $tags = array_filter($tags);

        if (!empty($tags)) {
            $query->withAnyTags($tags);
        }
    }
}
