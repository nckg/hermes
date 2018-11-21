<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $filter = $request->input("filter");
        $models = Tag::where('name', 'like', "%{$filter}%")
            ->orderBy('name', 'desc')
            ->get();

        return $models->map(function ($tag) {
            return [
                'id' => $tag->id,
                'slug' => $tag->slug,
                'name' => $tag->name,
            ];
        });
    }
}
