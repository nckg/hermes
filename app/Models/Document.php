<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

        if (! empty($tags)) {
            $query->withAnyTags($tags);
        }
    }
}
