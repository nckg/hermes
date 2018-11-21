<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class CreateThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Document
     */
    protected $document;

    /**
     * Create a new job instance.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Spatie\PdfToImage\Exceptions\PdfDoesNotExist
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function handle()
    {
        $this->downloadPdf();
        $pathToImage = $this->extractImage();
        $this->cropImage($pathToImage);
        $this->deletePdf();
    }

    protected function downloadPdf(): void
    {
        $readStream = Storage::getDriver()->readStream($this->document->uid);
        Storage::disk('tmp')->put($this->document->uid, stream_get_contents($readStream));
    }

    /**
     * @return string
     * @throws \Spatie\PdfToImage\Exceptions\PdfDoesNotExist
     */
    protected function extractImage(): string
    {
        $dir = Storage::disk('tmp')->getDriver()->getAdapter()->getPathPrefix();
        $pdf = new \Spatie\PdfToImage\Pdf($dir . DIRECTORY_SEPARATOR . $this->document->uid);
        $pathToImage = storage_path("app/public/{$this->document->uid}.jpg");
        $pdf->saveImage($pathToImage);
        return $pathToImage;
    }

    /**
     * @param $pathToImage
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    protected function cropImage($pathToImage): void
    {
        Image::load($pathToImage)
            ->fit(Manipulations::FIT_CONTAIN, 400, 600)
            ->save();
    }

    protected function deletePdf(): void
    {
        Storage::disk('tmp')->delete($this->document->uid);
    }
}
