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
            <ol class="breadcrumb breadcrumb-alex">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $isEn ? 'Products Catalog' : 'دليل المنتجات' }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
              
                <h1 class="display-section text-white mb-2">
                    {{ $isEn ? 'Marine & Industrial Safety Catalog' : 'دليل المنتجات والتوريدات البحرية' }}
                </h1>
                <p class="mb-0 text-white-50" style="font-size:1rem; max-width:550px; line-height:1.7;">
                    {{ $isEn
                        ? 'Browse our certified marine supplies, industrial PPE, and firefighting equipment. Select items to request an official quotation.'
                        : 'تصفح قائمة المنتجات المعتمدة للتوريدات ومهمات السلامة المهنية، وأضف المنتجات المطلوبة لإصدار عرض سعر رسمي لمؤسستك.' }}
                </p>
            </div>
            <div class="col-lg-5 text-{{ $isEn ? 'end' : 'start' }} mt-4 mt-lg-0" data-aos="fade-left">
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

        {{-- Category Pills --}}
        <div class="d-flex flex-wrap gap-2 mb-4" data-aos="fade-up">
            <a href="{{ route('products.index') }}"
               class="cat-pill {{ !request('category') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap-fill"></i>
                {{ $isEn ? 'All Products' : 'الكل' }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug, 'search' => request('search')]) }}"
                   class="cat-pill {{ request('category') == $cat->slug ? 'active' : '' }}">
                    <i class="bi {{ $cat->icon ?? 'bi-box' }}"></i>
                    {{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}
                </a>
            @endforeach
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
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 product-grid-item" data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 50 }}">
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

                        {{-- Action Buttons Row --}}
                        <div class="product-card-footer">
                            {{-- Details Button --}}
                            <a href="{{ $productUrl }}" class="btn-card-details">
                                <span>{{ $isEn ? 'Details' : 'تفاصيل' }}</span>
                                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                            </a>

                            {{-- Add to Quote Cart Button (+) --}}
                            <form action="{{ route('quote.add') }}" method="POST" class="d-inline js-add-quote-form" onsubmit="event.preventDefault();">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="button"
                                        class="btn-card-add-quote js-btn-add-quote"
                                        title="{{ $isEn ? 'Add to Quote Cart' : 'أضف لطلب عرض السعر' }}"
                                        aria-label="{{ $isEn ? 'Add to Quote Cart' : 'أضف لطلب عرض السعر' }}"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $productTitle }}"
                                        data-product-sku="{{ $product->sku }}"
                                        data-product-img="{{ $productImg }}">
                                    <i class="bi bi-plus-lg add-icon-default"></i>
                                </button>
                            </form>
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
            <div class="col-lg-8" data-aos="fade-right">
                <h3 class="fw-black text-white mb-2" style="font-size:1.5rem;">
                    {{ $isEn ? "Can't find a specific marine or safety item?" : 'هل تبحث عن صنف أو مقاس بحري خاص؟' }}
                </h3>
                <p class="mb-0 text-white-50" style="font-size:0.92rem;">
                    {{ $isEn
                        ? 'Contact our technical supply team directly for custom vessel procurement orders or immediate port delivery.'
                        : 'تواصل مع فريق التوريدات الفني مباشرة لتوفير الأصناف الخاصة وتجهيز السفن والموانئ.' }}
                </p>
            </div>
            <div class="col-lg-4 text-{{ $isEn ? 'end' : 'start' }}" data-aos="fade-left">
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
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1),
                border-color 0.25s ease;
}

.practical-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(10, 25, 47, 0.12);
    border-color: var(--alex-navy-dark, #0A1D37);
}

.practical-card:hover .product-thumb-img {
    transform: scale(1.05);
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
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
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

/* Details Button */
.btn-card-details {
    flex-grow: 1;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background-color: #0A192F;
    color: #ffffff !important;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    transition: all 0.2s ease;
}

.btn-card-details:hover {
    background-color: #1E6FAE;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 110, 174, 0.25);
}

/* Large (+) Add Button */
.btn-card-add-quote {
    width: 44px;
    height: 42px;
    min-width: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #F1F5F9;
    color: #0A192F;
    border: 1.5px solid #CBD5E1;
    border-radius: 8px;
    font-size: 1.25rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-card-add-quote:hover {
    background-color: #D4AF37;
    border-color: #D4AF37;
    color: #0A192F;
    transform: scale(1.08);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.35);
}

.btn-card-add-quote.btn-success-state {
    background-color: #10B981 !important;
    border-color: #10B981 !important;
    color: #ffffff !important;
    transform: scale(1.1);
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

@media (max-width: 576px) {
    .alex-quote-toast {
        bottom: 20px;
        right: 16px;
        left: 16px;
        width: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
// 1. Whole-Card Click Handler (Click anywhere to go to product details)
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        const card = e.target.closest('.product-card[data-href]');
        if (!card) return;

        // If click was on a button, link, form, input or close button, do not navigate card
        if (e.target.closest('button, a, form, input, select, .js-prevent-card-click, .btn-card-add-quote')) {
            return;
        }

        const href = card.getAttribute('data-href');
        if (href) {
            window.location.href = href;
        }
    });

    // 2. AJAX Add-to-Quote Cart Handlers
    document.querySelectorAll('.js-btn-add-quote').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name') || '';
            const productSku = this.getAttribute('data-product-sku') || '';
            const productImg = this.getAttribute('data-product-img') || '';

            // Visual feedback on button
            const originalIcon = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" style="width: 1rem; height: 1rem;"></span>';
            this.disabled = true;

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
                    this.innerHTML = '<i class="bi bi-check-lg" style="font-size:1.3rem;"></i>';
                    this.classList.add('btn-success-state');

                    // Show modern popup toast
                    showQuoteToast({
                        title: productName,
                        sku: productSku,
                        img: productImg,
                        count: data.cart_count
                    });

                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                        this.classList.remove('btn-success-state');
                        this.disabled = false;
                    }, 2000);
                } else {
                    this.innerHTML = originalIcon;
                    this.disabled = false;
                }
            })
            .catch(err => {
                console.error('Add to quote error:', err);
                this.innerHTML = originalIcon;
                this.disabled = false;
            });
        });
    });
});

// Update Cart Badges across Header & Page
function updateCartBadges(count) {
    document.querySelectorAll('.alex-nav-cart-badge, .js-quote-hero-count, .js-toast-count-badge').forEach(el => {
        el.textContent = count;
        el.classList.add('pulse-animation');
        setTimeout(() => el.classList.remove('pulse-animation'), 600);
    });
}

// Toast Controller
let toastTimer = null;
function showQuoteToast(item) {
    const toast = document.getElementById('quoteCartToast');
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

// 3. Grid vs List View Toggle
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
</script>
@endpush
