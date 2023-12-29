<?php
declare(strict_types=1);

use Illuminate\Support\Str;

if (! function_exists('database_path')) {
    /**
     * Get the database path.
     *
     * @param string $path
     * @return string
     */
    function database_path(string $path = ''): string
    {
        return app()->databasePath().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
