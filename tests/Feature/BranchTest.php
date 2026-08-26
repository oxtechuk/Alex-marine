<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Tests\TestCase;

class BranchTest extends TestCase
{
    public function test_admin_can_access_branches_page()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Branch Admin Test',
                'email' => 'branch-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $response = $this->actingAs($admin)->get('/admin/branches');
        $response->assertStatus(200);
        $response->assertSee('فروع الشركة والمستودعات المعتمدة');
    }

    public function test_admin_can_create_new_branch()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Branch Admin Test',
                'email' => 'branch-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $code = 'DMT-'.time().'-'.rand(10, 99);

        $response = $this->actingAs($admin)
            ->from('/admin/branches')
            ->post('/admin/branches', [
                'name_ar' => 'فرع ميناء دمياط البحري',
                'name_en' => 'Damietta Port Branch',
                'code' => $code,
                'city' => 'دمياط',
                'phone' => '+20 120 555 4433',
                'email' => 'damietta@alexmarine.eg',
                'address' => 'ميناء دمياط - المنطقة الجمركية 2',
                'manager_name' => 'م. إبراهيم فؤاد',
            ]);

        $response->assertRedirect('/admin/branches');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('branches', [
            'code' => $code,
            'city' => 'دمياط',
        ]);
    }

    public function test_admin_dashboard_can_be_filtered_by_branch()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Branch Admin Test',
                'email' => 'branch-admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $branch = Branch::firstOrCreate(
            ['code' => 'ALX-MAIN'],
            ['name_ar' => 'فرع الإسكندرية الرئيسي', 'city' => 'الإسكندرية', 'is_active' => true]
        );

        $response = $this->actingAs($admin)->get('/admin/dashboard?branch_id='.$branch->id);
        $response->assertStatus(200);
        $response->assertSee('تصفية الإحصائيات');
    }
}
