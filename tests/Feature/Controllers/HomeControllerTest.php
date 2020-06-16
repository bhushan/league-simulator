<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Verifies Home Page Is Visible
     *
     * @return void
     */
    public function testVerifiesHomePageIsVisible(): void
    {
        $this->get('/')->assertViewIs('index')->assertOk();
    }
}
