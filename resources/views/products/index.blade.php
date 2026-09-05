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
                            <a href="{{ route('quote.index') }}" class="text-decoration-none" style="color:var(--alex-gold);">
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
                        <button type="button" class="view-toggle-btn active" id="grid-view-btn" onclick="setView('grid')" title="{{ $isEn ? 'Grid' : 'عرض شبكي' }}">
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

        {{-- Products Grid --}}
        <div class="row g-4 mb-4" id="products-grid">
            @forelse($products as $i => $product)
            <div class="col-lg-4 col-md-6 product-grid-item" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 60 }}">
                <div class="product-card">
                    <div class="product-card-img-wrap">
                        <span class="product-badge-category">
                            {{ $isEn ? ($product->category->name_en ?: $product->category->name_ar) : ($product->category->name_ar ?? 'عام') }}
                        </span>
                        @if($product->is_featured)
                            <span class="product-badge-new">{{ $isEn ? 'Featured' : 'مميز' }}</span>
                        @endif

                        <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=600&q=80' }}"
                             alt="{{ $isEn ? ($product->name_en ?: $product->name_ar) : $product->name_ar }}"
                             loading="lazy">
                    </div>

                    <div class="product-card-body">
                        <a href="{{ route('products.show', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}"
                           class="product-card-title">
                            {{ $isEn ? ($product->name_en ?: $product->name_ar) : $product->name_ar }}
                        </a>

                        <div class="product-card-sku">
                            {{ $isEn ? 'SKU' : 'كود' }}: <strong>{{ $product->sku }}</strong>
                        </div>

                        <p class="product-card-desc">
                            {{ Str::limit($isEn ? ($product->short_desc_en ?: $product->short_desc_ar) : $product->short_desc_ar, 85) }}
                        </p>

                        <div class="product-card-footer">
                            <span class="product-availability-badge">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ $product->availability_status ?? ($isEn ? 'Available' : 'متوفر') }}
                            </span>

                            <div class="d-flex align-items-center gap-2">
                                {{-- Add to Quote Cart --}}
                                <form action="{{ route('quote.add') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center"
                                            title="{{ $isEn ? 'Add to Quote' : 'أضف لطلب السعر' }}"
                                            style="width:32px; height:32px; border-radius:6px;">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </form>

                                {{-- Details --}}
                                <a href="{{ route('products.show', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}"
                                   class="btn-alex-primary py-1 px-3"
                                   style="font-size:0.8rem;">
                                    {{ $isEn ? 'Details' : 'تفاصيل' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12">
                <div class="p-5 text-center bg-white rounded border">
                    <i class="bi bi-box-seam d-block mb-3 text-muted" style="font-size:3rem;"></i>
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
        <div class="d-flex justify-content-center" data-aos="fade-up">
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

@endsection

@push('scripts')
<script>
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
            img.style.width = '180px';
            img.style.flexShrink = '0';
            img.style.height = 'auto';
            img.style.minHeight = '150px';
            img.style.borderBottom = 'none';
        });
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    } else {
        document.querySelectorAll('.product-grid-item').forEach(el => {
            el.className = 'col-lg-4 col-md-6 product-grid-item';
        });
        document.querySelectorAll('.product-card').forEach(card => {
            card.style.flexDirection = 'column';
        });
        document.querySelectorAll('.product-card-img-wrap').forEach(img => {
            img.style.width = '';
            img.style.height = '200px';
            img.style.minHeight = '';
            img.style.borderBottom = '1px solid var(--alex-border)';
        });
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    }
}
</script>
@endpush
