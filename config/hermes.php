<?php

return [
    /**
     * By default the package will assume that the pdftotext command is located at /usr/bin/pdftotext.
     *
     */
    'pdftotext_bin' => env('PDFTOTEXT_BIN', '/usr/bin/pdftotext'),
];