<?php

namespace App\Jobs;

use App\Models\Document;
use App\Support\FileNameParser;
use App\Support\FileProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $file;

    /**
     * Create a new job instance.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @param FileProcessor $processor
     * @return void
     * @throws \Exception
     */
    public function handle(FileProcessor $processor)
    {
        // Create a document and save to db
        $file = new File($this->file);
        $document = $this->create($file->getBasename());
        $document->addMedia($file)->toMediaCollection();
        $document->update(['content' => $processor->process($document->getFirstMedia()->getPath())]);
    }

    /**
     * @param $path
     * @return mixed
     */
    public function create($path)
    {
        $fileParser = FileNameParser::parse($path);
        return Document::create([
            'title' => $fileParser->title,
            'sender' => $fileParser->sender,
            'date' => $fileParser->date,
            'tags' => $fileParser->tags,
        ]);
    }
}
