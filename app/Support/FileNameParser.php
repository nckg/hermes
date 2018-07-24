<?php

namespace App\Support;

use Carbon\Carbon;

class FileNameParser
{
    public $date;
    public $sender;
    public $title;
    public $tags;
    protected $filename;

    /**
     * FileNameParser constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->parseName();
    }

    /**
     * Date - Correspondent - Title - tag,tag,tag.pdf
     */
    public static function parse($filename)
    {
        return new static($filename);
    }

    public function parseName()
    {
        $parts = explode(' - ', $this->filename);
        $this->date = Carbon::parse($parts[0]);
        $this->sender = $parts[1];
        $this->title = $parts[2];
        $this->tags = explode(',', $parts[3]);
    }
}
