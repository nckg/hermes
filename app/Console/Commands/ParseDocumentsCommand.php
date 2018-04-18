<?php

namespace App\Console\Commands;

use App\Jobs\ParseDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParseDocumentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses documents in the consumption directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = collect(Storage::disk('files')->files())
            // Reject dot files
            ->reject(function ($item) {
                return Str::endsWith($item, ['.DS_Store', '.gitignore']);
            })
            ->each(function ($file) {
                $storagePath  = Storage::disk('files')->getDriver()->getAdapter()->getPathPrefix();

                ParseDocument::dispatch($storagePath . DIRECTORY_SEPARATOR . $file);
            });
    }
}
