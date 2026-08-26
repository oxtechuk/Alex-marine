@extends('layouts.admin')

@section('title', 'إدارة وتزويد المنتجات — أليكس مارين')
@section('page_title', 'إدارة كتالوج المنتجات، الأسعار والصور المتعددة')

@section('content')

<!-- 1. Header Banner & Quick Actions -->
<div class="card border-0 shadow-sm rounded-4 bg-navy text-white p-4 mb-4" style="background: linear-gradient(135deg, #0A1D37 0%, #0D3B66 100%);">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-3 border border-warning border-opacity-25" style="width: 48px; height: 48px;">
                <i class="bi bi-box-seam-fill fs-3 text-warning"></i>
            </div>
            <div>
                <h4 class="fw-extrabold text-white m-0">إدارة كتالوج ومخزون المنتجات</h4>
                <p class="text-white-50 fs-7 m-0 mt-1">عرض وتعديل أسعار POS والصور المتعددة لجميع منتجات أليكس مارين</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-25 px-3 py-2 rounded-pill fw-bold fs-7">
                إجمالي المنتجات: <strong class="text-warning fs-6 me-1">{{ $products->total() }}</strong>
            </span>
            <button type="button" class="btn btn-navy rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm d-flex align-items-center gap-2 border border-warning border-opacity-50" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle-fill text-warning fs-5"></i>
                <span>إضافة منتج جديد</span>
            </button>
        </div>
    </div>
</div>

