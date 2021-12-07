<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsumeAPITest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the consume script works with defaults
     *
     * @return void
     */
    public function test_default()
    {
        $this->artisan('consume:api')->assertSuccessful();
    }

    /**
     * Test that the consume script works with a URL passed in
     *
     * @return void
     */
    public function test_with_param()
    {
        $this->artisan('consume:api http://universities.hipolabs.com/search')->assertSuccessful();
    }

    /**
     * Test that the consume script errors out on an invalid URL
     *
     * @return void
     */
    public function test_invalid_param()
    {
        $this->artisan('consume:api badurl')->assertFailed();
    }

    /**
     * Test that the consume script errors out on a well-formed invalid URL
     *
     * @return void
     */
    public function test_bad_url_response()
    {
        $this->artisan('consume:api http://badurl.bogus')->assertFailed();
    }
}
