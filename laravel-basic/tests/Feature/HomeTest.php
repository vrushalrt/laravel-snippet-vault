<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function testHomePageIsWorkingCorrectly(): void
    {
        $this->actingAs($this->user());

        $response = $this->get('/');

        $response->assertSeeText('Laravel App');
        // $response->assertSeeText('I am a Title');

    }

    public function testContactPageIsWorkingCorrectly(): void
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
        $response->assertSeeText('Contact Page.');
    }
}
