<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Support\FileNameParser;

class FileNameParserTest extends TestCase
{
    /** @test */
    public function it_can_parse_filename()
    {
        $result = FileNameParser::parse('2018-01-02 - Correspondent - Invoice 2018 - foo,bar,baz');
        $this->assertEquals('2018/01/02', $result->date->format('Y/m/d'));
        $this->assertEquals('Correspondent', $result->sender);
        $this->assertEquals('Invoice 2018', $result->title);
        $this->assertEquals(['foo', 'bar', 'baz'], $result->tags);
    }
}
