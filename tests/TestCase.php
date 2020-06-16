<?php

namespace Tests;

use Tests\Database\Seeds\TestTeamsTableSeeder;
use Tests\Database\Seeds\TestMatchesTableSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create Default Migration Setup For All Test Classes.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /**
     * Seed test database.
     *
     * @return void
     */
    protected function seedData(): void
    {
        $this->seed(TestTeamsTableSeeder::class);
        $this->seed(TestMatchesTableSeeder::class);
    }
}
