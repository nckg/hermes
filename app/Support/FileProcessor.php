<?php

namespace App\Support;

use Spatie\PdfToText\Pdf;

class FileProcessor
{
    /**
     * @var Pdf
     */
    private $pdfToText;
    /**
     * @var TextFromOCR
     */
    private $textFromOCR;

    /**
     * FileProcessor constructor.
     * @param Pdf $pdfToText
     * @param TextFromOCR $textFromOCR
     */
    public function __construct(Pdf $pdfToText, TextFromOCR $textFromOCR)
    {
        $this->pdfToText = $pdfToText;
        $this->textFromOCR = $textFromOCR;
    }

    /**
     * @param $file
     * @return string
     * @throws \Exception
     */
    public function process($file)
    {
        try {
            $string = $this->pdfToText->setPdf($file)->text();

            if (strlen($string) < 50) {
                throw new NoTextFound("No text was found");
            }
        } catch (\Exception $exception) {
            $string = $this->textFromOCR->read($file);
        }

        return $this->normalizeText($string);
    }


    public function normalizeText($string)
    {
        $string = iconv('UTF-8', 'UTF-8//IGNORE', $string);

        return iconv('UTF-8', 'UTF-8//TRANSLIT', $string);
    }
}
