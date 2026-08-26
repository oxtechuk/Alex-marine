<?php

namespace Tests\Feature;

use App\Models\MaintenanceProject;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_index_page_can_be_rendered(): void
    {
        $project = MaintenanceProject::create([
            'title_ar' => 'مشروع صيانة تجريبي لنظام الإطفاء',
            'title_en' => 'Test CO2 Fire System Maintenance Project',
            'slug' => 'test-co2-fire-system-maintenance',
            'location_ar' => 'ميناء الإسكندرية',
            'is_active' => true,
        ]);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertSee('مشروع صيانة تجريبي');
    }

    public function test_single_project_case_study_page_can_be_rendered(): void
    {
        $project = MaintenanceProject::create([
            'title_ar' => 'صيانة شاملة لأجهزة التنفس',
            'title_en' => 'Comprehensive SCBA Overhaul',
            'slug' => 'comprehensive-scba-overhaul',
            'client_name' => 'شركة بترول بلاعيم',
            'location_ar' => 'خليج السويس',
            'duration' => '3 أيام',
            'description_ar' => 'تفاصيل فحص ومعايرة أجهزة التنفس الذاتية وفقاً للمواصفات الدولية.',
            'before_image' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232',
            'after_image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122',
            'is_active' => true,
        ]);

        $response = $this->get(route('projects.show', $project->slug));

        $response->assertStatus(200);
        $response->assertSee('صيانة شاملة لأجهزة التنفس');
        $response->assertSee('BEFORE / AFTER COMPARISON');
        $response->assertSee('Inspired by what you see?');
    }

    public function test_home_page_displays_maintenance_cases(): void
    {
        MaintenanceProject::create([
            'title_ar' => 'صيانة طوافات النجاة',
            'slug' => 'life-rafts-maintenance',
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('gallery-section');
        $response->assertSee('صيانة طوافات النجاة');
    }

    public function test_admin_can_view_and_create_maintenance_project(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $service = Service::create([
            'name_ar' => 'صيانة معدات السلامة',
            'slug' => 'safety-equipment-maintenance',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.projects.index'))
            ->assertStatus(200);

        $response = $this->actingAs($admin)->post(route('admin.projects.store'), [
            'title_ar' => 'مشروع فحص زوارق الإنقاذ السريع',
            'title_en' => 'Fast Rescue Craft Inspection',
            'service_id' => $service->id,
            'client_name' => 'هيئة ميناء الإسكندرية',
            'location_ar' => 'ميناء الإسكندرية',
            'duration' => '4 أيام',
            'description_ar' => 'فحص سنوي شامل لزوارق الإنقاذ السريع.',
            'is_active' => '1',
            'is_featured' => '1',
        ]);

        $response->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('maintenance_projects', [
            'title_ar' => 'مشروع فحص زوارق الإنقاذ السريع',
            'client_name' => 'هيئة ميناء الإسكندرية',
        ]);
    }
}
