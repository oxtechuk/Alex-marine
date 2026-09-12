@extends('layouts.app')

@section('title', ($product->name_en ?: $product->name_ar) . ' — ' . (app()->getLocale() == 'en' ? 'Alex Marine Supplies' : 'أليكس مارين'))

@section('content')
@php
    $isEn = app()->getLocale() == 'en';
    $productTitle = $isEn ? ($product->name_en ?: $product->name_ar) : $product->name_ar;
    $productSubtitle = $isEn ? $product->name_ar : $product->name_en;
    $categoryTitle = $isEn ? ($category->name_en ?: $category->name_ar) : $category->name_ar;
    $mainImage = $product->image ?: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80';
    $whatsappText = urlencode(($isEn ? 'Hello Alex Marine, I want to inquire about: ' : 'مرحباً أليكس مارين، أود الاستفسار وطلب تسعير عن: ') . $productTitle . ' (' . ($isEn ? 'SKU: ' : 'كود: ') . $product->sku . ')');
@endphp


<!-- Product Showcase & Purchase Panel (Top 2-Column Section) -->
<section class="py-5 bg-white position-relative">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-start">

            <!-- Image Showcase Column (Right in RTL) -->
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="product-showcase-box position-relative">
                    
                    {{-- Quality Badge --}}
                    <div class="product-showcase-badge">
                        <i class="bi bi-patch-check-fill text-warning me-1"></i>
                        <span>{{ $isEn ? 'SOLAS & ISO Certified' : 'معتمد بحرياً SOLAS & ISO' }}</span>
                    </div>

                    {{-- Main Product Image --}}
                    <img id="mainProductShowcaseImg"
                         src="{{ $mainImage }}"
                         alt="{{ $productTitle }}"
                         class="product-showcase-img"
                         loading="lazy">

                    {{-- Zoom / Fullscreen Lightbox Button --}}
                    <button type="button" class="product-zoom-float-btn" data-bs-toggle="modal" data-bs-target="#imageZoomModal" title="{{ $isEn ? 'Zoom Image' : 'تكبير الصورة' }}">
                        <i class="bi bi-arrows-fullscreen"></i>
                    </button>
                </div>

                {{-- Gallery Thumbnails Strip (if multiple images exist) --}}
                @php
                    $galleryImages = is_array($product->gallery) ? $product->gallery : [];
                    $cleanGallery = array_filter($galleryImages, function($item) {
                        return is_string($item) && !empty($item);
                    });
                @endphp
                @if(count($cleanGallery) > 0)
                <div class="product-thumbnails-row mt-3 d-flex gap-2 overflow-auto pb-2">
                    <div class="thumb-item active" onclick="changeShowcaseImage('{{ $mainImage }}', this)">
                        <img src="{{ $mainImage }}" alt="Main" class="img-fluid rounded-3">
                    </div>
                    @foreach($cleanGallery as $galImg)
                    <div class="thumb-item" onclick="changeShowcaseImage('{{ $galImg }}', this)">
                        <img src="{{ $galImg }}" alt="Gallery" class="img-fluid rounded-3">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Action & Details Panel Column (Left in RTL) -->
            <div class="col-lg-5 order-2 order-lg-1">
                <div class="product-info-panel-card">

                    <!-- Category Pill -->
                    <div class="mb-2">
                        <span class="badge bg-light text-primary border px-3 py-1-5 rounded-pill fs-8 fw-bold">
                            {{ $categoryTitle }}
                        </span>
                    </div>

                    <!-- Product Main Title -->
                    <h1 class="fw-extrabold text-navy mb-1 fs-3 leading-tight">{{ $productTitle }}</h1>
                    @if($productSubtitle && $productSubtitle !== $productTitle)
                        <div class="text-muted fw-semibold fs-7 mb-3">{{ $productSubtitle }}</div>
                    @endif


                    <!-- Product Short Description -->
                    <div class="product-short-desc text-secondary leading-relaxed fs-7 mb-4">
                        {!! nl2br(e($product->short_desc_ar ?: $product->full_desc_ar)) !!}
                    </div>

                    <!-- Action Button 1: "اطلب الان" (Add to RFQ / Quote Cart) -->
                    <button type="button"
                            class="btn btn-panel-order w-100 mb-2"
                            data-bs-toggle="collapse"
                            data-bs-target="#panelRfqCollapse"
                            aria-expanded="false">
                        <i class="bi bi-file-earmark-plus me-1"></i>
                        <span>{{ $isEn ? 'Order Now / Add to Quote' : 'اطلب الان' }}</span>
                    </button>

                    <!-- Collapsible Quick Direct Order Form -->
                    <div class="collapse mb-3" id="panelRfqCollapse">
                        <div class="card card-body border p-3 rounded-3 bg-light shadow-sm">
                            <form action="{{ route('quote.direct') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="mb-2">
                                    <label class="form-label fs-8 fw-bold text-dark">{{ $isEn ? 'Full Name' : 'الاسم بالكامل' }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="{{ $isEn ? 'Your Name or Company' : 'أدخل اسمك أو اسم الشركة' }}" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label fs-8 fw-bold text-dark">{{ $isEn ? 'Mobile / WhatsApp Number' : 'رقم الموبايل / الواتساب' }} <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control form-control-sm" placeholder="{{ $isEn ? 'e.g. 01012345678' : 'مثال: 01012345678' }}" value="{{ Auth::check() ? Auth::user()->phone : '' }}" required dir="ltr">
                                </div>

                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <label class="form-label fs-8 fw-bold text-dark">{{ $isEn ? 'Quantity' : 'الكمية المطلوبة' }}</label>
                                        <input type="number" name="quantity" class="form-control form-control-sm" value="1" min="1">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fs-8 fw-bold text-dark">{{ $isEn ? 'Delivery Port' : 'ميناء التسليم' }}</label>
                                        <input type="text" name="notes" class="form-control form-control-sm" placeholder="{{ $isEn ? 'e.g. Alexandria' : 'مثال: الإسكندرية' }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-alex-gold w-100 btn-sm fw-bold mt-2">
                                    <i class="bi bi-send-fill me-1"></i> {{ $isEn ? 'Submit Direct Order' : 'تأكيد إرسال الطلب الآن' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Action Button 2: "تواصل عبر واتساب" (WhatsApp Direct) -->
                    <a href="https://wa.me/201200001122?text={{ $whatsappText }}"
                       target="_blank"
                       class="btn btn-panel-whatsapp w-100">
                        <i class="bi bi-whatsapp fs-5"></i>
                        <span>{{ $isEn ? 'Contact via WhatsApp' : 'تواصل عبر واتساب' }}</span>
                    </a>

                    <!-- Direct Hotline CTA -->
                    <div class="text-center mt-3 pt-2 border-top">
                        <a href="tel:+201200001122" class="text-muted fs-8 text-decoration-none fw-semibold">
                            <i class="bi bi-telephone-fill text-warning me-1"></i>
                            {{ $isEn ? 'Need immediate support? Call Our Supply Team' : 'للتوريد المباشر والاستفسار الفوري: اتصل بفريق المبيعات' }}
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Bottom Section: Detailed Description, Technical Specs & Logistics ("وف الاسفل يكون وصف") -->
<section class="py-5 bg-light border-top">
    <div class="container">
        
        <div class="bg-white rounded-4 border p-4 p-lg-5 shadow-sm">
            
            <!-- Description Nav Tabs -->
            <ul class="nav nav-pills product-desc-nav mb-4 gap-2 border-bottom pb-3" id="productDetailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-4 py-2 rounded-pill" id="desc-tab" data-bs-toggle="pill" data-bs-target="#tab-description" type="button" role="tab">
                        <i class="bi bi-card-text me-1"></i>
                        {{ $isEn ? 'Full Description' : 'الوصف والمميزات' }}
                    </button>
                </li>
                @if(!empty($product->specifications))
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-2 rounded-pill" id="specs-tab" data-bs-toggle="pill" data-bs-target="#tab-specs" type="button" role="tab">
                        <i class="bi bi-sliders me-1"></i>
                        {{ $isEn ? 'Technical Specifications' : 'المواصفات الفنية' }}
                    </button>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-2 rounded-pill" id="shipping-tab" data-bs-toggle="pill" data-bs-target="#tab-shipping" type="button" role="tab">
                        <i class="bi bi-shield-check me-1"></i>
                        {{ $isEn ? 'Quality & Port Delivery' : 'الاعتمادات وشروط التوريد' }}
                    </button>
                </li>
            </ul>

            <!-- Tab Content Panes -->
            <div class="tab-content" id="productDetailTabsContent">
                
                <!-- Tab 1: Description -->
                <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <h5 class="fw-bold text-navy mb-3">{{ $isEn ? 'Product Overview' : 'نبذة تفصيلية عن المنتج' }}</h5>
                            <div class="text-dark leading-relaxed fs-6 mb-4">
                                {!! nl2br(e($product->full_desc_ar ?: $product->short_desc_ar)) !!}
                            </div>

                            @if($product->short_desc_ar && $product->full_desc_ar && $product->short_desc_ar !== $product->full_desc_ar)
                                <div class="text-secondary leading-relaxed fs-6 mb-4">
                                    {!! nl2br(e($product->short_desc_ar)) !!}
                                </div>
                            @endif

                            @php
                                $featuresList = [];
                                if (isset($product->gallery['المميزات']) && is_array($product->gallery['المميزات'])) {
                                    $featuresList = $product->gallery['المميزات'];
                                }
                            @endphp
                            @if(!empty($featuresList))
                                <h6 class="fw-bold text-navy mt-4 mb-3">{{ $isEn ? 'Key Features & Advantages:' : 'أبرز المميزات والخصائص:' }}</h6>
                                <div class="row g-2">
                                    @foreach($featuresList as $feat)
                                        <div class="col-md-6">
                                            <div class="p-2-5 rounded-3 bg-light border d-flex align-items-center gap-2">
                                                <i class="bi bi-check-circle-fill text-success fs-6"></i>
                                                <span class="fs-7 fw-semibold text-dark">{{ $feat }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <div class="p-4 rounded-4 bg-light border">
                                <h6 class="fw-bold text-navy mb-3">{{ $isEn ? 'Supply Highlights' : 'مزايا التوريد من أليكس مارين' }}</h6>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-3 fs-7">
                                    <li class="d-flex align-items-center gap-2">
                                        <i class="bi bi-award-fill text-warning fs-5"></i>
                                        <span>{{ $isEn ? 'Certified Marine Quality SOLAS / IMO' : 'مطابقة كاملة لمواصفات SOLAS و IMO الدولية' }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-2">
                                        <i class="bi bi-clock-history text-primary fs-5"></i>
                                        <span>{{ $isEn ? 'Instant 24/7 Port Logistics' : 'توريد فوري على مدار الساعة لجميع الأرصفة' }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-medical text-success fs-5"></i>
                                        <span>{{ $isEn ? 'Official Inspection Certificates' : 'شهادات فحص واعتماد مرفقة مع كل شحنة' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Technical Specifications -->
                @if(!empty($product->specifications))
                <div class="tab-pane fade" id="tab-specs" role="tabpanel">
                    <h5 class="fw-bold text-navy mb-3">{{ $isEn ? 'Technical Specifications Table' : 'جدول المواصفات الفنية المعتمدة' }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle fs-7 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:35%;">{{ $isEn ? 'Specification Item' : 'عنصر المواصفة' }}</th>
                                    <th>{{ $isEn ? 'Certified Value / Standard' : 'القيمة المعتمدة / المعيار' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->specifications as $specName => $specValue)
                                    <tr>
                                        <td class="fw-bold text-navy">{{ $specName }}</td>
                                        <td class="text-dark">{{ $specValue }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Tab 3: Quality & Shipping -->
                <div class="tab-pane fade" id="tab-shipping" role="tabpanel">
                    <h5 class="fw-bold text-navy mb-3">{{ $isEn ? 'Delivery Ports & Maritime Certification' : 'نطاق التوريد والاعتمادات البحرية' }}</h5>
                    <p class="text-muted leading-relaxed fs-6">
                        {{ $isEn 
                            ? 'Alex Marine Supplies provides end-to-end maritime supply chain solutions with fast delivery directly to ships, offshore rigs, and shipyard docks across Egypt.'
                            : 'توفر شركة أليكس مارين خدمات التوريد المتكاملة لكافة السفن، المنصات البحرية، وشركات الخدمات البترولية مع تسليم مباشر على الأرصفة والمخطاف.' }}
                    </p>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <strong class="d-block text-navy fs-7 mb-1">{{ $isEn ? 'Alexandria & Dekheila' : 'ميناء الإسكندرية والدخيلة' }}</strong>
                                <small class="text-success fw-bold">{{ $isEn ? 'Immediate Delivery' : 'تسليم فوري مباشر' }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <strong class="d-block text-navy fs-7 mb-1">{{ $isEn ? 'Damietta & Port Said' : 'ميناء دمياط وبورسعيد' }}</strong>
                                <small class="text-success fw-bold">{{ $isEn ? 'Same Day Supply' : 'نفس اليوم' }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <strong class="d-block text-navy fs-7 mb-1">{{ $isEn ? 'Suez & Ain Sokhna' : 'ميناء السويس والعين السخنة' }}</strong>
                                <small class="text-success fw-bold">{{ $isEn ? 'Daily Scheduled Runs' : 'رحلات توريد يومية' }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <strong class="d-block text-navy fs-7 mb-1">{{ $isEn ? 'Red Sea Ports' : 'موانئ البحر الأحمر والغردقة' }}</strong>
                                <small class="text-success fw-bold">{{ $isEn ? 'On-Demand Supply' : 'عند الطلب المباشر' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- Related Products Grid (5-Column Showroom Design) -->
@if($relatedProducts->count() > 0)
<section class="py-5 bg-white border-top">
    <div class="container">
        
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-extrabold text-navy mb-0 fs-4">{{ $isEn ? 'Related Marine Equipment' : 'منتجات وتوريدات ذات صلة' }}</h3>
                <p class="text-muted fs-7 mb-0">{{ $isEn ? 'Explore complementary supplies in the same category' : 'معدات وتجهيزات متطابقة مع هذا القسم' }}</p>
            </div>
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="btn-alex-gold px-3 py-1-5 fs-8 text-decoration-none">
                <span>{{ $isEn ? 'View Category Catalog' : 'عرض باقي منتجات القسم' }}</span>
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-lg-3 fleet-5col-row">
            @foreach($relatedProducts as $relProduct)
            @php
                $relCatSlug = $relProduct->category?->slug ?? ($category->slug ?? 'general');
                $relUrl = route('products.show', ['category_slug' => $relCatSlug, 'product_slug' => $relProduct->slug]);
                $relImage = $relProduct->image ?: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=600&q=80';
                $relTitle = $isEn ? ($relProduct->name_en ?: $relProduct->name_ar) : $relProduct->name_ar;
                $relCatName = $relProduct->category ? ($isEn ? ($relProduct->category->name_en ?: $relProduct->category->name_ar) : $relProduct->category->name_ar) : ($isEn ? 'Marine Supplies' : 'توريدات بحرية');
                $relPriceVal = $relProduct->price > 0 ? number_format($relProduct->price) : null;
            @endphp
            <div class="col-fleet-5">
                <div class="showroom-product-card">
                    <div class="showroom-card-img-wrap">
                        <span class="showroom-cat-pill">{{ $relCatName }}</span>
                        <a href="{{ $relUrl }}" class="showroom-img-link">
                            <img src="{{ $relImage }}" alt="{{ $relTitle }}" class="showroom-product-img" loading="lazy">
                        </a>
                      
                    </div>
                    <div class="showroom-card-body">
                        <a href="{{ $relUrl }}" class="showroom-product-title" title="{{ $relTitle }}">
                            {{ $relTitle }}
                        </a>
                        <div class="showroom-product-sub">
                            <span>{{ $relProduct->sku ? ($isEn ? 'Code: ' : 'كود: ') . $relProduct->sku : ($isEn ? 'SOLAS Certified' : 'معتمد SOLAS') }}</span>
                            <span class="showroom-year-badge">2026</span>
                        </div>
                        <div class="showroom-card-footer">
                            <a href="{{ $relUrl }}" class="showroom-btn-details w-100">
                                <span>{{ $isEn ? 'View Details' : 'التفاصيل' }}</span>
                                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-header border-0 text-end">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalZoomImg"
                     src="{{ $mainImage }}" 
                     alt="{{ $productTitle }}" 
                     class="img-fluid rounded-4 shadow-lg" 
                     style="max-height: 85vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeShowcaseImage(src, thumbEl) {
        const showcase = document.getElementById('mainProductShowcaseImg');
        const modalImg = document.getElementById('modalZoomImg');
        if (showcase) showcase.src = src;
        if (modalImg) modalImg.src = src;
        
        document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
        if (thumbEl) thumbEl.classList.add('active');
    }
</script>
@endpush
@endsection
