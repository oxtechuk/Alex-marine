<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\QuoteItem;
use App\Models\QuoteRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedBranchId = $request->query('branch_id');
        $selectedPeriod = $request->query('period', 'all');

        $branches = Branch::where('is_active', true)->get();

        $quotesQuery = QuoteRequest::query();
        $ordersQuery = Order::query();
        $productsQuery = Product::query();
        $customersQuery = User::where('role', 'customer');

        // Branch filter
        if (! empty($selectedBranchId)) {
            $quotesQuery->where('branch_id', $selectedBranchId);
            $ordersQuery->where('branch_id', $selectedBranchId);
            $productsQuery->where('branch_id', $selectedBranchId);
        }

        // Time period filter
        if ($selectedPeriod === 'today') {
            $quotesQuery->whereDate('created_at', now()->today());
            $ordersQuery->whereDate('created_at', now()->today());
            $customersQuery->whereDate('created_at', now()->today());
        } elseif ($selectedPeriod === 'this_week') {
            $quotesQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $customersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($selectedPeriod === 'this_month') {
            $quotesQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            $ordersQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            $customersQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($selectedPeriod === 'this_year') {
            $quotesQuery->whereYear('created_at', now()->year);
            $ordersQuery->whereYear('created_at', now()->year);
            $customersQuery->whereYear('created_at', now()->year);
        }

        $totalRevenue = (clone $ordersQuery)->sum('total_amount');
        $ordersCount = (clone $ordersQuery)->count();
        $quotesCount = (clone $quotesQuery)->count();
        $pendingQuotesCount = (clone $quotesQuery)->whereIn('status', ['جديد', 'قيد الانتظار', 'جديد (RFQ)'])->count();
        $productsCount = (clone $productsQuery)->count();
        $customersCount = (clone $customersQuery)->count();
        $totalAllCustomers = User::where('role', 'customer')->count();
        $avgOrderValue = $ordersCount > 0 ? round($totalRevenue / $ordersCount) : 0;

        $stats = [
            'total_quotes' => $quotesCount,
            'pending_quotes' => $pendingQuotesCount,
            'total_orders' => $ordersCount,
            'total_products' => $productsCount,
            'total_customers' => $customersCount,
            'total_all_customers' => $totalAllCustomers,
            'total_revenue' => $totalRevenue,
            'avg_order_value' => $avgOrderValue,
        ];

        // 1. Monthly Revenue & Orders trend for Chart.js (Last 6 Months)
        $chartMonths = [];
        $chartRevenue = [];
        $chartOrdersCount = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->translatedFormat('F Y');
            $chartMonths[] = $monthName;

            $mRev = Order::when($selectedBranchId, function ($q) use ($selectedBranchId) {
                return $q->where('branch_id', $selectedBranchId);
            })->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');

            $mCnt = Order::when($selectedBranchId, function ($q) use ($selectedBranchId) {
                return $q->where('branch_id', $selectedBranchId);
            })->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $chartRevenue[] = (float) $mRev;
            $chartOrdersCount[] = (int) $mCnt;
        }

        // 2. Quote Status Breakdown for Doughnut Chart (Dynamic to branch & period)
        $quoteStatusStats = (clone $quotesQuery)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 3. Dynamic Branch Comparison (Applying the selected period filter)
        $branchComparison = Branch::withCount([
            'orders' => function ($q) use ($selectedPeriod) {
                if ($selectedPeriod === 'today') {
                    $q->whereDate('created_at', now()->today());
                } elseif ($selectedPeriod === 'this_week') {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($selectedPeriod === 'this_month') {
                    $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                } elseif ($selectedPeriod === 'this_year') {
                    $q->whereYear('created_at', now()->year);
                }
            },
            'quoteRequests' => function ($q) use ($selectedPeriod) {
                if ($selectedPeriod === 'today') {
                    $q->whereDate('created_at', now()->today());
                } elseif ($selectedPeriod === 'this_week') {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($selectedPeriod === 'this_month') {
                    $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                } elseif ($selectedPeriod === 'this_year') {
                    $q->whereYear('created_at', now()->year);
                }
            },
            'products',
        ])->withSum([
            'orders' => function ($q) use ($selectedPeriod) {
                if ($selectedPeriod === 'today') {
                    $q->whereDate('created_at', now()->today());
                } elseif ($selectedPeriod === 'this_week') {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($selectedPeriod === 'this_month') {
                    $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                } elseif ($selectedPeriod === 'this_year') {
                    $q->whereYear('created_at', now()->year);
                }
            },
        ], 'total_amount')->get();

        $chartBranchNames = [];
        $chartBranchRevenues = [];
        foreach ($branchComparison as $b) {
            $chartBranchNames[] = $b->name_ar;
            $chartBranchRevenues[] = (float) ($b->orders_sum_total_amount ?? 0);
        }

        $recentQuotes = (clone $quotesQuery)->with('branch')->latest()->take(8)->get();
        $recentOrders = (clone $ordersQuery)->with('branch')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentQuotes',
            'recentOrders',
            'branches',
            'selectedBranchId',
            'selectedPeriod',
            'branchComparison',
            'chartMonths',
            'chartRevenue',
            'chartOrdersCount',
            'quoteStatusStats',
            'chartBranchNames',
            'chartBranchRevenues'
        ));
    }

    // Quotes Management
    public function quotes(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $branchId = $request->query('branch_id');

        $query = QuoteRequest::with('branch');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('quote_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $quotes = $query->latest()->paginate(15)->withQueryString();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.quotes.index', compact('quotes', 'branches', 'search', 'status', 'branchId'));
    }

    public function showQuote($id)
    {
        $quote = QuoteRequest::with('items.product')->find($id);
        if (! $quote) {
            return redirect()->route('admin.quotes.index')->with('error', 'طلب عرض السعر غير موجود أو تم حذفه.');
        }

        return view('admin.quotes.show', compact('quote'));
    }

    public function updateQuoteStatus(Request $request, $id)
    {
        $quote = QuoteRequest::findOrFail($id);
        $request->validate([
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.price' => 'nullable|numeric',
        ]);

        $quote->status = $request->status;
        $quote->admin_notes = $request->admin_notes;

        $totalEstimated = 0;
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $itemData) {
                $item = QuoteItem::find($itemId);
                if ($item) {
                    $item->unit_price = $itemData['price'] ?? null;
                    $item->save();
                    if ($item->unit_price) {
                        $totalEstimated += ($item->unit_price * $item->quantity);
                    }
                }
            }
        }

        $quote->total_estimated = $totalEstimated > 0 ? $totalEstimated : $quote->total_estimated;
        $quote->save();

        return redirect()->back()->with('success', 'تم تحديث حالة وحساب طلب عرض السعر بنجاح');
    }

    public function convertQuoteToOrder($id)
    {
        $quote = QuoteRequest::with('items')->findOrFail($id);

        if ($quote->order) {
            return redirect()->back()->with('error', 'تم تحويل هذا الطلب إلى أمر شراء مسبقاً');
        }

        $orderNumber = Order::generateOrderNumber();
        $order = Order::create([
            'order_number' => $orderNumber,
            'quote_request_id' => $quote->id,
            'user_id' => $quote->user_id,
            'customer_name' => $quote->customer_name,
            'company_name' => $quote->company_name,
            'email' => $quote->email,
            'phone' => $quote->phone,
            'status' => 'قيد التجهيز',
            'total_amount' => $quote->total_estimated ?? 0,
            'payment_status' => 'آجل / حسب الاتفاق',
            'notes' => 'تم تحويله تلقائياً من عرض السعر '.$quote->quote_number,
        ]);

        foreach ($quote->items as $item) {
            $unitPrice = $item->unit_price ?? 0;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'sku' => $item->sku,
                'quantity' => $item->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $item->quantity,
            ]);
        }

        $quote->status = 'مقبول';
        $quote->save();

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'تم تحويل عرض السعر إلى أمر شراء بنجاح ('.$orderNumber.')');
    }

    public function printQuotePdf($id)
    {
        $quote = QuoteRequest::with('items')->findOrFail($id);

        return view('admin.quotes.print', compact('quote'));
    }

    // Orders Management
    public function orders(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $branchId = $request->query('branch_id');
        $paymentStatus = $request->query('payment_status');

        $query = Order::with(['branch', 'user']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.orders.index', compact('orders', 'branches', 'search', 'status', 'branchId', 'paymentStatus'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['items.product', 'branch', 'user', 'quoteRequest'])->find($id);
        if (! $order) {
            return redirect()->route('admin.orders.index')->with('error', 'أمر الشراء المطلوب غير موجود.');
        }

        $products = Product::where('is_active', true)->orderBy('name_ar')->get(['id', 'name_ar', 'sku', 'price']);
        $branches = Branch::where('is_active', true)->get();

        return view('admin.orders.show', compact('order', 'products', 'branches'));
    }

    public function updateOrderItems(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $request->validate([
            'items' => 'required|array',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $grandTotal = 0;
        foreach ($request->items as $itemId => $itemData) {
            $item = OrderItem::where('order_id', $order->id)->find($itemId);
            if ($item) {
                $unitPrice = (float) $itemData['unit_price'];
                $qty = (int) $itemData['quantity'];
                $totalPrice = $unitPrice * $qty;

                $item->update([
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'total_price' => $totalPrice,
                ]);

                $grandTotal += $totalPrice;
            }
        }

        $order->update([
            'total_amount' => $grandTotal,
        ]);

        return redirect()->back()->with('success', 'تم تحديث أسعار وكميات الأصناف وإعادة احتساب الإجمالي بنجاح.');
    }

    public function addOrderItem(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = (int) $request->quantity;
        $unitPrice = (float) $request->unit_price;
        $totalPrice = $qty * $unitPrice;

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name_ar,
            'sku' => $product->sku,
            'quantity' => $qty,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
        ]);

        $newTotal = OrderItem::where('order_id', $order->id)->sum('total_price');
        $order->update(['total_amount' => $newTotal]);

        return redirect()->back()->with('success', 'تمت إضافة المنتج إلى أمر الشراء بنجاح.');
    }

    public function deleteOrderItem($id, $itemId)
    {
        $order = Order::findOrFail($id);
        $item = OrderItem::where('order_id', $order->id)->findOrFail($itemId);
        $item->delete();

        $newTotal = OrderItem::where('order_id', $order->id)->sum('total_price');
        $order->update(['total_amount' => $newTotal]);

        return redirect()->back()->with('success', 'تم حذف الصنف من أمر الشراء بنجاح.');
    }

    public function completeOrderSale(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'payment_status' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id',
            'notes' => 'nullable|string',
        ]);

        $order->update([
            'status' => 'مكتمل (تم البيع)',
            'payment_status' => $request->payment_status,
            'branch_id' => $request->branch_id ?: $order->branch_id,
            'notes' => $request->notes ?: $order->notes,
        ]);

        return redirect()->back()->with('success', 'تم تأكيد وإتمام عملية البيع وتحديث حالة السداد بنجاح!');
    }

    // Categories Management (Main Categories & Sub-Categories Hierarchy)
    public function categories()
    {
        $categories = Category::with(['children.products', 'parent', 'products'])
            ->whereNull('parent_id')
            ->orderBy('sort_order', 'asc')
            ->get();

        $allCategories = Category::orderBy('name_ar', 'asc')->get();

        return view('admin.categories.index', compact('categories', 'allCategories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:191',
            'parent_id' => 'nullable|exists:categories,id',
            'description_ar' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image_file' => 'nullable|image|max:5120',
        ]);

        $imagePath = $request->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'cat_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $imagePath = '/uploads/categories/'.$filename;
        }

        Category::create([
            'parent_id' => $request->parent_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => Str::slug($request->name_ar).'-'.time(),
            'description_ar' => $request->description_ar,
            'icon' => $request->icon ?: 'bi-tag-fill',
            'image' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة التصنيف بنجاح');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name_ar' => 'required|string|max:191',
            'parent_id' => 'nullable|exists:categories,id',
            'description_ar' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image_file' => 'nullable|image|max:5120',
        ]);

        if ($request->parent_id == $category->id) {
            return redirect()->back()->with('error', 'لا يمكن جعل التصنيف أباً لنفسه');
        }

        $imagePath = $request->image ?: $category->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'cat_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $imagePath = '/uploads/categories/'.$filename;
        }

        $category->update([
            'parent_id' => $request->parent_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'icon' => $request->icon ?: 'bi-tag-fill',
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات التصنيف بنجاح');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'تم حذف التصنيف بنجاح');
    }

    // Products Management
    public function products(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $branchId = $request->query('branch_id');
        $availability = $request->query('availability');
        $sort = $request->query('sort', 'latest');

        $query = Product::with(['category', 'branch']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($availability) {
            $query->where('availability_status', $availability);
        }

        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name_ar', 'asc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::all();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories', 'branches', 'search', 'categoryId', 'branchId', 'availability', 'sort'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:191',
            'category_id' => 'required|exists:categories,id',
            'branch_id' => 'nullable|exists:branches,id',
            'short_desc_ar' => 'nullable|string',
            'sku' => 'nullable|string|max:191',
            'cost_price' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'image_file' => 'nullable|image|max:5120',
            'gallery_files.*' => 'nullable|image|max:5120',
        ]);

        $imagePath = $request->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'prod_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = '/uploads/products/'.$filename;
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = 'prod_gal_'.time().'_'.Str::random(4).'.'.$gFile->getClientOriginalExtension();
                $gFile->move(public_path('uploads/products'), $gFilename);
                $galleryPaths[] = '/uploads/products/'.$gFilename;
            }
        }

        Product::create([
            'category_id' => $request->category_id,
            'branch_id' => $request->branch_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => Str::slug($request->name_ar).'-'.time(),
            'sku' => $request->sku ?? 'AM-'.strtoupper(Str::random(5)),
            'cost_price' => $request->cost_price,
            'price' => $request->price,
            'short_desc_ar' => $request->short_desc_ar,
            'full_desc_ar' => $request->full_desc_ar,
            'image' => $imagePath,
            'gallery' => count($galleryPaths) ? $galleryPaths : null,
            'availability_status' => $request->availability_status ?? 'متوفر في المخزن',
            'is_featured' => $request->has('is_featured'),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة المنتج بنجاح');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name_ar' => 'required|string|max:191',
            'category_id' => 'required|exists:categories,id',
            'branch_id' => 'nullable|exists:branches,id',
            'short_desc_ar' => 'nullable|string',
            'sku' => 'nullable|string|max:191',
            'cost_price' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'image_file' => 'nullable|image|max:5120',
            'gallery_files.*' => 'nullable|image|max:5120',
        ]);

        $imagePath = $request->image ?? $product->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'prod_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = '/uploads/products/'.$filename;
        }

        $galleryPaths = $product->gallery ?? [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = 'prod_gal_'.time().'_'.Str::random(4).'.'.$gFile->getClientOriginalExtension();
                $gFile->move(public_path('uploads/products'), $gFilename);
                $galleryPaths[] = '/uploads/products/'.$gFilename;
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'branch_id' => $request->branch_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'sku' => $request->sku,
            'cost_price' => $request->cost_price,
            'price' => $request->price,
            'short_desc_ar' => $request->short_desc_ar,
            'full_desc_ar' => $request->full_desc_ar,
            'image' => $imagePath,
            'gallery' => count($galleryPaths) ? $galleryPaths : null,
            'availability_status' => $request->availability_status,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات المنتج بنجاح');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'تم حذف المنتج بنجاح');
    }

    // CMS Management
    public function cms()
    {
        $settings = Setting::pluck('value', 'key')->all();
        $categories = Category::orderBy('sort_order', 'asc')->get();

        return view('admin.cms.index', compact('settings', 'categories'));
    }

    public function updateCms(Request $request)
    {
        $data = $request->except([
            '_token',
            'hero_bg_image_file',
            'hero_bg_video_file',
            'about_section_image_file',
            'site_logo_header_file',
            'category_image_files',
            'category_images',
        ]);

        // Ensure directories exist
        $cmsUploads = public_path('uploads/cms');
        if (! file_exists($cmsUploads)) {
            mkdir($cmsUploads, 0777, true);
        }
        $brandUploads = public_path('uploads/branding');
        if (! file_exists($brandUploads)) {
            mkdir($brandUploads, 0777, true);
        }
        $catUploads = public_path('uploads/categories');
        if (! file_exists($catUploads)) {
            mkdir($catUploads, 0777, true);
        }

        if ($request->hasFile('site_logo_header_file')) {
            $file = $request->file('site_logo_header_file');
            $filename = 'logo_header_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($brandUploads, $filename);
            $data['site_logo_header'] = '/uploads/branding/'.$filename;
        }

        if ($request->hasFile('hero_bg_image_file')) {
            $file = $request->file('hero_bg_image_file');
            $filename = 'hero_img_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($cmsUploads, $filename);
            $data['hero_bg_image'] = '/uploads/cms/'.$filename;
        }

        if ($request->hasFile('hero_bg_video_file')) {
            $file = $request->file('hero_bg_video_file');
            $filename = 'hero_vid_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($cmsUploads, $filename);
            $data['hero_bg_video'] = '/uploads/cms/'.$filename;
        }

        if ($request->hasFile('about_section_image_file')) {
            $file = $request->file('about_section_image_file');
            $filename = 'about_logo_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($cmsUploads, $filename);
            $data['about_section_image'] = '/uploads/cms/'.$filename;
        }

        // Clean YouTube ID from full URL
        if ($request->has('hero_youtube_id')) {
            $rawYt = $request->input('hero_youtube_id');
            if (! empty($rawYt)) {
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $rawYt, $match)) {
                    $data['hero_youtube_id'] = $match[1];
                } else {
                    $data['hero_youtube_id'] = trim($rawYt);
                }
            }
        }

        // Handle Feature Category IDs selection
        if ($request->has('feature_category_ids')) {
            $data['feature_category_ids'] = implode(',', (array) $request->input('feature_category_ids'));
        } else {
            $data['feature_category_ids'] = '';
        }

        // Handle individual Category Cover Images
        if ($request->has('category_images')) {
            foreach ($request->category_images as $catId => $imgUrl) {
                if (! empty($imgUrl)) {
                    Category::where('id', $catId)->update(['image' => $imgUrl]);
                }
            }
        }
        if ($request->hasFile('category_image_files')) {
            foreach ($request->file('category_image_files') as $catId => $catFile) {
                if ($catFile) {
                    $filename = 'cat_cov_'.$catId.'_'.time().'.'.$catFile->getClientOriginalExtension();
                    $catFile->move($catUploads, $filename);
                    Category::where('id', $catId)->update(['image' => '/uploads/categories/'.$filename]);
                }
            }
        }

        $toggles = [
            'section_hero_active',
            'section_fleet_active',
            'section_feature_active',
            'section_stats_active',
            'section_gallery_active',
            'section_spotlight_active',
            'section_cta_active',
        ];

        foreach ($toggles as $toggle) {
            Setting::set($toggle, $request->has($toggle) ? '1' : '0');
        }

        foreach ($data as $key => $value) {
            if (! in_array($key, $toggles)) {
                if (! is_array($value)) {
                    Setting::set($key, $value ?? '');
                }
            }
        }

        return redirect()->back()->with('success', 'تم تحديث إعدادات الهوم بيج وحافظة CMS بنجاح');
    }

    // General Brand, Color & Social Settings Management
    public function settings()
    {
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except([
            '_token',
            'site_logo_header_file',
            'site_logo_footer_file',
            'site_logo_admin_file',
            'site_favicon_file',
        ]);

        $brandUploads = public_path('uploads/branding');
        if (! file_exists($brandUploads)) {
            mkdir($brandUploads, 0777, true);
        }

        if ($request->hasFile('site_logo_header_file')) {
            $file = $request->file('site_logo_header_file');
            $filename = 'logo_header_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($brandUploads, $filename);
            $data['site_logo_header'] = '/uploads/branding/'.$filename;
        }

        if ($request->hasFile('site_logo_admin_file')) {
            $file = $request->file('site_logo_admin_file');
            $filename = 'logo_admin_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($brandUploads, $filename);
            $data['site_logo_admin'] = '/uploads/branding/'.$filename;
        }

        if ($request->hasFile('site_logo_footer_file')) {
            $file = $request->file('site_logo_footer_file');
            $filename = 'logo_footer_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($brandUploads, $filename);
            $data['site_logo_footer'] = '/uploads/branding/'.$filename;
        }

        if ($request->hasFile('site_favicon_file')) {
            $file = $request->file('site_favicon_file');
            $filename = 'favicon_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($brandUploads, $filename);
            $data['site_favicon'] = '/uploads/branding/'.$filename;
        }

        foreach ($data as $key => $value) {
            if (! is_array($value)) {
                Setting::set($key, $value ?? '');
            }
        }

        return redirect()->back()->with('success', 'تم تحديث إعدادات الهُوية وشعار الموقع والألوان بنجاح');
    }

    // Branch Management
    public function branches()
    {
        $branches = Branch::withCount(['products', 'quoteRequests', 'orders'])->get();

        return view('admin.branches.index', compact('branches'));
    }

    public function storeBranch(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:191',
            'code' => 'required|string|max:50|unique:branches,code',
            'city' => 'required|string|max:191',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string',
        ]);

        Branch::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'code' => strtoupper($request->code),
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'manager_name' => $request->manager_name,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الفرع الجديد بنجاح');
    }

    public function updateBranch(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $request->validate([
            'name_ar' => 'required|string|max:191',
            'code' => 'required|string|max:50|unique:branches,code,'.$id,
            'city' => 'required|string|max:191',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string',
        ]);

        $branch->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'code' => strtoupper($request->code),
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'manager_name' => $request->manager_name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات الفرع بنجاح');
    }

    public function deleteBranch($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->back()->with('success', 'تم حذف الفرع بنجاح');
    }

    // Customers Management
    public function customers(Request $request)
    {
        $search = $request->query('search');
        $ordersFilter = $request->query('orders_filter');
        $sort = $request->query('sort', 'latest');

        $query = User::where('role', 'customer')
            ->withCount(['orders', 'quoteRequests'])
            ->withSum('orders', 'total_amount');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($ordersFilter === 'has_orders') {
            $query->has('orders');
        } elseif ($ordersFilter === 'no_orders') {
            $query->doesntHave('orders');
        }

        if ($sort === 'highest_spent') {
            $query->orderByDesc('orders_sum_total_amount');
        } elseif ($sort === 'most_orders') {
            $query->orderByDesc('orders_count');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } else {
            $query->latest();
        }

        $customers = $query->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers', 'search', 'ordersFilter', 'sort'));
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:users,email',
            'company_name' => 'nullable|string|max:191',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email ?: 'cust_'.time().'@alexmarine.eg',
            'company_name' => $request->company_name,
            'address' => $request->address,
            'role' => 'customer',
            'password' => Hash::make(Str::random(12)),
        ]);

        return redirect()->back()->with('success', 'تم تسجيل العميل الجديد بنجاح');
    }

    // Direct Sales / POS
    public function createSale()
    {
        $branches = Branch::where('is_active', true)->get();
        $products = Product::where('is_active', true)->with('category')->get();
        $categories = Category::all();
        $customers = User::where('role', 'customer')->orderBy('name')->get();

        return view('admin.sales.create', compact('branches', 'products', 'categories', 'customers'));
    }

    public function storeSale(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'customer_type' => 'required|in:cash,existing',
            'user_id' => 'nullable|required_if:customer_type,existing|exists:users,id',
            'customer_name' => 'nullable|string|max:191',
            'phone' => 'nullable|string|max:50',
            'payment_status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $userId = null;
        $customerName = 'عميل نقدي';
        $email = null;
        $phone = $request->phone;
        $companyName = null;

        if ($request->customer_type === 'existing' && $request->user_id) {
            $user = User::findOrFail($request->user_id);
            $userId = $user->id;
            $customerName = $user->name;
            $email = $user->email;
            $phone = $request->phone ?: $user->phone;
            $companyName = $user->company_name;
        } elseif ($request->customer_name) {
            $customerName = $request->customer_name;
        }

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += ($item['quantity'] * $item['unit_price']);
        }

        $orderNumber = Order::generateOrderNumber();
        $order = Order::create([
            'order_number' => $orderNumber,
            'branch_id' => $request->branch_id,
            'user_id' => $userId,
            'customer_name' => $customerName,
            'company_name' => $companyName,
            'email' => $email,
            'phone' => $phone,
            'status' => 'مكتمل',
            'total_amount' => $totalAmount,
            'payment_status' => $request->payment_status,
            'notes' => $request->notes ?: 'أمر بيع مباشر / POS',
        ]);

        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name_ar,
                    'sku' => $product->sku,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'تم إتمام عملية البيع وإنشاء أمر الشراء بنجاح ('.$orderNumber.')');
    }

    /**
     * Clear application cache, routes, config, and views on production/shared hosting
     */
    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            return back()->with('success', 'تم تنظيف الكاش وإعادة بناء إعدادات النظام بنجاح.');
        } catch (\Throwable $e) {
            return back()->with('error', 'حدث خطأ أثناء تنظيف الكاش: ' . $e->getMessage());
        }
    }

    /**
     * Create storage symlink on shared hosting where terminal/SSH is unavailable
     */
    public function linkStorage()
    {
        try {
            Artisan::call('storage:link');
            return back()->with('success', 'تم ربط مجلد التخزين بالملفات العامة بنجاح (Storage Link Created).');
        } catch (\Throwable $e) {
            return back()->with('error', 'حدث خطأ أثناء ربط التخزين: ' . $e->getMessage());
        }
    }
}
