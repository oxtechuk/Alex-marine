@php
    $isEn = app()->getLocale() == 'en';
    $chunks = $fleetProducts->chunk(10);
@endphp

<div id="fleetProductsCarousel" class="carousel slide" data-bs-ride="false">
    {{-- Carousel Inner --}}
    <div class="carousel-inner">
        @forelse($chunks as $chunkIndex => $chunk)
        <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
            <div class="row g-3 g-lg-3 fleet-5col-row">
                @foreach($chunk as $i => $product)
                @php
                    $productUrl = route('products.show', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]);
                    $productImage = $product->image ?: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=600&q=80';
                    $productTitle = $isEn ? ($product->name_en ?: $product->name_ar) : $product->name_ar;
                    $categoryName = $isEn ? ($product->category->name_en ?: $product->category->name_ar) : ($product->category->name_ar ?? 'توريدات بحرية');
                    $priceVal = $product->price > 0 ? number_format($product->price) : null;
                @endphp
                <div class="col-fleet-5">
                    <div class="showroom-product-card">
                        {{-- Top Cover Image Area --}}
                        <div class="showroom-card-img-wrap">
                            <span class="showroom-cat-pill">{{ $categoryName }}</span>

                            <a href="{{ $productUrl }}" class="showroom-img-link">
                                <img src="{{ $productImage }}"
                                     alt="{{ $productTitle }}"
                                     class="showroom-product-img"
                                     loading="lazy">
                            </a>

                            {{-- Floating Quick Action Button --}}
                            <a href="{{ $productUrl }}" class="showroom-float-btn" title="{{ $isEn ? 'Quick View / Compare' : 'عرض التفاصيل والطلب' }}">
                                <i class="bi bi-arrow-left-right"></i>
                            </a>
                        </div>

                        {{-- Card Body --}}
                        <div class="showroom-card-body">
                            <a href="{{ $productUrl }}" class="showroom-product-title" title="{{ $productTitle }}">
                                {{ $productTitle }}
                            </a>

                            <div class="showroom-product-sub">
                                <span>{{ $product->sku ? ($isEn ? 'Code: ' : 'كود: ') . $product->sku : ($isEn ? 'SOLAS Certified' : 'معتمد SOLAS') }}</span>
                                <span class="showroom-year-badge">2026</span>
                            </div>

                            {{-- Card Footer: Details Button + Price / Inquiry --}}
                            <div class="showroom-card-footer">
                                <a href="{{ $productUrl }}" class="showroom-btn-details">
                                    {{ $isEn ? 'Details' : 'التفاصيل' }}
                                </a>

                                <div class="showroom-price-wrap">
                                    <div class="showroom-main-price">
                                        @if($priceVal)
                                            <span class="showroom-currency">{{ $isEn ? 'EGP' : 'ج.م' }}</span>
                                            <strong>{{ $priceVal }}</strong>
                                        @else
                                            <span class="showroom-rfq-text">{{ $isEn ? 'Request RFQ' : 'طلب تسعير' }}</span>
                                        @endif
                                    </div>
                                    <div class="showroom-sub-price">
                                        {{ $isEn ? 'Direct Port Supply' : 'توريد فوري للموانئ' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="p-4 bg-white rounded-3 border text-muted">
                <i class="bi bi-box-seam fs-1 text-muted d-block mb-2"></i>
                <p class="mb-0">{{ $isEn ? 'No products available in this category yet.' : 'لا توجد منتجات متوفرة في هذا القسم حالياً.' }}</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Slider Controls (Only if more than 1 chunk) --}}
    @if($chunks->count() > 1)
    <div class="d-flex align-items-center justify-content-center gap-3 mt-4">
        <button class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center"
                type="button"
                data-bs-target="#fleetProductsCarousel"
                data-bs-slide="prev"
                style="width:40px; height:40px; border: 1.5px solid var(--alex-border);"
                title="{{ $isEn ? 'Previous' : 'السابق' }}">
            <i class="bi bi-chevron-{{ $isEn ? 'left' : 'right' }} fs-6"></i>
        </button>

        {{-- Indicators Dots --}}
        <div class="d-flex align-items-center gap-2">
            @foreach($chunks as $dotIndex => $chunk)
            <button type="button"
                    data-bs-target="#fleetProductsCarousel"
                    data-bs-slide-to="{{ $dotIndex }}"
                    class="btn p-0 rounded-circle border-0 {{ $dotIndex === 0 ? 'bg-dark' : 'bg-secondary opacity-50' }}"
                    style="width:10px; height:10px;"
                    aria-label="Slide {{ $dotIndex + 1 }}"></button>
            @endforeach
        </div>

        <button class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center"
                type="button"
                data-bs-target="#fleetProductsCarousel"
                data-bs-slide="next"
                style="width:40px; height:40px; border: 1.5px solid var(--alex-border);"
                title="{{ $isEn ? 'Next' : 'التالي' }}">
            <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} fs-6"></i>
        </button>
    </div>
    @endif
</div>
