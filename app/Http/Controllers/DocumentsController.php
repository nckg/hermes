<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentsController extends Controller
{
    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        return view('documents.index')->with([
            'tags' => Tag::query()
                ->join('taggables', 'taggables.tag_id', 'tags.id')
                ->select('tags.name', 'tags.id', DB::raw('COUNT("taggables.taggable_id") AS count'))
                ->groupBy('taggables.tag_id', 'tags.name', 'tags.id')
                ->orderByDesc('count')
                ->get(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $files = $request->file('file');

        if (! is_array($files)) {
            $files = [$files];
        }

        collect($files)->each(function ($file) {
            $file->move(storage_path('files'), $file->getClientOriginalName());
        });

        return redirect()->route('documents.index');
    }

    public function update(Request $request, $id)
    {
        $model = $this->find($id);

        $model->update($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function find($id)
    {
        return Document::find($id);
    }
}
