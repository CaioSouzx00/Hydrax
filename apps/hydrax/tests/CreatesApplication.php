<?php

namespace Tests;

use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $storagePath = '/tmp/hydrax-storage-testing';
        if (!is_dir($storagePath)) {
            @mkdir($storagePath, 0777, true);
        }
        $app->useStoragePath($storagePath);

        $compiledPath = env('VIEW_COMPILED_PATH');
        if (is_string($compiledPath) && $compiledPath !== '' && !is_dir($compiledPath)) {
            @mkdir($compiledPath, 0777, true);
        }

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
