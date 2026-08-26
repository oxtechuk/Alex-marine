@extends('layouts.admin')

@section('title', 'إدارة التصنيفات والأقسام — أليكس مارين')
@section('page_title', 'هيكلية الأقسام الرئيسية والتصنيفات الفرعية')

@section('content')

<!-- Header Banner -->
<div class="card border-0 shadow-sm rounded-4 bg-navy text-white p-4 mb-4" style="background: linear-gradient(135deg, #0A1D37 0%, #0D3B66 100%);">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-3 border border-warning border-opacity-25" style="width: 48px; height: 48px;">
                <i class="bi bi-diagram-2-fill fs-3 text-warning"></i>
            </div>
            <div>
                <h4 class="fw-extrabold text-white m-0">دليل وهيكلية كتالوج أليكس مارين</h4>
                <p class="text-white-50 fs-7 m-0 mt-1">تنظيم الأقسام الرئيسية والتصنيفات الفرعية وربطها بالمنتجات والمعدات البحرية</p>
            </div>
        </div>

        <button type="button" class="btn btn-navy rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm d-flex align-items-center gap-2 border border-warning border-opacity-50" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-folder-plus text-warning fs-5"></i>
            <span>إضافة تصنيف جديد</span>
        </button>
    </div>
</div>

<!-- Main Categories Hierarchy Grid -->
<div class="row g-4 mb-4">
    @forelse($categories as $mainCat)
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 border-top border-4" style="border-top-color: #0A1D37 !important;">
                
                <!-- Main Category Header Card -->
                <div class="card-header bg-white p-3 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-navy bg-opacity-10 text-navy rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi {{ $mainCat->icon ?: 'bi-folder-fill' }} fs-5 text-navy"></i>
                        </div>
                        <div>
                            <h5 class="fw-extrabold text-navy m-0 fs-6">{{ $mainCat->name_ar }}</h5>
                            @if($mainCat->name_en)<small class="text-muted fs-8">{{ $mainCat->name_en }}</small>@endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-navy border font-monospace px-3 py-1.5 rounded-pill fw-bold fs-8">
                            {{ $mainCat->products_count + $mainCat->children->sum(fn($c) => $c->products->count()) }} منتج
                        </span>

                        <button class="btn btn-sm btn-light border text-navy rounded-3 px-2 py-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $mainCat->id }}" title="تعديل التصنيف">
                            <i class="bi bi-pencil-square text-primary"></i>
                        </button>

                        <form action="{{ route('admin.categories.delete', $mainCat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت تأكد من حذف تصنيف ({{ $mainCat->name_ar }})؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light border text-danger rounded-3 px-2 py-1" title="حذف التصنيف">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sub-Categories & Products List -->
                <div class="card-body p-3">
                    @if($mainCat->description_ar)
                        <p class="text-muted fs-7 mb-3 bg-light p-2.5 rounded-3 border">{{ $mainCat->description_ar }}</p>
                    @endif

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="fw-bold text-navy fs-7 m-0"><i class="bi bi-diagram-3 text-warning me-1"></i> التصنيفات الفرعية التابعة:</h6>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mb-2">
                        @forelse($mainCat->children as $subCat)
                            <div class="p-2.5 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-return-left text-marine"></i>
                                    <div>
                                        <strong class="text-navy fs-7">{{ $subCat->name_ar }}</strong>
                                        @if($subCat->name_en)<small class="text-muted fs-8">({{ $subCat->name_en }})</small>@endif
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-white text-dark border px-2 py-1 fs-8">
                                        {{ $subCat->products->count() }} منتج
                                    </span>

                                    <button class="btn btn-xs btn-light border text-navy rounded-2 px-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $subCat->id }}">
                                        <i class="bi bi-pencil text-primary"></i>
                                    </button>

                                    <form action="{{ route('admin.categories.delete', $subCat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت تأكد من حذف التصنيف الفرعي؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-light border text-danger rounded-2 px-2"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>

                            <!-- Edit SubCategory Modal -->
                            <div class="modal fade" id="editCategoryModal{{ $subCat->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow-lg">
                                        <form action="{{ route('admin.categories.update', $subCat->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-navy text-white p-3" style="background-color: #0A1D37 !important;">
                                                <h5 class="modal-title fw-bold text-white fs-6"><i class="bi bi-pencil-square me-2 text-warning"></i> تعديل تصنيف: {{ $subCat->name_ar }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">اسم التصنيف (عربي) <span class="text-danger">*</span></label>
                                                    <input type="text" name="name_ar" class="form-control" value="{{ $subCat->name_ar }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">اسم التصنيف (English)</label>
                                                    <input type="text" name="name_en" class="form-control" value="{{ $subCat->name_en }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">التصنيف الأب الرئيسي</label>
                                                    <select name="parent_id" class="form-select">
                                                        <option value="">-- تصنيف رئيسي مستقل --</option>
                                                        @foreach($allCategories as $catOption)
                                                            @if($catOption->id != $subCat->id)
                                                                <option value="{{ $catOption->id }}" {{ $subCat->parent_id == $catOption->id ? 'selected' : '' }}>
                                                                    {{ $catOption->name_ar }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">رمز الأيقونة (Bootstrap Icon)</label>
                                                    <input type="text" name="icon" class="form-control" value="{{ $subCat->icon }}" placeholder="bi-tag-fill">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">وصف التصنيف</label>
                                                    <textarea name="description_ar" class="form-control" rows="2">{{ $subCat->description_ar }}</textarea>
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
                            <div class="text-muted fs-8 text-center py-3 bg-light rounded-3 border border-dashed">
                                لا توجد تصنيفات فرعية مضافة تحت هذا القسم بعد.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <!-- Edit Main Category Modal -->
        <div class="modal fade" id="editCategoryModal{{ $mainCat->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow-lg">
                    <form action="{{ route('admin.categories.update', $mainCat->id) }}" method="POST">
                        @csrf
                        <div class="modal-header bg-navy text-white p-3" style="background-color: #0A1D37 !important;">
                            <h5 class="modal-title fw-bold text-white fs-6"><i class="bi bi-pencil-square me-2 text-warning"></i> تعديل تصنيف: {{ $mainCat->name_ar }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم التصنيف (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" value="{{ $mainCat->name_ar }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم التصنيف (English)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ $mainCat->name_en }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">التصنيف الأب الرئيسي</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">-- تصنيف رئيسي مستقل --</option>
                                    @foreach($allCategories as $catOption)
                                        @if($catOption->id != $mainCat->id)
                                            <option value="{{ $catOption->id }}" {{ $mainCat->parent_id == $catOption->id ? 'selected' : '' }}>
                                                {{ $catOption->name_ar }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">رمز الأيقونة (Bootstrap Icon)</label>
                                <input type="text" name="icon" class="form-control" value="{{ $mainCat->icon }}" placeholder="bi-tag-fill">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">وصف التصنيف</label>
                                <textarea name="description_ar" class="form-control" rows="2">{{ $mainCat->description_ar }}</textarea>
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
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center">
                <i class="bi bi-folder-x fs-1 text-muted mb-2"></i>
                <h5 class="fw-bold text-navy">لا توجد تصنيفات رئيسية حالياً</h5>
                <p class="text-muted fs-7">قم بإضافة تصنيف رئيسي أو تصنيف فرعي لبدء تنظيم الكتالوج.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-navy text-white p-3" style="background-color: #0A1D37 !important;">
                    <h5 class="modal-title fw-bold text-white fs-6"><i class="bi bi-folder-plus me-2 text-warning"></i> إضافة تصنيف جديد للكتالوج</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم التصنيف (عربي) <span class="text-danger">*</span></label>
                        <input type="text" name="name_ar" class="form-control" placeholder="مثال: معدات وأجهزة السلامة البحرية" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم التصنيف (English)</label>
                        <input type="text" name="name_en" class="form-control" placeholder="Marine Safety Equipment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">التصنيف الأب الرئيسي</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- خيار: إنشاء كتصنيف رئيسي مستقل --</option>
                            @foreach($allCategories as $catOption)
                                <option value="{{ $catOption->id }}">{{ $catOption->name_ar }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted fs-8">اختر تصنيفاً إذا كنت تريد جعل هذا التصنيف فرعياً تحته.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">رمز الأيقونة (Bootstrap Icon)</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi-shield-check">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">وصف التصنيف</label>
                        <textarea name="description_ar" class="form-control" rows="2" placeholder="وصف مقتضب للتصنيف..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4 fw-bold text-white border border-warning border-opacity-50">حفظ التصنيف</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
