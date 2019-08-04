<?php

namespace Tests\Feature;

use Tests\TestCase;
use ReflectionException;

class RoutesTest extends TestCase
{
    /**
     * Test main route.
     *
     * @return void
     */
    public function test_main_route()
    {
        $response = $this->get('/api');

        $response->assertOk();
    }

    /**
     * Test MethodNotAllowedException handler
     *
     * assert that a MethodNotAllowedException is caught
     *
     * @return void
     */
    public function test_method_not_allowed_exception_handler()
    {
        $response = $this->post('/api');
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status'
        ]);
        $response->assertExactJson([
            'status' => 'Bad Request'
        ]);
    }

    /**
     * Test MethodNotAllowedException handler
     *
     * assert that a MethodNotAllowedException is caught
     *
     * @return void
     */
    public function test_exception_rendering()
    {
        $this->expectException(ReflectionException::class);
        $this->get('oauth/authorize');
    }
}
