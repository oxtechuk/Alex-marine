<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\User;
use Tests\TestCase;

class AlexMarineTest extends TestCase
{
    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ALEX MARINE');
        $response->assertSee('اطلب عرض سعر');
    }

    public function test_products_index_page_loads()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('دليل المنتجات والتوريدات');
    }

    public function test_product_detail_page_loads_with_reference_structure()
    {
        $product = Product::where('slug', 'solas-marine-life-jacket')->first();
        if (! $product) {
            $product = Product::first();
        }

        $response = $this->get('/products/'.$product->category->slug.'/'.$product->slug);
        $response->assertStatus(200);
        $response->assertSee('الوصف والمميزات');
        $response->assertSee('تواصل عبر واتساب');
        $response->assertSee('اطلب الان');
    }

    public function test_rfq_submission_workflow()
    {
        $product = Product::first();

        // 1. Add to quote cart
        $response = $this->post('/quote/add', [
            'product_id' => $product->id,
            'quantity' => 2,
            'notes' => 'مقاس خاص',
        ]);
        $response->assertSessionHas('quote_cart');

        // Test AJAX request
        $ajaxResponse = $this->postJson('/quote/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $ajaxResponse->assertOk();
        $ajaxResponse->assertJson([
            'success' => true,
        ]);

        $testEmail = 'rfq-'.uniqid().'@shipping.com';
        $response = $this->post('/quote/store', [
            'customer_name' => 'مهندس أحمد علي',
            'company_name' => 'شركة الملاحة البحرية',
            'email' => $testEmail,
            'phone' => '+20 100 999 8877',
            'notes' => 'يرجى التسليم في ميناء الإسكندرية الرصيف 5',
        ]);

        $quote = QuoteRequest::where('email', $testEmail)->first();
        $this->assertNotNull($quote);
        $this->assertStringStartsWith('RFQ-', $quote->quote_number);
        $this->assertEquals($testEmail, $quote->email);

        $response->assertRedirect(route('quote.success', $quote->quote_number));
    }

    public function test_admin_can_update_quote_and_convert_to_order()
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }

        $quote = QuoteRequest::create([
            'quote_number' => 'RFQ-TEST-'.rand(1000, 9999).'-'.time(),
            'customer_name' => 'اختبار تحويل مستقل',
            'company_name' => 'شركة الاختبار',
            'email' => 'test-unique-'.time().'@test.com',
            'phone' => '0100000000',
            'status' => 'جديد',
        ]);

        // Admin updates pricing & status
        $response = $this->actingAs($admin)
            ->from(route('admin.quotes.show', $quote->id))
            ->post(route('admin.quotes.update', $quote->id), [
                'status' => 'تم التسعير',
                'admin_notes' => 'ملاحظة الفحص الفني',
            ]);
        $response->assertSessionHas('success');

        // Admin converts quote to order
        $response = $this->actingAs($admin)
            ->from(route('admin.quotes.show', $quote->id))
            ->post(route('admin.quotes.convert', $quote->id));
        $response->assertSessionHas('success');

        $order = Order::where('quote_request_id', $quote->id)->first();
        $this->assertNotNull($order);
        $this->assertStringStartsWith('ORD-', $order->order_number);
    }

    public function test_direct_order_from_product_page_creates_quote_and_customer()
    {
        $product = Product::first();

        $response = $this->post(route('quote.direct'), [
            'product_id' => $product->id,
            'name' => 'قبطان بحري تجريبي',
            'phone' => '01099887766',
            'quantity' => 3,
            'notes' => 'تسليم ميناء الإسكندرية رصيف 5',
        ]);

        $response->assertSessionHas('success');

        // Assert customer exists
        $user = User::where('phone', '01099887766')->first();
        $this->assertNotNull($user);
        $this->assertEquals('قبطان بحري تجريبي', $user->name);
        $this->assertEquals('customer', $user->role);

        // Assert QuoteRequest exists
        $quote = QuoteRequest::where('phone', '01099887766')->latest()->first();
        $this->assertNotNull($quote);
        $this->assertEquals($user->id, $quote->user_id);
        $this->assertEquals('قبطان بحري تجريبي', $quote->customer_name);
        $this->assertEquals('جديد', $quote->status);

        // Assert QuoteItem created
        $item = $quote->items()->where('product_id', $product->id)->first();
        $this->assertNotNull($item);
        $this->assertEquals(3, $item->quantity);

        // Assert Order created in admin/orders
        $order = Order::where('phone', '01099887766')->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals($user->id, $order->user_id);
        $this->assertEquals('قبطان بحري تجريبي', $order->customer_name);
        $this->assertStringStartsWith('ORD-', $order->order_number);

        // Assert OrderItem created
        $orderItem = $order->items()->where('product_id', $product->id)->first();
        $this->assertNotNull($orderItem);
        $this->assertEquals(3, $orderItem->quantity);
    }
}
