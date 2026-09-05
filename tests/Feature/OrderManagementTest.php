<?php

namespace Tests\Feature;

use App\Helpers\WhatsAppHelper;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_whatsapp_helper_formats_phone_numbers_correctly(): void
    {
        $this->assertEquals('201012345678', WhatsAppHelper::cleanPhone('01012345678'));
        $this->assertEquals('201012345678', WhatsAppHelper::cleanPhone('+201012345678'));
        $this->assertEquals('201012345678', WhatsAppHelper::cleanPhone('00201012345678'));
        $this->assertStringContainsString('https://wa.me/201012345678', WhatsAppHelper::link('01012345678', 'مرحبا'));
    }

    public function test_admin_can_view_order_details_page(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-T-'.uniqid(),
            'customer_name' => 'عميل تجريبي',
            'company_name' => 'شركة أليكس للتوريدات',
            'email' => 'client@alexmarine.eg',
            'phone' => '01012345678',
            'status' => 'قيد التجهيز',
            'total_amount' => 500,
            'payment_status' => 'آجل',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.orders.show', $order->id));
        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    public function test_admin_can_update_order_items_prices_and_quantities(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-T-'.uniqid(),
            'customer_name' => 'شركة النيل',
            'company_name' => 'شركة النيل الملاحية',
            'email' => 'nile@alexmarine.eg',
            'phone' => '01099887766',
            'status' => 'قيد التجهيز',
            'total_amount' => 100,
            'payment_status' => 'نقدي',
        ]);

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_name' => 'حبل نايلون بحري',
            'quantity' => 1,
            'unit_price' => 100,
            'total_price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.update-items', $order->id), [
            'items' => [
                $item->id => [
                    'quantity' => 3,
                    'unit_price' => 150,
                ],
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('order_items', [
            'id' => $item->id,
            'quantity' => 3,
            'unit_price' => 150,
            'total_price' => 450,
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total_amount' => 450,
        ]);
    }

    public function test_admin_can_add_item_to_order(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-T-'.uniqid(),
            'customer_name' => 'قبطان كريم',
            'company_name' => 'سفينة الحرية',
            'email' => 'captain@alexmarine.eg',
            'phone' => '01234567890',
            'status' => 'قيد التجهيز',
            'total_amount' => 0,
            'payment_status' => 'نقدي',
        ]);

        $category = Category::create([
            'name_ar' => 'مهمات السلامة '.uniqid(),
            'name_en' => 'Safety',
            'slug' => 'safety-cat-'.uniqid(),
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name_ar' => 'سترة نجاة بحرية',
            'name_en' => 'Life Jacket',
            'slug' => 'life-jacket-'.uniqid(),
            'price' => 250,
            'sku' => 'SKU-LJ-'.uniqid(),
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.items.add', $order->id), [
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 300,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 300,
            'total_price' => 600,
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total_amount' => 600,
        ]);
    }

    public function test_admin_can_complete_order_sale(): void
    {
        $branch = Branch::firstOrCreate(
            ['code' => 'TEST-BR-01'],
            [
                'name_ar' => 'فرع الاختبار',
                'name_en' => 'Test Branch',
                'city' => 'الإسكندرية',
                'is_active' => true,
            ]
        );

        $order = Order::create([
            'order_number' => 'ORD-T-'.uniqid(),
            'customer_name' => 'عميل بيع فوري',
            'company_name' => 'شركة المتوسط',
            'email' => 'client2@alexmarine.eg',
            'phone' => '01122334455',
            'status' => 'قيد التجهيز',
            'total_amount' => 1200,
            'payment_status' => 'آجل',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.complete-sale', $order->id), [
            'payment_status' => 'نقدي / مدفوع (Cash)',
            'branch_id' => $branch->id,
            'notes' => 'تم استلام الكاش والتسليم في الميناء',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'مكتمل (تم البيع)',
            'payment_status' => 'نقدي / مدفوع (Cash)',
            'branch_id' => $branch->id,
            'notes' => 'تم استلام الكاش والتسليم في الميناء',
        ]);
    }
}
