<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root URL redirects to the localized home (e.g. /en) via the
     * localization middleware.
     */
    public function test_the_root_redirects_to_the_localized_home(): void
    {
        $response = $this->get('/');

        $response->assertRedirect();
    }
}
