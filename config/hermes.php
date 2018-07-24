<?php

return [
    /**
     * By default the package will assume that the pdftotext command is located at /usr/bin/pdftotext.
     *
     */
    'pdftotext_bin' => env('PDFTOTEXT_BIN', '/usr/bin/pdftotext'),
    'unpaper_bin' => env('UNPAPER_BIN', '/usr/bin/unpaper'),
    'skip_ocr' => env('SKIP_OCR', true),
];
