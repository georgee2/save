<?php

namespace App\Services\Api\Concerns;

/**
 * Every image/PDF column in this app stores a relative path with a leading slash
 * (e.g. "/uploads/projects/main/x.webp"); the public disk is symlinked at /storage.
 * The app needs absolute URLs - never leak the raw relative path in an API response.
 */
trait ResolvesMediaUrls
{
    protected function mediaUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Already absolute (e.g. an external URL) - return as-is.
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return url('/storage'.$path);
    }
}
