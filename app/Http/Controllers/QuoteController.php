<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\QuoteItem;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    public function directOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:50',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = max(1, (int) ($request->quantity ?? 1));

        // Find or create customer with role 'customer' so it always appears in admin/customers
        $customer = User::where('phone', $request->phone)->where('role', 'customer')->first();
        if (! $customer) {
            $fakeEmail = 'client_'.time().'_'.rand(100, 999).'@alexmarine.com';
            $customer = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $fakeEmail,
                'password' => Hash::make(Str::random(12)),
                'role' => 'customer',
                'company_name' => 'طلب مباشر',
            ]);
        } else {
            if ($request->filled('name')) {
                $customer->name = $request->name;
                $customer->save();
            }
        }

        $defaultBranch = Branch::first();
        $branchId = $product->branch_id ?? ($defaultBranch ? $defaultBranch->id : null);
        $quoteNumber = QuoteRequest::generateQuoteNumber();
        $orderNumber = Order::generateOrderNumber();
        $totalPrice = $product->price > 0 ? ($product->price * $qty) : 0;

        // 1. Create QuoteRequest for RFQ tracking
        $quoteRequest = QuoteRequest::create([
            'quote_number' => $quoteNumber,
            'user_id' => $customer->id,
            'branch_id' => $branchId,
            'customer_name' => $request->name,
            'company_name' => $customer->company_name ?? 'طلب مباشر',
            'email' => $customer->email ?? 'direct@alexmarine.com',
            'phone' => $request->phone,
            'status' => 'جديد',
            'notes' => $request->notes ?? ('طلب مباشر لمنتج: '.$product->name_ar),
            'total_estimated' => $totalPrice,
        ]);

        QuoteItem::create([
            'quote_request_id' => $quoteRequest->id,
            'product_id' => $product->id,
            'product_name' => $product->name_ar,
            'sku' => $product->sku,
            'quantity' => $qty,
            'unit_price' => $product->price > 0 ? $product->price : null,
            'notes' => $request->notes ?? '',
        ]);

        // 2. Create Order so it immediately appears in admin/orders
        $order = Order::create([
            'order_number' => $orderNumber,
            'quote_request_id' => $quoteRequest->id,
            'branch_id' => $branchId,
            'user_id' => $customer->id,
            'customer_name' => $request->name,
            'company_name' => $customer->company_name ?? 'طلب مباشر',
            'email' => $customer->email ?? 'direct@alexmarine.com',
            'phone' => $request->phone,
            'status' => 'قيد التجهيز',
            'total_amount' => $totalPrice,
            'payment_status' => 'عند الاستلام / توريد مباشر',
            'notes' => $request->notes ?? ('طلب مباشر لمنتج: '.$product->name_ar),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name_ar,
            'sku' => $product->sku,
            'quantity' => $qty,
            'unit_price' => $product->price > 0 ? $product->price : 0,
            'total_price' => $totalPrice,
        ]);

        return redirect()->back()->with('success', 'تم استلام طلبك بنجاح برقم أمر الشراء: '.$orderNumber.' وسيتم التواصل معك على الرقم '.$request->phone.' لتأكيد التوريد والتسليم.');
    }

    public function index()
    {
        $cart = session()->get('quote_cart', []);

        return view('quote.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('quote_cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name_ar' => $product->name_ar,
                'sku' => $product->sku,
                'category' => $product->category->name_ar ?? '',
                'image' => $product->image,
                'quantity' => $request->quantity,
                'notes' => $request->notes ?? '',
            ];
        }

        session()->put('quote_cart', $cart);

        return redirect()->back()->with('success', 'تمت إضافة المنتج إلى قائمة طلب عرض السعر بنجاح');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('quote_cart', []);
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('quote_cart', $cart);
        }

        return redirect()->route('quote.index')->with('success', 'تم تحديث الكمية بنجاح');
    }

    public function remove($id)
    {
        $cart = session()->get('quote_cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('quote_cart', $cart);
        }

        return redirect()->route('quote.index')->with('success', 'تم حذف المنتج من طلب عرض السعر');
    }

    public function store(Request $request)
    {
        $cart = session()->get('quote_cart', []);
        if (empty($cart)) {
            return redirect()->route('quote.index')->with('error', 'سلة طلب الأسعار فارغة');
        }

        $request->validate([
            'customer_name' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|string|max:191',
            'notes' => 'nullable|string',
        ]);

        $quoteNumber = QuoteRequest::generateQuoteNumber();

        $quoteRequest = QuoteRequest::create([
            'quote_number' => $quoteNumber,
            'user_id' => Auth::check() ? Auth::id() : null,
            'customer_name' => $request->customer_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'جديد',
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            QuoteItem::create([
                'quote_request_id' => $quoteRequest->id,
                'product_id' => $item['id'],
                'product_name' => $item['name_ar'],
                'sku' => $item['sku'],
                'quantity' => $item['quantity'],
                'notes' => $item['notes'] ?? '',
            ]);
        }

        // Clear cart
        session()->forget('quote_cart');

        return redirect()->route('quote.success', $quoteRequest->quote_number)
            ->with('success', 'تم إرسال طلب عرض السعر بنجاح');
    }

    public function success($quote_number)
    {
        $quoteRequest = QuoteRequest::where('quote_number', $quote_number)->firstOrFail();

        return view('quote.success', compact('quoteRequest'));
    }
}
