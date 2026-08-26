@extends('layouts.admin')

@section('title', 'إدارة مشاريع وحالات الصيانة — أليكس مارين')
@section('page_title', 'مشاريع وحالات الصيانة (Maintenance Cases)')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center gap-3 bg-success bg-opacity-10 text-success" role="alert">
        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
        <div class="fw-bold">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- 1. Header Banner & Quick Actions -->
<div class="card border-0 shadow-sm rounded-4 text-white p-4 mb-4" style="background: linear-gradient(135deg, #0A1D37 0%, #0D3B66 100%);">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-3 border border-warning border-opacity-25" style="width: 52px; height: 52px;">
                <i class="bi bi-tools fs-3 text-warning"></i>
            </div>
            <div>
                <h4 class="fw-extrabold text-white m-0">إدارة مشاريع وحالات الصيانة (Case Studies)</h4>
                <p class="text-white-50 fs-7 m-0 mt-1">عرض وتوثيق مشاريع الصيانة البحرية، المعارض التفاعلية، ومقارنات Before / After</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-25 px-3 py-2 rounded-pill fw-bold fs-7">
                إجمالي المشاريع: <strong class="text-warning fs-6 me-1">{{ $projects->total() }}</strong>
            </span>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-navy rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm d-flex align-items-center gap-2 border border-warning border-opacity-50">
                <i class="bi bi-plus-circle-fill text-warning fs-5"></i>
                <span>إضافة دراسة حالة جديدة</span>
            </a>
        </div>
    </div>
</div>

<!-- 2. Search & Filter Bar -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-3.5 mb-4">
    <form action="{{ route('admin.projects.index') }}" method="GET">
        <div class="row g-3 align-items-center">
            
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 bg-light" value="{{ $search }}" placeholder="ابحث باسم المشروع، العميل، أو نوع السفينة...">
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-filter"></i></span>
                    <select name="service_id" class="form-select border-start-0 bg-light fw-semibold" onchange="this.form.submit()">
                        <option value="">⚙️ جميع خدمات الصيانة</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" {{ $serviceId == $s->id ? 'selected' : '' }}>
                                {{ $s->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-navy w-100 rounded-3 fw-bold">تطبيق</button>
                @if($search || $serviceId)
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-light border rounded-3"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>

        </div>
    </form>
</div>

<!-- 3. Projects Table -->
<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="bg-light text-muted fs-7 text-uppercase fw-bold border-bottom">
                <tr>
                    <th class="text-start ps-4 py-3">المشروع / دراسة الحالة</th>
                    <th class="py-3">الخدمة المرتبطة</th>
                    <th class="py-3">العميل / السفينة</th>
                    <th class="py-3">الموقع</th>
                    <th class="py-3">مقارنة Before/After</th>
                    <th class="py-3">المعرض</th>
                    <th class="py-3">الحالة</th>
                    <th class="text-end pe-4 py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($projects as $p)
                <tr>
                    <!-- Project info with image -->
                    <td class="text-start ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="position-relative rounded-3 overflow-hidden border flex-shrink-0" style="width: 60px; height: 60px;">
                                <img src="{{ $p->main_image_url }}" alt="{{ $p->title_ar }}" class="w-100 h-100 object-fit-cover" onerror="this.src='https://via.placeholder.com/60'">
                                @if($p->video_url)
                                    <span class="position-absolute bottom-0 end-0 bg-danger text-white rounded-start px-1 fs-9"><i class="bi bi-play-fill"></i></span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none hover-gold d-block mb-1">
                                    {{ $p->title_ar }}
                                </a>
                                @if($p->title_en)
                                    <div class="text-muted fs-8">{{ $p->title_en }}</div>
                                @endif
                                @if($p->is_featured)
                                    <span class="badge bg-warning text-dark fs-9 rounded-pill mt-1"><i class="bi bi-star-fill me-1"></i> مميز بالرئيسية</span>
                                @endif
                            </div>
                        </div>
                    </td>

                    <!-- Service -->
                    <td class="py-3">
                        @if($p->service)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1.5 rounded-pill fs-8">
                                <i class="bi {{ $p->service->icon ?? 'bi-gear' }} me-1"></i> {{ $p->service->name_ar }}
                            </span>
                        @else
                            <span class="text-muted fs-8">—</span>
                        @endif
                    </td>

                    <!-- Client / Vessel -->
                    <td class="py-3">
                        <div class="fw-bold text-dark fs-7">{{ $p->client_name ?? '—' }}</div>
                        @if($p->vessel_type)
                            <div class="text-muted fs-8">{{ $p->vessel_type }}</div>
                        @endif
                    </td>

                    <!-- Location -->
                    <td class="py-3">
                        <div class="text-muted fs-8"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $p->location_ar ?? '—' }}</div>
                    </td>

                    <!-- Before / After check -->
                    <td class="py-3">
                        @if(!empty($p->before_image) && !empty($p->after_image))
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-8">
                                <i class="bi bi-sliders me-1"></i> مفعل بالسلايدر
                            </span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-muted px-2 py-1 rounded-pill fs-8">غير متوفر</span>
                        @endif
                    </td>

                    <!-- Gallery count -->
                    <td class="py-3">
                        @php $gCount = is_array($p->gallery_images) ? count($p->gallery_images) : 0; @endphp
                        <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill fs-8">
                            <i class="bi bi-images me-1 text-primary"></i> {{ $gCount }} صور
                        </span>
                    </td>

                    <!-- Status -->
                    <td class="py-3">
                        @if($p->is_active)
                            <span class="badge bg-success text-white px-2.5 py-1 rounded-pill fs-8"><i class="bi bi-check-circle me-1"></i> نشط</span>
                        @else
                            <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill fs-8">مسودة</span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="text-end pe-4 py-3">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="btn btn-sm btn-light border text-primary" title="معاينة في الموقع">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $p->id) }}" class="btn btn-sm btn-light border text-navy fw-bold" title="تعديل">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $p->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف دراسة الحالة هذه نهائياً؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border text-danger" title="حذف">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-tools fs-1 text-secondary opacity-50 d-block mb-3"></i>
                            <h5>لا توجد مشاريع صيانة مسجلة حتى الآن</h5>
                            <p class="fs-7 text-muted">ابدأ بإضافة أول دراسة حالة لمشاريع الصيانة البحرية لشركتك</p>
                            <a href="{{ route('admin.projects.create') }}" class="btn btn-navy rounded-pill px-4 py-2 mt-2">
                                <i class="bi bi-plus-circle me-1 text-warning"></i> إضافة أول مشروع
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($projects->hasPages())
        <div class="p-3 border-top d-flex justify-content-center">
            {{ $projects->links() }}
        </div>
    @endif
</div>

@endsection
