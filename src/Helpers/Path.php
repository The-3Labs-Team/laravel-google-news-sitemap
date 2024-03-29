<?php

namespace The3LabsTeam\GoogleNewsFeed\Helpers;

class Path
{
    public static function merge(string ...$paths): string
    {
        return collect($paths)
            ->map(fn (string $path) => trim($path, '/'))
            ->implode('/');
    }
}
