<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Blade templates must never call env() directly.
 *
 * env() reads from the $_ENV array, which Laravel stops populating once
 * `php artisan config:cache` has run - and config:cache is part of the deploy. From that
 * point every env() call outside a config file returns null, silently. The failure mode is
 * nasty precisely because nothing errors: a feature flag reads false and its feature
 * vanishes, a name reads null and the page title empties.
 *
 * Both have happened here. The offer/project inquiry forms were gated on env() and would
 * have been permanently stuck off, and env('APP_NAME') across the layout, header, footer and
 * preloader would have blanked the title, Open Graph tags and logo alt text.
 *
 * Config files are the one place env() belongs, because they are read before caching and
 * their result is what gets cached.
 */
class NoEnvInViewsTest extends TestCase
{
    private const SEARCH_ROOTS = [
        'resources/views',
        'Modules',
        'app',
        'routes',
    ];

    public function test_no_blade_or_runtime_file_calls_env_directly(): void
    {
        $base = dirname(__DIR__, 2);
        $offenders = [];

        foreach (self::SEARCH_ROOTS as $root) {
            $path = $base . '/' . $root;

            if (!is_dir($path)) {
                continue;
            }

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($files as $file) {
                if (!$file->isFile()) {
                    continue;
                }

                $name = $file->getFilename();

                if (!str_ends_with($name, '.php')) {
                    continue;
                }

                // config/ is exempt by design and is not in SEARCH_ROOTS, but module
                // packages ship their own config directories.
                $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($base) + 1));

                if (str_contains($relative, '/config/') || str_starts_with($relative, 'config/')) {
                    continue;
                }

                $contents = file_get_contents($file->getPathname());

                // `env(` as a call, not `->env(` or `getenv(` or the word inside a string.
                if (preg_match('/(?<![\w>$])env\s*\(/', $contents)) {
                    $offenders[] = $relative;
                }
            }
        }

        $this->assertSame(
            [],
            $offenders,
            "These files call env() outside a config file, so they will read null once "
            . "config:cache runs. Move the value into config/ and read it with config().\n  - "
            . implode("\n  - ", $offenders)
        );
    }
}
