<?php

namespace App\Http\Controllers;

use App\Jobs\ParseDocument;
use App\Models\Document;
use App\Models\Transformers\DocumentCollectionTransformer;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class DocumentsController extends Controller
{
    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $models = Document::byTag($request->input('tag'))->orderBy('created_at', 'asc')->get();

        return view('documents.index')->with([
            'models' => (new DocumentCollectionTransformer($models))->transform(),
            'tags' => Tag::all()->sortBy('name'),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->file('file')->move(storage_path('files'), $request->file('file')->getClientOriginalName());
        return redirect()->route('documents.index');
    }

    /**
     * @param $id
     * @return $this
     */
    public function show($id)
    {
        $model = Document::find($id);

        return view('documents.show')->with(compact('model'));
    }
}
