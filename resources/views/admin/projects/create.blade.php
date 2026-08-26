@extends('layouts.admin')

@section('title', 'إضافة حالة صيانة جديدة (Before & After) — أليكس مارين')
@section('page_title', 'إضافة حالة صيانة جديدة')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-light rounded-circle shadow-sm border p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-right fs-5 text-dark"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark m-0">إضافة حالة صيانة جديدة (Before & After Case)</h4>
            <p class="text-muted fs-7 m-0">قم بإدخال عنوان ووصف الصيانة ورفع صورتي المقارنة قبل وبعد</p>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> يرجى مراجعة الأخطاء:</div>
        <ul class="m-0 ps-3">
            @foreach ($errors->all() as $error)
                <li class="fs-7">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        
        <!-- Left Column: Information & Before/After -->
        <div class="col-lg-8">
            
            <!-- 1. Basic Info -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                <h5 class="fw-bold text-navy border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-warning"></i> بيانات حالة الصيانة
                </h5>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-dark fs-7">عنوان دراسة الحالة / المشروع <span class="text-danger">*</span></label>
                        <input type="text" name="title_ar" class="form-control form-control-lg rounded-3 fs-6" value="{{ old('title_ar') }}" placeholder="مثال: صيانة وتجديد منظومة الإطفاء CO2 لسفينة الشحن MV Star" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark fs-7">العنوان بالإنجليزية (اختياري)</label>
                        <input type="text" name="title_en" class="form-control rounded-3" value="{{ old('title_en') }}" placeholder="e.g. CO2 Fire Suppression System Overhaul">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark fs-7">الخدمة المرتبطة</label>
                        <select name="service_id" class="form-select rounded-3">
                            <option value="">-- اختر نوع الخدمة --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" {{ old('service_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name_ar }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark fs-7">الموقع / الميناء (اختياري)</label>
                        <input type="text" name="location_ar" class="form-control rounded-3" value="{{ old('location_ar') }}" placeholder="مثال: ميناء الإسكندرية">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark fs-7">نوع السفينة أو المنشأة (اختياري)</label>
                        <input type="text" name="vessel_type" class="form-control rounded-3" value="{{ old('vessel_type') }}" placeholder="مثال: ناقلة بضائع / يخت سياحي">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark fs-7">مدة التنفيذ (اختياري)</label>
                        <input type="text" name="duration" class="form-control rounded-3" value="{{ old('duration') }}" placeholder="مثال: 4 أيام عمل">
                    </div>
                </div>
            </div>

            <!-- 2. Interactive Before & After Images -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4 border border-warning border-opacity-30" style="background: linear-gradient(180deg, #FFFFFF 0%, #FAFBFD 100%);">
                <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4">
                    <div class="bg-warning bg-opacity-20 text-warning p-2 rounded-3">
                        <i class="bi bi-sliders fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-navy m-0">صور المقارنة التفاعلية (Before & After)</h5>
                        <small class="text-muted">ارفع صورة للمعدة قبل الصيانة وصورة بعد اكتمال الصيانة لتوليد السلايدر التفاعلي</small>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Before Image -->
                    <div class="col-md-6">
                        <div class="card border border-2 border-danger border-opacity-30 rounded-4 p-3 bg-white h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-danger text-white rounded-pill px-3 py-1.5 fs-7 fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> BEFORE (قبل الصيانة)
                                </span>
                            </div>
                            
                            <label class="form-label fw-bold text-dark fs-8 mt-2 mb-1">رفع صورة من جهازك:</label>
                            <input type="file" name="before_image_file" class="form-control mb-2 rounded-3" accept="image/*" onchange="previewImg(this, 'before_preview')">
                            
                            <label class="form-label fw-bold text-muted fs-8 mb-1">أو رابط صورة خارجي:</label>
                            <input type="text" name="before_image_url" class="form-control form-control-sm rounded-3" placeholder="https://..." value="{{ old('before_image_url') }}">

                            <div class="mt-3 text-center rounded-3 bg-light p-2 border" style="min-height: 160px; display: flex; align-items: center; justify-content: center;">
                                <img id="before_preview" src="" alt="Before" class="img-fluid rounded-3 d-none" style="max-height: 160px; object-fit: contain;">
                                <div id="before_placeholder" class="text-muted fs-8"><i class="bi bi-image fs-1 d-block mb-1 opacity-50"></i>معاينة صورة قبل الصيانة</div>
                            </div>
                        </div>
                    </div>

                    <!-- After Image -->
                    <div class="col-md-6">
                        <div class="card border border-2 border-success border-opacity-30 rounded-4 p-3 bg-white h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-success text-white rounded-pill px-3 py-1.5 fs-7 fw-bold">
                                    <i class="bi bi-check2-circle me-1"></i> AFTER (بعد الصيانة)
                                </span>
                            </div>

                            <label class="form-label fw-bold text-dark fs-8 mt-2 mb-1">رفع صورة من جهازك:</label>
                            <input type="file" name="after_image_file" class="form-control mb-2 rounded-3" accept="image/*" onchange="previewImg(this, 'after_preview')">
                            
                            <label class="form-label fw-bold text-muted fs-8 mb-1">أو رابط صورة خارجي:</label>
                            <input type="text" name="after_image_url" class="form-control form-control-sm rounded-3" placeholder="https://..." value="{{ old('after_image_url') }}">

                            <div class="mt-3 text-center rounded-3 bg-light p-2 border" style="min-height: 160px; display: flex; align-items: center; justify-content: center;">
                                <img id="after_preview" src="" alt="After" class="img-fluid rounded-3 d-none" style="max-height: 160px; object-fit: contain;">
                                <div id="after_placeholder" class="text-muted fs-8"><i class="bi bi-image fs-1 d-block mb-1 opacity-50"></i>معاينة صورة بعد الصيانة</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Description -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                <h5 class="fw-bold text-navy border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-file-text-fill text-warning"></i> تفاصيل ووصف الصيانة
                </h5>

                <div>
                    <label class="form-label fw-bold text-dark fs-7">الوصف ونطاق العمل المنجز</label>
                    <textarea name="description_ar" class="form-control rounded-3" rows="5" placeholder="اكتب ملخصاً لما تم تنفيذه خلال عملية الصيانة والفحص...">{{ old('description_ar') }}</textarea>
                </div>
            </div>

        </div>

        <!-- Right Column: Settings & Publish -->
        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4 sticky-top" style="top: 20px;">
                <h5 class="fw-bold text-navy border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-gear-fill text-warning"></i> إعدادات النشر
                </h5>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label fw-bold fs-7" for="is_active">نشر الحالة وجعلها مرئية للزوار</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" checked>
                    <label class="form-check-label fw-bold fs-7" for="is_featured">عرض في الصفحة الرئيسية (Featured)</label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark fs-7">ترتيب الظهور</label>
                    <input type="number" name="sort_order" class="form-control rounded-3" value="0">
                </div>

                <button type="submit" class="btn btn-navy w-100 py-3 rounded-pill fw-bold text-white shadow-sm mt-3 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                    <span>حفظ ونشر حالة الصيانة</span>
                </button>
            </div>

        </div>

    </div>
</form>

<script>
function previewImg(input, targetId) {
    const preview = document.getElementById(targetId);
    const placeholder = document.getElementById(targetId.replace('_preview', '_placeholder'));
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