<!-- 2. Search & Category Filter Toolbar -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-3.5 mb-4">
    <form action="{{ route('admin.products.index') }}" method="GET">
        <div class="row g-3 align-items-center">
            
            <!-- Live Search Input -->
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 bg-light" value="{{ $search }}" placeholder="ابحث باسم المنتج أو كود (SKU)...">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-filter"></i></span>
                    <select name="category_id" class="form-select border-start-0 bg-light fw-semibold" onchange="this.form.submit()">
                        <option value="">🏢 جميع التصنيفات والأقسام</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ $categoryId == $c->id ? 'selected' : '' }}>
                                {{ $c->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-navy btn-sm rounded-pill px-3 fw-bold flex-grow-1 text-white" style="background-color: #0A1D37;">
                    تصفية النتائج
                </button>
                @if($search || $categoryId)
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        إعادة ضبط
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>

<!-- 3. Products Data Table Card -->
<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle m-0 fs-7 table-hover">
                <thead class="table-light border-bottom">
                    <tr>
                        <th style="width: 70px;" class="text-center py-3">الصورة</th>
                        <th style="min-width: 200px;" class="py-3">المنتج والتصنيف</th>
                        <th style="min-width: 120px;" class="py-3">كود SKU</th>
                        <th style="min-width: 120px;" class="text-center py-3">سعر التكلفة <small class="text-muted d-block fw-normal">(داخلي)</small></th>
                        <th style="min-width: 130px;" class="text-center py-3">سعر البيع <small class="text-muted d-block fw-normal">(POS)</small></th>
                        <th style="min-width: 110px;" class="text-center py-3">حالة التوفر</th>
                        <th style="min-width: 80px;" class="text-center py-3">مميز</th>
                        <th style="width: 120px;" class="text-center py-3">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr>
                            <!-- Image Cell -->
                            <td class="text-center">
                                @php
                                    $validGalleryCount = is_array($p->gallery) ? count(array_filter($p->gallery, fn($i) => is_string($i) && !empty($i))) : 0;
                                @endphp
                                @if(!empty($p->image) && is_string($p->image))
                                    @php
                                        $imgUrl = \Illuminate\Support\Str::startsWith($p->image, ['http://', 'https://']) ? $p->image : asset($p->image);
                                    @endphp
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ $imgUrl }}" alt="{{ $p->name_ar }}" style="width: 46px; height: 46px; object-fit: cover;" class="rounded-3 border shadow-sm">
                                        @if($validGalleryCount > 0)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-white fs-8" title="عدد صور المعرض">
                                                +{{ $validGalleryCount }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-light rounded-3 d-inline-flex align-items-center justify-content-center border text-muted" style="width: 46px; height: 46px;">
                                        <i class="bi bi-box-seam fs-5"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Product Name & Category Cell -->
                            <td>
                                <div class="fw-bold text-navy fs-6">{{ $p->name_ar }}</div>
                                @if($p->name_en)
                                    <small class="text-muted d-block fs-8">{{ $p->name_en }}</small>
                                @endif
                                <div class="mt-1 d-flex align-items-center gap-1 flex-wrap">
                                    <span class="badge bg-light text-dark border px-2 py-1 fs-8">{{ $p->category->name_ar ?? 'عام' }}</span>
                                    @if($p->branch)
                                        <span class="badge bg-navy text-white fs-8" style="background-color: #0A1D37;">📍 {{ $p->branch->code }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- SKU Cell -->
                            <td>
                                <span class="badge bg-light text-navy border font-monospace fw-bold fs-7 px-2 py-1">
                                    {{ $p->sku ?: '—' }}
                                </span>
                            </td>

                            <!-- Cost Price Cell -->
                            <td class="text-center">
                                @if($p->cost_price !== null && $p->cost_price > 0)
                                    <span class="fw-bold text-secondary fs-7">{{ number_format($p->cost_price, 2) }} <small class="fs-8">جـ.م</small></span>
                                @else
                                    <span class="text-muted fs-8">غير محدد</span>
                                @endif
                            </td>

                            <!-- Selling Price Cell -->
                            <td class="text-center">
                                @if($p->price !== null && $p->price > 0)
                                    <span class="fw-extrabold text-success fs-6">{{ number_format($p->price, 2) }} <small class="fs-8">جـ.م</small></span>
                                @else
                                    <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1 fs-8">RFQ (طلب سعر)</span>
                                @endif
                            </td>

                            <!-- Availability Cell -->
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2 py-1">
                                    <i class="bi bi-check-circle me-1"></i> {{ $p->availability_status }}
                                </span>
                            </td>

                            <!-- Featured Cell -->
                            <td class="text-center">
                                @if($p->is_featured)
                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-1"><i class="bi bi-star-fill me-1"></i> نعم</span>
                                @else
                                    <span class="badge bg-light text-muted border px-2 py-1">لا</span>
                                @endif
                            </td>

                            <!-- Actions Cell -->
                            <td class="text-center">
                                <div class="d-inline-flex align-items-center gap-1">
                                    <button type="button" class="btn btn-sm btn-light border text-navy rounded-3 px-2 py-1" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $p->id }}" title="تعديل البيانات">
                                        <i class="bi bi-pencil-square me-1 text-primary"></i> تعديل
                                    </button>

                                    <form action="{{ route('admin.products.delete', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت تأكد من حذف المنتج ({{ $p->name_ar }})؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger rounded-3 px-2 py-1" title="حذف المنتج">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Product Modal -->
                        <div class="modal fade" id="editProductModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow-lg">
                                    <form action="{{ route('admin.products.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header bg-navy text-white p-3" style="background-color: #0A1D37 !important;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-pencil-square fs-4 text-warning"></i>
                                                <h5 class="modal-title fw-bold text-white fs-6 m-0">تعديل منتج: {{ $p->name_ar }}</h5>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            
                                            <!-- Section 1: Basic Information -->
                                            <div class="p-3 bg-light rounded-3 border mb-3">
                                                <h6 class="fw-bold text-navy mb-3"><i class="bi bi-info-circle text-primary me-1"></i> 1. البيانات الأساسية للمنتج</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">اسم المنتج (عربي) <span class="text-danger">*</span></label>
                                                        <input type="text" name="name_ar" class="form-control" value="{{ $p->name_ar }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">اسم المنتج (English)</label>
                                                        <input type="text" name="name_en" class="form-control" value="{{ $p->name_en }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">التصنيف الرئيسي <span class="text-danger">*</span></label>
                                                        <select name="category_id" class="form-select" required>
                                                            @foreach($categories as $c)
                                                                <option value="{{ $c->id }}" {{ $p->category_id == $c->id ? 'selected' : '' }}>{{ $c->name_ar }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">الفرع التابع له المنتج</label>
                                                        <select name="branch_id" class="form-select">
                                                            <option value="">-- جميع الفروع / عام --</option>
                                                            @foreach($branches as $b)
                                                                <option value="{{ $b->id }}" {{ $p->branch_id == $b->id ? 'selected' : '' }}>{{ $b->name_ar }} ({{ $b->code }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Section 2: Pricing & POS Settings -->
                                            <div class="p-3 bg-light rounded-3 border mb-3">
                                                <h6 class="fw-bold text-navy mb-3"><i class="bi bi-tag-fill text-warning me-1"></i> 2. الأسعار والتكلفة للنظام و POS (داخلي)</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">كود SKU</label>
                                                        <input type="text" name="sku" class="form-control" value="{{ $p->sku }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold text-secondary">سعر التكلفة (داخلي)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ $p->cost_price }}" placeholder="0.00">
                                                            <span class="input-group-text fs-8">جـ.م</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold text-success">سعر البيع (POS)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="price" class="form-control border-success fw-bold text-success" value="{{ $p->price }}" placeholder="0.00">
                                                            <span class="input-group-text fs-8 bg-success-subtle text-success border-success">جـ.م</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">حالة التوفر للمخزون</label>
                                                        <input type="text" name="availability_status" class="form-control" value="{{ $p->availability_status }}">
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center pt-3">
                                                        <div class="form-check form-switch p-2 bg-white rounded-3 border w-100 ms-1">
                                                            <input type="checkbox" name="is_featured" class="form-check-input me-0 ms-2" id="featEdit{{ $p->id }}" {{ $p->is_featured ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold text-dark" for="featEdit{{ $p->id }}">منتج مميز ومختار في الرئيسية</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Section 3: Main Image & Multiple Gallery Images -->
                                            <div class="p-3 bg-light rounded-3 border mb-3">
                                                <h6 class="fw-bold text-navy mb-3"><i class="bi bi-images text-info me-1"></i> 3. صورة المنتج الرئيسية والمعرض المتعدد</h6>
                                                <div class="row g-3">
                                                    <!-- Main Image -->
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-white rounded-3 border h-100">
                                                            <label class="form-label fw-bold text-navy fs-7">الصورة الرئيسية للمنتج</label>
                                                            @if(!empty($p->image) && is_string($p->image))
                                                                <div class="mb-2 p-1 bg-light rounded border text-center">
                                                                    @php
                                                                        $prevImg = \Illuminate\Support\Str::startsWith($p->image, ['http://', 'https://']) ? $p->image : asset($p->image);
                                                                    @endphp
                                                                    <img src="{{ $prevImg }}" style="max-height: 65px; object-fit: contain;">
                                                                </div>
                                                            @endif
                                                            <div class="mb-2">
                                                                <label class="form-label fs-8 text-muted">رفع صورة جديدة:</label>
                                                                <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                                                            </div>
                                                            <div>
                                                                <label class="form-label fs-8 text-muted">أو رابط مباشر (URL):</label>
                                                                <input type="text" name="image" class="form-control form-control-sm" value="{{ is_string($p->image) ? $p->image : '' }}" placeholder="https://domain.com/photo.png">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Multiple Gallery -->
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-white rounded-3 border h-100">
                                                            <label class="form-label fw-bold text-navy fs-7">معرض الصور المتعددة (Gallery Images)</label>
                                                            @if(!empty($p->gallery) && is_array($p->gallery))
                                                                <div class="d-flex gap-2 flex-wrap mb-2 p-2 bg-light rounded border">
                                                                    @foreach($p->gallery as $galImg)
                                                                        @if(is_string($galImg) && !empty($galImg))
                                                                            @php
                                                                                $gUrl = \Illuminate\Support\Str::startsWith($galImg, ['http://', 'https://']) ? $galImg : asset($galImg);
                                                                            @endphp
                                                                            <img src="{{ $gUrl }}" style="width: 38px; height: 38px; object-fit: cover;" class="rounded border">
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <label class="form-label fs-8 text-muted fw-bold text-primary">رفع صور متعددة إضافية (اختيار عدة صور معاً):</label>
                                                                <input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Section 4: Descriptions -->
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">وصف قصير</label>
                                                    <textarea name="short_desc_ar" class="form-control" rows="2">{{ $p->short_desc_ar }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">التفاصيل الكاملة والمواصفات</label>
                                                    <textarea name="full_desc_ar" class="form-control" rows="3">{{ $p->full_desc_ar }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-navy rounded-pill px-4 fw-bold text-white border border-warning border-opacity-50">حفظ التعديلات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-2 text-muted d-block mb-2"></i>
                                لا توجد منتجات مسجلة مطابقة للبحث أو التصفية الحالية.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-3 bg-light border-top">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-navy text-white p-3" style="background-color: #0A1D37 !important;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam-fill fs-4 text-warning"></i>
                        <h5 class="modal-title fw-bold text-white fs-6 m-0">إضافة منتج جديد للكتالوج</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <!-- Section 1: Basic Info -->
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold text-navy mb-3"><i class="bi bi-info-circle text-primary me-1"></i> 1. البيانات الأساسية للمنتج</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">اسم المنتج (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" required placeholder="مثال: سترة نجاة بحرية معتمدة SOLAS">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">اسم المنتج (English)</label>
                                <input type="text" name="name_en" class="form-control" placeholder="Marine SOLAS Life Jacket">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">التصنيف الرئيسي <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">الفرع التابع له المنتج</label>
                                <select name="branch_id" class="form-select">
                                    <option value="">-- جميع الفروع / عام --</option>
                                    @foreach($branches as $b)
                                        <option value="{{ $b->id }}">{{ $b->name_ar }} ({{ $b->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Pricing & POS -->
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold text-navy mb-3"><i class="bi bi-tag-fill text-warning me-1"></i> 2. الأسعار والتكلفة للنظام و POS (داخلي)</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">كود SKU</label>
                                <input type="text" name="sku" class="form-control" placeholder="مثال: AM-MAR-099">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-secondary">سعر التكلفة (داخلي)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="cost_price" class="form-control" placeholder="0.00">
                                    <span class="input-group-text fs-8">جـ.م</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-success">سعر البيع (POS)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="price" class="form-control border-success fw-bold text-success" placeholder="0.00">
                                    <span class="input-group-text fs-8 bg-success-subtle text-success border-success">جـ.م</span>
                                </div>
                            </div>

                           

                            <div class="col-md-6 d-flex align-items-center pt-3">
                                <div class="form-check form-switch p-2 bg-white rounded-3 border w-100 ms-1">
                                    <input type="checkbox" name="is_featured" class="form-check-input me-0 ms-2" id="featAdd">
                                    <label class="form-check-label fw-bold text-dark" for="featAdd">إظهار كمنتج مميز ومختار في الرئيسية</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Media Uploads -->
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold text-navy mb-3"><i class="bi bi-images text-info me-1"></i> 3. صورة المنتج الرئيسية والمعرض المتعدد</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-white rounded-3 border h-100">
                                    <label class="form-label fw-bold text-navy fs-7">الصورة الرئيسية للمنتج</label>
                                    <div class="mb-2">
                                        <label class="form-label fs-8 text-muted">رفع صورة من الجهاز:</label>
                                        <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                    <div>
                                        <label class="form-label fs-8 text-muted">أو رابط الصورة المباشر (URL):</label>
                                        <input type="text" name="image" class="form-control form-control-sm" placeholder="https://domain.com/photo.png">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 bg-white rounded-3 border h-100">
                                    <label class="form-label fw-bold text-navy fs-7">معرض الصور المتعددة (Gallery Images)</label>
                                    <div>
                                        <label class="form-label fs-8 text-muted fw-bold text-primary">رفع صور متعددة معاً (اختيار عدة صور):</label>
                                        <input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Descriptions -->
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">وصف قصير</label>
                            <textarea name="short_desc_ar" class="form-control" rows="2" placeholder="وصف مقتضب يظهر في البطاقات..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">التفاصيل الكاملة والمواصفات</label>
                            <textarea name="full_desc_ar" class="form-control" rows="3" placeholder="التفاصيل الفنية والاعتمادات..."></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4 fw-bold text-white border border-warning border-opacity-50">حفظ المنتج</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
