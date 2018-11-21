<?php

namespace App\Console\Commands;

use App\Jobs\ProcessFile;
use App\Models\Document;
use App\Support\FileProcessor;
use App\Support\FileNameParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseDocumentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses documents in the consumption directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get directory
        $files = collect(Storage::listContents('/', false))
            // Only list files
            ->where('type', '=', 'file')
            // Remove documents that exist in the database
            ->filter(function ($file) {
                return Document::where('uid', $file['basename'])->count() == 0;
            })
            // Parse each document
            ->each(function ($file) {
                $this->info($file['filename']);

                ProcessFile::dispatch($file);
//                try {
//                    $readStream = Storage::getDriver()->readStream($file['path']);
//                    Storage::disk('tmp')->put($file['name'], stream_get_contents($readStream));
//
//                    $processor = app()->make(FileProcessor::class);
//                    $text = $processor->process(storage_path('tmp') . DIRECTORY_SEPARATOR . $file['name']);
//
//                    $document->update(['content' => $text]);
//
//                    Storage::delete($file['name']);
//                } catch (\Exception $e) {
//                }
            });
    }
}
