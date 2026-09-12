@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', $isEn ? 'Products Catalog — ALEX MARINE' : 'دليل المنتجات والتوريدات — أليكس مارين')
@section('meta_description', $isEn ? 'Browse ALEX MARINE\'s full catalog of certified marine supplies, industrial safety PPE, firefighting equipment, and rescue gear.' : 'تصفح قائمة منتجات أليكس مارين المعتمدة للتوريدات البحرية ومهمات الأمن الصناعي ومعدات الإطفاء والإنقاذ.')

@section('content')

{{-- ═══════════════════════════════════════════════
     PRODUCTS PAGE HERO (SOLID NAVY B2B)
═══════════════════════════════════════════════ --}}
<section class="about-hero" id="products-hero">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-alex d-inline-flex align-items-center gap-2 p-0 m-0">
                <li class="breadcrumb-item d-inline-flex align-items-center">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
                </li>
                <li class="text-white-50" style="opacity:0.4;">/</li>
                <li class="breadcrumb-item active text-white d-inline-flex align-items-center" aria-current="page">
                    {{ $isEn ? 'Products Catalog' : 'دليل المنتجات' }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-up">
              
                <h1 class="display-section text-white mb-2">
                    {{ $isEn ? 'Marine & Industrial Safety Catalog' : 'دليل المنتجات والتوريدات البحرية' }}
                </h1>
                <p class="mb-0 text-white-50" style="font-size:1rem; max-width:550px; line-height:1.7;">
                    {{ $isEn
                        ? 'Browse our certified marine supplies, industrial PPE, and firefighting equipment. Select items to request an official quotation.'
                        : 'تصفح قائمة المنتجات المعتمدة للتوريدات ومهمات السلامة المهنية، وأضف المنتجات المطلوبة لإصدار عرض سعر رسمي لمؤسستك.' }}
                </p>
            </div>
            <div class="col-lg-5 text-{{ $isEn ? 'end' : 'start' }} mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="80">
                {{-- Quick Stats Badges --}}
                <div class="d-flex flex-wrap gap-2 justify-content-{{ $isEn ? 'end' : 'start' }}">
                    <div class="px-3 py-2 text-center rounded border" style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.15) !important; min-width:100px;">
                        <div style="font-size:1.4rem; font-weight:800; color:var(--alex-gold);">{{ $products->total() }}</div>
                        <div style="font-size:0.75rem; color:rgba(255,255,255,0.7); font-weight:600;">{{ $isEn ? 'Products' : 'منتج متوفر' }}</div>
                    </div>
                    <div class="px-3 py-2 text-center rounded border" style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.15) !important; min-width:100px;">
                        <div style="font-size:1.4rem; font-weight:800; color:var(--alex-gold);">{{ $categories->count() }}</div>
                        <div style="font-size:0.75rem; color:rgba(255,255,255,0.7); font-weight:600;">{{ $isEn ? 'Categories' : 'تصنيف' }}</div>
                    </div>
                    <div class="px-3 py-2 text-center rounded border" style="background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.15) !important; min-width:100px;">
                        <div style="font-size:1.4rem; font-weight:800; color:var(--alex-gold);">
                            <a href="{{ route('quote.index') }}" class="text-decoration-none js-quote-hero-count" style="color:var(--alex-gold);">
                                {{ count(session('quote_cart', [])) }}
                            </a>
                        </div>
                        <div style="font-size:0.75rem; color:rgba(255,255,255,0.7); font-weight:600;">{{ $isEn ? 'Quote Cart' : 'سلة الطلبات' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     FILTER BAR + PRODUCTS GRID
═══════════════════════════════════════════════ --}}
<section class="section-py" style="background:var(--alex-light-bg);">
    <div class="container">

        {{-- Filter Bar --}}
        <div class="products-filter-bar" data-aos="fade-up">
            <form action="{{ route('products.index') }}" method="GET" id="products-filter-form">
                <div class="row g-3 align-items-center">

                    {{-- Search --}}
                    <div class="col-md-5">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute" style="top:50%; transform:translateY(-50%); right:0.9rem; color:var(--alex-text-light); font-size:0.88rem; [dir=ltr] &{right:auto; left:0.9rem;}"></i>
                            <input type="text"
                                   name="search"
                                   id="products-search"
                                   class="search-input-premium"
                                   style="{{ $isEn ? 'padding-left:2.4rem;' : 'padding-right:2.4rem;' }}"
                                   placeholder="{{ $isEn ? 'Search by product name or SKU...' : 'ابحث عن اسم المنتج أو الكود SKU...' }}"
                                   value="{{ request('search') }}"
                                   autocomplete="off">
                        </div>
                    </div>

                    {{-- Category Select --}}
                    <div class="col-md-4">
                        <select name="category"
                                id="products-category"
                                class="form-select"
                                style="border: 1.5px solid var(--alex-border); border-radius: 8px; padding: 0.6rem 1rem; font-size: 0.9rem;"
                                onchange="document.getElementById('products-filter-form').submit()">
                            <option value="">{{ $isEn ? 'All Categories' : 'جميع التصنيفات' }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search Btn --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn-alex-primary w-100 justify-content-center" style="padding:0.6rem 1rem;">
                            <i class="bi bi-search"></i>
                            <span>{{ $isEn ? 'Search' : 'بحث' }}</span>
                        </button>
                    </div>

                    {{-- View Toggle --}}
                    <div class="col-md-1 d-none d-md-flex justify-content-{{ $isEn ? 'end' : 'start' }} gap-1">
                        <button type="button" class="view-toggle-btn active" id="grid-view-btn" onclick="setView('grid')" title="{{ $isEn ? 'Grid (4 columns)' : 'عرض شبكي (4 أعمدة)' }}">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </button>
                        <button type="button" class="view-toggle-btn" id="list-view-btn" onclick="setView('list')" title="{{ $isEn ? 'List' : 'عرض قائمة' }}">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Category Pills (Smooth Scrollable on Mobile) --}}
        <div class="category-pills-wrap mb-4" data-aos="fade-up">
            <div class="category-pills-scroller">
                <a href="{{ route('products.index') }}"
                   class="cat-pill {{ !request('category') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    <span>{{ $isEn ? 'All Products' : 'الكل' }}</span>
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug, 'search' => request('search')]) }}"
                       class="cat-pill {{ request('category') == $cat->slug ? 'active' : '' }}">
                        <i class="bi {{ $cat->icon ?? 'bi-box' }}"></i>
                        <span>{{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Results Summary --}}
        @if(request('search') || request('category'))
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2" data-aos="fade-up">
            <div style="font-size:0.88rem; color:var(--alex-text-mid);">
                <i class="bi bi-funnel-fill me-1" style="color:var(--alex-blue-marine);"></i>
                <strong>{{ $products->total() }}</strong>
                {{ $isEn ? 'products found' : 'منتج متوفر' }}
                @if(request('search'))
                    {{ $isEn ? 'matching' : 'مطابق لـ' }} "<strong>{{ request('search') }}</strong>"
                @endif
            </div>
            <a href="{{ route('products.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none fw-bold fs-7" style="color:var(--alex-navy-dark);">
                <i class="bi bi-x-circle"></i>
                {{ $isEn ? 'Reset Filter' : 'إلغاء التصفية' }}
            </a>
        </div>
        @endif

        {{-- Products Grid (4 in a row on desktop) --}}
        <div class="row g-3 g-lg-4 mb-4" id="products-grid">
            @forelse($products as $i => $product)
            @php
                $catSlug = $product->category?->slug ?? 'general';
                $productUrl = route('products.show', ['category_slug' => $catSlug, 'product_slug' => $product->slug]);
                $productTitle = $isEn ? ($product->name_en ?: $product->name_ar) : $product->name_ar;
                $catName = $product->category ? ($isEn ? ($product->category->name_en ?: $product->category->name_ar) : $product->category->name_ar) : ($isEn ? 'Supplies' : 'توريدات');
                $productImg = $product->image ?: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=600&q=80';
            @endphp
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 product-grid-item" data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 60 }}">
                <div class="product-card practical-card" data-href="{{ $productUrl }}" role="link" tabindex="0">
                    {{-- Product Image Container --}}
                    <div class="product-card-img-wrap">
                        <span class="product-badge-category">
                            {{ $catName }}
                        </span>
                        @if($product->is_featured)
                            <span class="product-badge-new">{{ $isEn ? 'Featured' : 'مميز' }}</span>
                        @endif

                        <img src="{{ $productImg }}"
                             alt="{{ $productTitle }}"
                             class="product-thumb-img"
                             loading="lazy">
                    </div>

                    {{-- Product Info Body --}}
                    <div class="product-card-body">
                        <a href="{{ $productUrl }}" class="product-card-title js-card-title" title="{{ $productTitle }}">
                            {{ $productTitle }}
                        </a>

                        <div class="product-card-sku">
                            <span class="sku-label">{{ $isEn ? 'Code' : 'كود' }}:</span>
                            <span class="sku-value js-card-sku">{{ $product->sku }}</span>
                        </div>

                        <p class="product-card-desc">
                            {{ Str::limit($isEn ? ($product->short_desc_en ?: $product->short_desc_ar) : $product->short_desc_ar, 75) }}
                        </p>

                        {{-- Action Buttons Row: 1. Order Now (Quick RFQ Popup) & 2. Add to Cart --}}
                        <div class="product-card-footer">
                            {{-- Button 1: Order Now (اطلب الآن - فتح بوب اب الشراء السريع) --}}
                            <button type="button"
                                    class="btn-card-order-now js-btn-direct-order"
                                    data-bs-toggle="modal"
                                    data-bs-target="#quickDirectOrderModal"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $productTitle }}"
                                    data-product-sku="{{ $product->sku }}"
                                    data-product-img="{{ $productImg }}"
                                    data-product-cat="{{ $catName }}"
                                    title="{{ $isEn ? 'Direct Order / Quick Purchase' : 'طلب توريد مباشر وسريع' }}">
                                <i class="bi bi-lightning-charge-fill"></i>
                                <span>{{ $isEn ? 'Order' : 'اطلب الآن' }}</span>
                            </button>

                            {{-- Button 2: Add to Quote Cart (أضف للسلة مع بوب اب) --}}
                            <button type="button"
                                    class="btn-card-add-cart js-btn-add-quote"
                                    title="{{ $isEn ? 'Add to Quote Cart' : 'أضف لقائمة عرض السعر' }}"
                                    aria-label="{{ $isEn ? 'Add to Quote Cart' : 'أضف لقائمة عرض السعر' }}"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $productTitle }}"
                                    data-product-sku="{{ $product->sku }}"
                                    data-product-img="{{ $productImg }}">
                                <i class="bi bi-basket2-fill add-icon-default"></i>
                                <span>{{ $isEn ? 'Cart' : 'أضف للسلة' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12">
                <div class="p-5 text-center bg-white rounded-4 border shadow-sm">
                    <i class="bi bi-box-seam d-block mb-3 text-muted" style="font-size:3.5rem;"></i>
                    <h5 class="fw-bold mb-2 text-dark">{{ $isEn ? 'No Products Found' : 'لم يتم العثور على منتجات' }}</h5>
                    <p class="text-muted mb-3">{{ $isEn ? 'Try adjusting your search criteria or clear the category filter.' : 'يرجى تجربة كلمات بحث أخرى أو إلغاء تصفية التصنيف.' }}</p>
                    <a href="{{ route('products.index') }}" class="btn-alex-primary">
                        {{ $isEn ? 'View All Products' : 'عرض كل المنتجات' }}
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4" data-aos="fade-up">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</section>


{{-- ═══════════════════════════════════════════════
     QUOTE CTA BANNER
═══════════════════════════════════════════════ --}}
<section class="cta-section py-4">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-up">
                <h3 class="fw-black text-white mb-2" style="font-size:1.5rem;">
                    {{ $isEn ? "Can't find a specific marine or safety item?" : 'هل تبحث عن صنف أو مقاس بحري خاص؟' }}
                </h3>
                <p class="mb-0 text-white-50" style="font-size:0.92rem;">
                    {{ $isEn
                        ? 'Contact our technical supply team directly for custom vessel procurement orders or immediate port delivery.'
                        : 'تواصل مع فريق التوريدات الفني مباشرة لتوفير الأصناف الخاصة وتجهيز السفن والموانئ.' }}
                </p>
            </div>
            <div class="col-lg-4 text-{{ $isEn ? 'end' : 'start' }}" data-aos="fade-up" data-aos-delay="80">
                <div class="d-flex flex-wrap gap-2 justify-content-{{ $isEn ? 'end' : 'start' }}">
                    <a href="{{ route('quote.index') }}" class="btn-alex-gold px-4 py-2">
                        <i class="bi bi-file-earmark-plus"></i>
                        {{ $isEn ? 'Request Quote' : 'اطلب عرض سعر' }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn-alex-outline-white px-4 py-2">
                        <i class="bi bi-telephone-fill"></i>
                        {{ $isEn ? 'Contact Us' : 'تواصل معنا' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     QUICK DIRECT ORDER MODAL (بوب اب الشراء السريع)
═══════════════════════════════════════════════ --}}
<div class="modal fade" id="quickDirectOrderModal" tabindex="-1" aria-labelledby="quickDirectOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <!-- Modal Header -->
            <div class="modal-header text-white px-3 py-3 d-flex align-items-center justify-content-between" style="background:var(--alex-navy-dark, #0A1D37); border-bottom: 2px solid var(--alex-gold, #D4AF37);">
                <div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px;height:34px;background:rgba(212,175,55,0.2);color:var(--alex-gold,#D4AF37);">
                        <i class="bi bi-lightning-charge-fill fs-5"></i>
                    </div>
                    <div class="min-w-0 flex-grow-1">
                        <h5 class="modal-title fw-bold mb-0 fs-6 text-white text-truncate" id="quickDirectOrderModalLabel">
                            {{ $isEn ? 'Quick Direct Order / RFQ' : 'طلب شراء وتوريد مباشر سريع' }}
                        </h5>
                        <small class="text-white-50 fs-8 d-block text-truncate">{{ $isEn ? 'Direct Vessel & Port Supply' : 'توريد فوري مباشر لجميع الموانئ والشركات' }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none ms-2 flex-shrink-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-3 p-sm-4">
                <!-- Product Preview Box -->
                <div class="d-flex align-items-center gap-3 p-3 mb-3 bg-light rounded-3 border" style="overflow:hidden;">
                    <img id="modalProductImg" src="" alt="Product" style="width:60px;height:60px;object-fit:contain;background:#fff;border-radius:8px;padding:4px;border:1px solid #e2e8f0;flex-shrink:0;">
                    <div style="min-width:0; flex:1 1 auto; overflow:hidden;">
                        <span id="modalProductCat" class="badge bg-secondary text-white fs-8 mb-1"></span>
                        <h6 id="modalProductTitle" class="fw-bold text-dark mb-1" style="font-size:0.90rem; line-height:1.4; word-break:break-word; white-space:normal;"></h6>
                        <div id="modalProductSku" class="text-muted fs-8 fw-semibold"></div>
                    </div>
                </div>

                <!-- Order Form -->
                <form action="{{ route('quote.direct') }}" method="POST" id="quickDirectOrderForm">
                    @csrf
                    <input type="hidden" name="product_id" id="modalProductId" value="">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-7">
                            {{ $isEn ? 'Full Name / Company Name' : 'الاسم بالكامل أو اسم الشركة' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="{{ $isEn ? 'e.g. Captain Mohamed Ali / Marine Corp' : 'مثال: القبطان محمد علي / شركة الملاحة' }}" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-7">
                            {{ $isEn ? 'Mobile / WhatsApp Number' : 'رقم الهاتف / الواتساب للتواصل' }} <span class="text-danger">*</span>
                        </label>
                        <input type="tel" name="phone" class="form-control" placeholder="{{ $isEn ? 'e.g. 01012345678' : 'مثال: 01012345678' }}" value="{{ Auth::check() ? Auth::user()->phone : '' }}" required dir="ltr">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark fs-7">{{ $isEn ? 'Quantity' : 'الكمية المطلوبة' }}</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark fs-7">{{ $isEn ? 'Port / Delivery Point' : 'ميناء / جهة التسليم' }}</label>
                            <input type="text" name="notes" class="form-control" placeholder="{{ $isEn ? 'e.g. Alexandria Port Dock 5' : 'مثال: ميناء الإسكندرية رصيف 5' }}">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-alex-gold py-2-5 fw-bold fs-6 shadow-sm">
                            <i class="bi bi-send-fill me-1"></i> {{ $isEn ? 'Confirm & Send Order' : 'تأكيد إرسال الطلب الآن' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     LUXURY ADD-TO-QUOTE POPUP TOAST
═══════════════════════════════════════════════ --}}
<div id="quoteCartToast" class="alex-quote-toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-card-inner">
        <button type="button" class="toast-btn-close" onclick="hideQuoteToast()" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="toast-header-row">
            <div class="toast-status-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <div>
                <span class="toast-badge-success">{{ $isEn ? 'Added to Quote Cart' : 'تمت الإضافة بنجاح' }}</span>
                <div class="toast-status-text">{{ $isEn ? 'Item added to your quote request' : 'تمت إضافة الصنف لقائمة عرض السعر' }}</div>
            </div>
        </div>

        <div class="toast-product-info">
            <img id="quoteToastImg" src="" alt="Product" class="toast-product-thumb">
            <div class="toast-product-meta">
                <h6 id="quoteToastTitle" class="toast-product-title"></h6>
                <div id="quoteToastSku" class="toast-product-sku"></div>
            </div>
        </div>

        <div class="toast-actions-row">
            <a href="{{ route('quote.index') }}" class="btn-toast-view-cart">
                <i class="bi bi-basket2-fill"></i>
                <span>{{ $isEn ? 'View Quote Cart' : 'عرض سلة الطلبات' }}</span>
                <span class="badge bg-white text-dark ms-1 js-toast-count-badge">1</span>
            </a>
            <button type="button" class="btn-toast-continue" onclick="hideQuoteToast()">
                {{ $isEn ? 'Continue' : 'متابعة التصفح' }}
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ─────────────────────────────────────────────────────────────
   PRACTICAL B2B PRODUCT CARDS STYLING
───────────────────────────────────────────────────────────── */
.practical-card {
    background-color: #ffffff;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    cursor: pointer;
    position: relative;
    box-shadow: 0 2px 8px rgba(10, 25, 47, 0.04);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                border-color 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.practical-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(10, 25, 47, 0.12);
    border-color: var(--alex-navy-dark, #0A1D37);
}

.practical-card:hover .product-thumb-img {
    transform: scale(1.04);
}

/* Image Container */
.practical-card .product-card-img-wrap {
    position: relative;
    background-color: #F8FAFC;
    height: 200px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    overflow: hidden;
    border-bottom: 1.5px solid #E2E8F0;
}

.product-thumb-img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Badges */
.product-badge-category {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.96);
    border: 1px solid #CBD5E1;
    color: #0A192F;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
    z-index: 2;
    box-shadow: 0 2px 5px rgba(0,0,0,0.06);
}

[dir="ltr"] .product-badge-category {
    right: auto;
    left: 10px;
}

.product-badge-new {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #1E6FAE 0%, #0D3B66 100%);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
    z-index: 2;
    box-shadow: 0 2px 6px rgba(13, 59, 102, 0.25);
}

[dir="ltr"] .product-badge-new {
    left: auto;
    right: 10px;
}

/* Card Body */
.practical-card .product-card-body {
    padding: 1.1rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-card-title {
    font-size: 0.96rem;
    font-weight: 700;
    color: #0A192F;
    margin-bottom: 0.4rem;
    text-decoration: none;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.8em;
    transition: color 0.2s ease;
}

.practical-card:hover .product-card-title,
.product-card-title:hover {
    color: #1E6FAE;
}

.product-card-sku {
    font-size: 0.78rem;
    color: #64748B;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.sku-label {
    font-weight: 600;
}

.sku-value {
    font-weight: 700;
    color: #0A192F;
    background-color: #F1F5F9;
    padding: 1px 6px;
    border-radius: 4px;
    letter-spacing: 0.3px;
}

.product-card-desc {
    font-size: 0.82rem;
    color: #64748B;
    line-height: 1.5;
    margin-bottom: 0.85rem;
    flex-grow: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.5em;
}

/* Footer & Buttons */
.practical-card .product-card-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 8px;
    padding-top: 0.75rem;
    border-top: 1.5px solid #F1F5F9;
}

/* Action Buttons Row: Dual Buttons */
.btn-card-order-now {
    flex: 1.15;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: linear-gradient(135deg, #FAD961 0%, #D4AF37 100%);
    color: #0A192F !important;
    border-radius: 8px;
    font-size: 0.86rem;
    font-weight: 800;
    border: none;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.25);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-card-order-now:hover {
    background: #0A192F;
    color: #D4AF37 !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 16px rgba(10, 25, 47, 0.25);
}

.btn-card-add-cart {
    flex: 0.85;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background-color: #0A192F;
    color: #ffffff !important;
    border: 1.5px solid #0A192F;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-card-add-cart:hover {
    background-color: #1E6FAE;
    border-color: #1E6FAE;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 110, 174, 0.25);
}

.btn-card-add-cart.btn-success-state {
    background-color: #10B981 !important;
    border-color: #10B981 !important;
    color: #ffffff !important;
    transform: scale(1.05);
}

/* ─────────────────────────────────────────────────────────────
   MODERN POPUP TOAST NOTIFICATION
───────────────────────────────────────────────────────────── */
.alex-quote-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 10500;
    max-width: 420px;
    width: calc(100vw - 32px);
    transform: translateY(130%) scale(0.95);
    opacity: 0;
    visibility: hidden;
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                opacity 0.35s ease,
                visibility 0.35s ease;
    pointer-events: none;
}

[dir="ltr"] .alex-quote-toast {
    right: auto;
    left: 30px;
}

.alex-quote-toast.show {
    transform: translateY(0) scale(1);
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.toast-card-inner {
    background: #0A192F;
    color: #ffffff;
    border: 1.5px solid #D4AF37;
    border-radius: 16px;
    padding: 18px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.35);
    position: relative;
}

.toast-btn-close {
    position: absolute;
    top: 14px;
    left: 14px;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
    cursor: pointer;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

[dir="ltr"] .toast-btn-close {
    left: auto;
    right: 14px;
}

.toast-btn-close:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.toast-header-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.toast-status-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #10B981;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 800;
    flex-shrink: 0;
    box-shadow: 0 0 14px rgba(16, 185, 129, 0.4);
}

.toast-badge-success {
    font-size: 0.76rem;
    font-weight: 800;
    color: #D4AF37;
    letter-spacing: 0.4px;
    display: block;
}

.toast-status-text {
    font-size: 0.88rem;
    font-weight: 600;
    color: #F1F5F9;
}

.toast-product-info {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 10px;
    padding: 10px 12px;
    margin-bottom: 14px;
}

.toast-product-thumb {
    width: 48px;
    height: 48px;
    object-fit: contain;
    background: #ffffff;
    border-radius: 8px;
    padding: 4px;
    flex-shrink: 0;
}

.toast-product-meta {
    min-width: 0;
    flex-grow: 1;
}

.toast-product-title {
    font-size: 0.86rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.toast-product-sku {
    font-size: 0.74rem;
    color: rgba(255, 255, 255, 0.65);
    font-weight: 600;
}

.toast-actions-row {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-toast-view-cart {
    flex-grow: 1;
    background: linear-gradient(135deg, #FAD961 0%, #D4AF37 100%);
    color: #0A192F !important;
    font-weight: 800;
    font-size: 0.84rem;
    padding: 9px 14px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-toast-view-cart:hover {
    background: #ffffff;
    color: #0A192F !important;
    transform: translateY(-1px);
}

.btn-toast-continue {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-size: 0.82rem;
    padding: 9px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-toast-continue:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #ffffff;
}

.category-pills-wrap {
    width: 100%;
    position: relative;
}
.category-pills-scroller {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    padding: 2px 2px 8px 2px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.category-pills-scroller::-webkit-scrollbar {
    display: none;
}
.cat-pill {
    white-space: nowrap;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

@media (max-width: 576px) {
    .alex-quote-toast {
        bottom: 74px;
        right: 14px;
        left: 14px;
        width: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. Whole-Card Click Handler (Click anywhere on card or image to view details)
    document.addEventListener('click', function (e) {
        // If click was on or inside any interactive element, don't trigger card navigation
        if (e.target.closest('button, a, input, select, textarea, form, .modal, .toast, .js-prevent-card-click, .btn-card-add-cart, .btn-card-order-now, .js-btn-direct-order, .js-btn-add-quote')) {
            return;
        }

        const card = e.target.closest('.product-card[data-href]');
        if (card) {
            const href = card.getAttribute('data-href');
            if (href) {
                window.location.href = href;
            }
        }
    });

    // 2. Direct Order Modal Population (اطلب الآن - فتح وتعبئة بيانات المنتج في البوب اب)
    function populateDirectOrderModal(btn) {
        if (!btn) return;
        const pId = btn.getAttribute('data-product-id') || '';
        const pName = btn.getAttribute('data-product-name') || '';
        const pSku = btn.getAttribute('data-product-sku') || '';
        const pImg = btn.getAttribute('data-product-img') || '';
        const pCat = btn.getAttribute('data-product-cat') || '';

        const idInput = document.getElementById('modalProductId');
        const titleEl = document.getElementById('modalProductTitle');
        const skuEl = document.getElementById('modalProductSku');
        const imgEl = document.getElementById('modalProductImg');
        const catEl = document.getElementById('modalProductCat');

        if (idInput) idInput.value = pId;
        if (titleEl) titleEl.textContent = pName;
        if (skuEl) skuEl.textContent = pSku ? ('{{ $isEn ? "Code: " : "كود: " }}' + pSku) : '';
        if (imgEl) imgEl.src = pImg;
        if (catEl) {
            if (pCat) {
                catEl.textContent = pCat;
                catEl.style.display = 'inline-block';
            } else {
                catEl.style.display = 'none';
            }
        }
    }

    // Modal show event listener (Bootstrap 5)
    const directModalEl = document.getElementById('quickDirectOrderModal');
    if (directModalEl) {
        directModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                populateDirectOrderModal(button);
            }
        });
    }

    // Direct click delegation for Order Now button
    document.addEventListener('click', function (e) {
        const orderBtn = e.target.closest('.js-btn-direct-order');
        if (!orderBtn) return;

        populateDirectOrderModal(orderBtn);

        // If bootstrap modal is available and not opened by data-bs-toggle
        if (directModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = bootstrap.Modal.getInstance(directModalEl) || new bootstrap.Modal(directModalEl);
            modalInstance.show();
        }
    });

    // 3. AJAX Add-to-Quote Cart Handlers (أضف للسلة مع بوب اب التنبيه الفوري)
    document.addEventListener('click', function (e) {
        const addBtn = e.target.closest('.js-btn-add-quote');
        if (!addBtn) return;

        e.preventDefault();
        e.stopPropagation();

        const productId = addBtn.getAttribute('data-product-id');
        const productName = addBtn.getAttribute('data-product-name') || '';
        const productSku = addBtn.getAttribute('data-product-sku') || '';
        const productImg = addBtn.getAttribute('data-product-img') || '';

        // Visual feedback on button
        const originalHtml = addBtn.innerHTML;
        addBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" style="width: 1rem; height: 1rem;"></span>';
        addBtn.disabled = true;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', 1);

        fetch('{{ route("quote.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update all badge counts on page
                updateCartBadges(data.cart_count);

                // Show success state on button
                addBtn.innerHTML = '<i class="bi bi-check-lg" style="font-size:1.2rem;"></i>';
                addBtn.classList.add('btn-success-state');

                // Show modern popup toast
                showQuoteToast({
                    title: productName,
                    sku: productSku,
                    img: productImg,
                    count: data.cart_count
                });

                setTimeout(() => {
                    addBtn.innerHTML = originalHtml;
                    addBtn.classList.remove('btn-success-state');
                    addBtn.disabled = false;
                }, 2000);
            } else {
                addBtn.innerHTML = originalHtml;
                addBtn.disabled = false;
            }
        })
        .catch(err => {
            console.error('Add to quote error:', err);
            addBtn.innerHTML = originalHtml;
            addBtn.disabled = false;
        });
    });
});

// Update Cart Badges across Header, Bottom Bar & Page
function updateCartBadges(count) {
    document.querySelectorAll('.alex-nav-cart-badge, .js-quote-hero-count, .js-toast-count-badge, .js-quote-bottom-count, .js-quote-header-count').forEach(el => {
        el.textContent = count;
        el.classList.add('pulse-animation');
        setTimeout(() => el.classList.remove('pulse-animation'), 600);
    });
}

// Toast Controller
let toastTimer = null;
function showQuoteToast(item) {
    const toast = document.getElementById('quoteCartToast');
    if (!toast) return;

    const titleEl = document.getElementById('quoteToastTitle');
    const skuEl = document.getElementById('quoteToastSku');
    const imgEl = document.getElementById('quoteToastImg');
    const countBadge = document.querySelector('.js-toast-count-badge');

    if (titleEl) titleEl.textContent = item.title;
    if (skuEl) skuEl.textContent = (item.sku ? ('{{ $isEn ? "Code: " : "كود: " }}' + item.sku) : '');
    if (imgEl) imgEl.src = item.img;
    if (countBadge) countBadge.textContent = item.count;

    toast.classList.add('show');

    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        hideQuoteToast();
    }, 4500);
}

function hideQuoteToast() {
    const toast = document.getElementById('quoteCartToast');
    if (toast) {
        toast.classList.remove('show');
    }
}

// 4. Grid vs List View Toggle
function setView(mode) {
    const grid = document.getElementById('products-grid');
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');

    if (mode === 'list') {
        document.querySelectorAll('.product-grid-item').forEach(el => {
            el.className = 'col-12 product-grid-item';
        });
        document.querySelectorAll('.product-card').forEach(card => {
            card.style.flexDirection = 'row';
        });
        document.querySelectorAll('.product-card-img-wrap').forEach(img => {
            img.style.width = '200px';
            img.style.flexShrink = '0';
            img.style.height = 'auto';
            img.style.minHeight = '160px';
            img.style.borderBottom = 'none';
            img.style.borderLeft = document.dir === 'rtl' ? '1.5px solid #E2E8F0' : 'none';
            img.style.borderRight = document.dir === 'ltr' ? '1.5px solid #E2E8F0' : 'none';
        });
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    } else {
        document.querySelectorAll('.product-grid-item').forEach(el => {
            el.className = 'col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 product-grid-item';
        });
        document.querySelectorAll('.product-card').forEach(card => {
            card.style.flexDirection = 'column';
        });
        document.querySelectorAll('.product-card-img-wrap').forEach(img => {
            img.style.width = '';
            img.style.height = '200px';
            img.style.minHeight = '';
            img.style.borderBottom = '1.5px solid #E2E8F0';
            img.style.borderLeft = '';
            img.style.borderRight = '';
        });
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    }
}
</script>
@endpush
