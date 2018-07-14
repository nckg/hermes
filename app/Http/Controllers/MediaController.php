<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function show($id, Request $request)
    {
        // Stream the file to the browser...
        $document = Document::find($id);

        $file = collect(Storage::listContents('/', false))
            ->where('type', '=', 'file')
            ->where('basename', '=', $document->uid)
            ->first();

        $readStream = Storage::cloud()->getDriver()->readStream($document->uid);

        return response()->stream(function () use ($readStream) {
            fpassthru($readStream);
        }, 200, [
            'Content-Type' => $file['mimetype'],
            'Content-disposition' => $request->has('download') ? 'attachment; filename="'.$file['name'].'"' : null,
        ]);
    }
}
