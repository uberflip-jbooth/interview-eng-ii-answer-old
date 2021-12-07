<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\University;

class UniversityTest extends TestCase
{
    /**
     * Test the university factory
     *
     * @return void
     */
    public function test_factory()
    {
        $university = University::factory()
            ->create();
        
        $this->assertDatabaseCount('universities', 1);
    }

    /**
     * Test the university factory with relationships
     *
     * @return void
     */
    public function test_factory_relations()
    {
        $university = University::factory()
            ->hasDomains(2)
            ->hasWebPages(2)
            ->create();
        
        $this->assertDatabaseCount('universities', 1);
        $this->assertDatabaseCount('domains', 2);
        $this->assertDatabaseCount('web_pages', 2);
    }
}
