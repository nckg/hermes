<?php

namespace App\Jobs;

use App\Models\Document;
use App\Support\FileNameParser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    /**
     * Create a new job instance.
     *[
     * "name" => ""
     * "type" => "file"
     * "path" => "1--EZjAqhusJrMkIFOJyzYuRdiah8ZYsz"
     * "filename" => "20180731 - H Hartziekenhuis - Bevalling - luz,ziekenhuis"
     * "extension" => "pdf"
     * "timestamp" => 1538221502
     * "mimetype" => "application/pdf"
     * "size" => 2661459
     * "dirname" => ""
     * "basename" => "1--EZjAqhusJrMkIFOJyzYuRdiah8ZYsz"
     * ]
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $info = FileNameParser::parse($this->filename());

        $document = Document::create([
            'uid' => $this->id(),
            'title' => $info->title,
            'sender' => $info->sender,
            'date' => $info->date,
            'tags' => $info->tags,
        ]);

        CreateThumbnail::dispatch($document);
    }

    /**
     * @return mixed
     */
    protected function filename()
    {
        return $this->file['filename'];
    }

    /**
     * @return mixed
     */
    protected function id()
    {
        return $this->file['basename'];
    }
}
