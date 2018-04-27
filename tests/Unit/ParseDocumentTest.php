<?php

namespace Tests\Unit;

use App\Jobs\ParseDocument;
use App\Support\FileProcessor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;

class ParseDocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_parse_documents()
    {
        $file = $this->getTestFilesDirectory('20180308 - Foobar Bazbar - Invoice March 2018 - invoice,foobar,baz,bar.pdf');

        $processor = m::mock(FileProcessor::class);
        $processor->shouldReceive('process')
            ->withArgs([base_path('tests/temp/media/1/20180308---Foobar-Bazbar---Invoice-March-2018---invoice,foobar,baz,bar.pdf')])
            ->andReturn('Hello World');

        $job = new ParseDocument($file);
        $job->handle($processor);

        $this->assertDatabaseHas('documents', [
            'sender' => 'Foobar Bazbar',
            'title' => 'Invoice March 2018',
            'date' => '2018-03-08 00:00:00',
            'content' => 'Hello World',
        ]);
    }

}
