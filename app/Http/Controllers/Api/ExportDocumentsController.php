<?php

namespace App\Http\Controllers\Api;

use ZipArchive;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExportDocumentsController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function store(Request $request)
    {
        $documents = Document::find($request->input('id'));

        $archive = new ZipArchive;
        $dir = Storage::getDriver()->getAdapter()->getPathPrefix();
        $filename = now();
        $file = "{$dir}{$filename->toDateTimeString()}.zip";
        $archive->open($file, ZipArchive::CREATE);

        // create zip with documents in it
        $documents->each(function (Document $document) use ($archive) {
            $media = $document->getFirstMedia();
            $archive->addFile($media->getPath(), $media->file_name);
        });

        $archive->close();

        return response()->download($file)->deleteFileAfterSend(true);
    }
}
