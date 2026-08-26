<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_default_locale_is_arabic_with_rtl()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ar"', false);
        $response->assertSee('أليكس مارين');
    }

    public function test_user_can_switch_to_english_locale()
    {
        $response = $this->get('/lang/en');
        $response->assertRedirect();

        $responseEn = $this->withSession(['locale' => 'en'])->get('/');
        $responseEn->assertStatus(200);
        $responseEn->assertSee('dir="ltr"', false);
        $responseEn->assertSee('lang="en"', false);
        $responseEn->assertSee('ALEX MARINE');
    }

    public function test_invalid_locale_falls_back_to_arabic()
    {
        $response = $this->get('/lang/fr');
        $response->assertRedirect();

        $responseFallback = $this->withSession(['locale' => 'fr'])->get('/');
        $responseFallback->assertStatus(200);
        $responseFallback->assertSee('dir="rtl"', false);
    }
}
