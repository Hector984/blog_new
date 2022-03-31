<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText("Welcome to the project");
        $response->assertStatus(200);
    }

    public function testContactPageIsWorking()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
        $response->assertStatus(200);
    }
}
