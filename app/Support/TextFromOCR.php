<?php

namespace App\Support;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use thiagoalessio\TesseractOCR\TesseractOCR;

class TextFromOCR
{
    /**
     * @var Unpaper
     */
    protected $unpaper;

    /**
     * TextFromOCR constructor.
     * @param Unpaper $unpaper
     */
    public function __construct(Unpaper $unpaper)
    {
        $this->unpaper = $unpaper;
    }

    public function read($file)
    {
        $this->convertToImages($file);

        $files = glob(dirname($file) . '/*.pnm');

        return collect($files)
            ->each(function ($file) {
                // @TODO Clean up image with unpaper or scantailor. First find a way to correctly parse the files
                // $this->unpaper->clean($file);
            })
            ->map(function ($file) {
                $result = (new TesseractOCR($file))->lang('nld')->run();

                 unlink($file);

                return $result;
            })
            ->implode("");
    }

    protected function convertToImages($file)
    {
        // 1. Convert it to a greyscale pnm
        $process = new Process([
            'convert',
            '-density', '300',
            '-depth', '8',
            '-type', 'Grayscale',
            $file,
            dirname($file) . '/convert-%04d.pnm',
        ]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}