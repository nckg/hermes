<?php

namespace App\Console\Commands;

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
            ->where('type', '=', 'file')
            ->filter(function ($file) {
                return Document::where('uid', $file['basename'])->count() == 0;
            })
            ->each(function ($file) {
                $this->info($file['filename']);
                $fileParser = FileNameParser::parse($file['filename']);
                $document = Document::create([
                    'uid' => $file['basename'],
                    'title' => $fileParser->title,
                    'sender' => $fileParser->sender,
                    'date' => $fileParser->date,
                    'tags' => $fileParser->tags,
                ]);

                if (config('hermes.skip_ocr')) {
                    return;
                }

                try {
                    $readStream = Storage::getDriver()->readStream($file['path']);
                    Storage::disk('tmp')->put($file['name'], stream_get_contents($readStream));

                    $processor = app()->make(FileProcessor::class);
                    $text = $processor->process(storage_path('tmp') . DIRECTORY_SEPARATOR . $file['name']);

                    $document->update(['content' => $text]);

                    Storage::delete($file['name']);
                } catch (\Exception $e) {
                }
            });
    }
}
