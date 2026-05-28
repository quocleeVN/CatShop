<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use Throwable;

class WindowsSafeFilesystem extends Filesystem
{
    public function replace($path, $content, $mode = null)
    {
        clearstatcache(true, $path);

        $path = realpath($path) ?: $path;
        $directory = dirname($path);

        $tempPath = tempnam($directory, basename($path));

        if (! is_null($mode)) {
            @chmod($tempPath, $mode);
        } else {
            @chmod($tempPath, 0777 - umask());
        }

        file_put_contents($tempPath, $content);

        try {
            if (@rename($tempPath, $path)) {
                return;
            }

            if (windows_os()) {
                // On Windows, rename can fail if the target file is currently open
                // by another process. Fall back to an in-place overwrite.
                file_put_contents($path, $content, LOCK_EX);
                @unlink($tempPath);

                return;
            }
        } catch (Throwable $e) {
            if (windows_os()) {
                file_put_contents($path, $content, LOCK_EX);
                @unlink($tempPath);

                return;
            }

            @unlink($tempPath);

            throw $e;
        }

        @unlink($tempPath);

        parent::replace($path, $content, $mode);
    }
}
