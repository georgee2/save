<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Always render /api/* exceptions as JSON, regardless of the client's Accept
     * header - a client that forgets "Accept: application/json" would otherwise
     * silently get an HTML error page (Ignition in debug mode) instead of a
     * usable error response. Laravel's own exception-to-JSON conversion already
     * includes message/exception/file/line/trace when APP_DEBUG=true, so this is
     * the only change needed to make every API error easy to read from a REST
     * client. Web routes are untouched - this only adds a case, it never removes
     * the existing Accept-header-based detection.
     */
    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return $request->is('api/*') || parent::shouldReturnJson($request, $e);
    }
}
