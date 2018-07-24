<?php

namespace App\Models;

use Spatie\Tags\Tag as Model;

class Tag extends Model
{
    public $translatable = [];

    public function taggables()
    {
        return $this->hasMany('taggables');
    }

    public static function findFromString(string $name, string $type = null, string $locale = null)
    {
        return static::query()
            ->where('name', $name)
            ->where('type', $type)
            ->first();
    }

    public function setAttribute($key, $value)
    {
        return \Illuminate\Database\Eloquent\Model::setAttribute($key, $value);
    }

    public static function bootHasSlug()
    {
        static::saving(function (Model $model) {
            $model->slug = $model->generateSlug('');
        });
    }

    protected static function findOrCreateFromString(string $name, string $type = null, string $locale = null): Model
    {
        $tag = static::findFromString($name, $type, $locale);

        if (! $tag) {
            $tag = static::create([
                'name' => $name,
                'type' => $type,
            ]);
        }

        return $tag;
    }

    protected function generateSlug(string $locale): string
    {
        $slugger = config('tags.slugger');

        $slugger = $slugger ?: 'str_slug';

        return call_user_func($slugger, $this->name);
    }
}
