<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class CmsTest extends TestCase
{
    public function test_admin_can_access_cms_page()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'CMS Admin Test',
                'email' => 'cms-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $response = $this->actingAs($admin)->get('/admin/cms');
        $response->assertStatus(200);
        $response->assertSee('إدارة محتوى وعناصر الصفحة الرئيسية');
    }

    public function test_admin_can_update_cms_settings()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'CMS Admin Test',
                'email' => 'cms-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $response = $this->actingAs($admin)
            ->from('/admin/cms')
            ->post('/admin/cms', [
                'hero_media_type' => 'video',
                'hero_title_white_ar' => 'أهلاً بكم في صرح',
                'hero_title_highlight_ar' => 'أليكس مارين المحدثة',
                'section_hero_active' => '1',
                'section_fleet_active' => '1',
                'section_feature_active' => '1',
                'section_stats_active' => '1',
                'section_gallery_active' => '1',
                'section_spotlight_active' => '1',
                'section_cta_active' => '1',
            ]);

        $response->assertRedirect('/admin/cms');
        $response->assertSessionHas('success');

        $this->assertEquals('video', Setting::get('hero_media_type'));
        $this->assertEquals('أهلاً بكم في صرح', Setting::get('hero_title_white_ar'));
    }
}
