<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class SiteSettingsTest extends TestCase
{
    public function test_admin_can_access_site_settings_page()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Brand Admin Test',
                'email' => 'brand-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $response = $this->actingAs($admin)->get('/admin/settings');
        $response->assertStatus(200);
        $response->assertSee('إعدادات الهُوية، الشعار، الألوان وشبكات التواصل');
    }

    public function test_admin_can_update_logo_colors_and_social_links()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Brand Admin Test',
                'email' => 'brand-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $response = $this->actingAs($admin)
            ->from('/admin/settings')
            ->post('/admin/settings', [
                'site_logo_header' => 'https://alexmarine.eg/logo-header.png',
                'site_primary_color' => '#0c192c',
                'site_accent_color' => '#f59e0b',
                'contact_facebook' => 'https://facebook.com/alexmarine.eg',
                'contact_whatsapp' => '+201234567890',
            ]);

        $response->assertRedirect('/admin/settings');
        $response->assertSessionHas('success');

        $this->assertEquals('https://alexmarine.eg/logo-header.png', Setting::get('site_logo_header'));
        $this->assertEquals('#0c192c', Setting::get('site_primary_color'));
        $this->assertEquals('#f59e0b', Setting::get('site_accent_color'));
        $this->assertEquals('https://facebook.com/alexmarine.eg', Setting::get('contact_facebook'));
    }
}
