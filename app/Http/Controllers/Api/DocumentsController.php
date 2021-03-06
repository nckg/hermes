<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transformers\DocumentCollectionTransformer;

class DocumentsController extends Controller
{
    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $filter = $request->input("filter");
        $models = Document::byTag(explode(',', $request->input('tag')))
            ->where(function ($query) use ($filter) {
                $query->where('title', 'like', "%{$filter}%");
                $query->orWhere('sender', 'like', "%{$filter}%");
                $query->orWhere('content', 'like', "%{$filter}%");
            })
            ->orderBy('date', 'desc')
            ->get();

        return (new DocumentCollectionTransformer($models))->transform();
    }

    public function destroy(Request $request)
    {
        Document::destroy($request->input('id'));
    }
}
