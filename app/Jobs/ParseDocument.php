<?php

namespace App\Jobs;

use App\Models\Document;
use App\Support\FileNameParser;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use thiagoalessio\TesseractOCR\TesseractOCR;

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
     * @return void
     */
    public function handle()
    {
        // @TODO check for doubles
        // Create a document and save to db
        $file = new File($this->file);
        $fileParser = FileNameParser::parse($file->getBasename());
        $document = Document::create([
            'title' => $fileParser->title,
            'sender' => $fileParser->sender,
            'date' => $fileParser->date,
            'tags' => $fileParser->tags,
        ]);
        $media = $document->addMedia($file)->toMediaCollection();
        $document->update(['content' => $this->getText($media, $document)]);
    }

    /**
     * @param $media
     * @return string
     * @throws PdfNotFound
     */
    protected function pdfToText($media): string
    {
        return (new Pdf(config('hermes.pdftotext_bin')))
            ->setPdf($media->getPath())
            ->text();
    }

    /**
     * @param $media
     * @param $document
     * @return string
     */
    protected function getText($media, $document): string
    {
        try {
            $text = $this->pdfToText($media);

            if (strlen($text) < 50) {
                throw new \Exception("No text was found");
            }
        } catch (\Exception $e) {
            // 1. Convert it to a greyscale pnm
            $process = new Process([
                'convert',
                '-density', '300',
                '-depth', '8',
                '-type', 'Grayscale',
                $document->getFirstMedia()->getPath(),
                $document->getDirectory() . '/convert-%04d.pnm',
            ]);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $files = glob(dirname($media->getPath()) . '/*.pnm');

            $text = collect($files)
                ->map(function ($pnm) {
                    return (new TesseractOCR($pnm))->lang('nld')->run();
                })
                ->implode("");

            collect($files)->each(function ($file) {
                unlink($file);
            });
        }

        $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);

        return iconv('UTF-8', 'UTF-8//TRANSLIT', $text);
    }
}
