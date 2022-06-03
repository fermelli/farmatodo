<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_screen_can_be_rendered()
    {
        $response = $this->get(route('landing'));

        $response->assertStatus(200);
    }
}
