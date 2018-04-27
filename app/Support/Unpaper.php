<?php

namespace App\Support;

use Symfony\Component\Process\Process;

class Unpaper
{
    protected $pdf;

    protected $binPath;

    protected $options = [];

    public function __construct(string $binPath = null)
    {
        $this->binPath = $binPath ?? '/usr/bin/unpaper';
    }

    public function clean(string $file)
    {
        $process = new Process(array_merge([$this->binPath], [], [$file, '-']));
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \Exception("Duuuuuuuh");
        }
    }
}
