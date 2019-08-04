<?php

namespace Tests\Unit;

use Tests\TestCase;

class NotFoundTest extends TestCase
{
    /**
     * Test that 404 page works
     *
     * @return void
     */
    public function test_not_found()
    {
        $response = $this->get('/not-found');
        $response->assertNotFound();
    }
}
