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
                                                     <label class="form-label fw-bold d-flex align-items-center justify-content-between">
                                                         <span>رمز الأيقونة (Icon)</span>
                                                         <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold rounded-pill px-2.5 py-0.5 fs-8 js-open-icon-picker" data-target-input="#subCatIconInput{{ $subCat->id }}" data-target-preview="#subCatIconPreview{{ $subCat->id }}">
                                                             <i class="bi bi-grid-3x3-gap-fill text-warning me-1"></i> تصفح مكتبة الأيقونات
                                                         </button>
                                                     </label>
                                                     <div class="input-group">
                                                         <span class="input-group-text bg-white" id="subCatIconPreview{{ $subCat->id }}" style="width: 46px; justify-content: center;">
                                                             <i class="bi {{ $subCat->icon ?: 'bi-folder-fill' }} fs-5 text-warning"></i>
                                                         </span>
                                                         <input type="text" name="icon" id="subCatIconInput{{ $subCat->id }}" class="form-control font-monospace js-icon-input" value="{{ $subCat->icon }}" placeholder="bi-tag-fill" data-preview="#subCatIconPreview{{ $subCat->id }}">
                                                         <button type="button" class="btn btn-navy text-white fw-bold px-3 js-open-icon-picker" data-target-input="#subCatIconInput{{ $subCat->id }}" data-target-preview="#subCatIconPreview{{ $subCat->id }}" style="background-color: #0A1D37;">
                                                             <i class="bi bi-palette2 me-1"></i> اختيار أيقونة
                                                         </button>
                                                     </div>
                                                     <div class="mt-2 d-flex align-items-center gap-1.5 flex-wrap">
                                                         <small class="text-muted fs-8 me-1">شائع:</small>
                                                         @foreach(['bi-anchor', 'bi-shield-check', 'bi-fire', 'bi-life-preserver', 'bi-box-seam', 'bi-tools', 'bi-truck', 'bi-tag-fill'] as $qIcon)
                                                             <button type="button" class="btn btn-light btn-xs border rounded-2 p-1 px-2 js-quick-icon-btn" data-icon="{{ $qIcon }}" data-target-input="#subCatIconInput{{ $subCat->id }}" data-target-preview="#subCatIconPreview{{ $subCat->id }}" title="{{ $qIcon }}">
                                                                 <i class="bi {{ $qIcon }} text-navy"></i>
                                                             </button>
                                                         @endforeach
                                                     </div>
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
                                <label class="form-label fw-bold d-flex align-items-center justify-content-between">
                                    <span>رمز الأيقونة (Icon)</span>
                                    <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold rounded-pill px-2.5 py-0.5 fs-8 js-open-icon-picker" data-target-input="#mainCatIconInput{{ $mainCat->id }}" data-target-preview="#mainCatIconPreview{{ $mainCat->id }}">
                                        <i class="bi bi-grid-3x3-gap-fill text-warning me-1"></i> تصفح مكتبة الأيقونات
                                    </button>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white" id="mainCatIconPreview{{ $mainCat->id }}" style="width: 46px; justify-content: center;">
                                        <i class="bi {{ $mainCat->icon ?: 'bi-folder-fill' }} fs-5 text-warning"></i>
                                    </span>
                                    <input type="text" name="icon" id="mainCatIconInput{{ $mainCat->id }}" class="form-control font-monospace js-icon-input" value="{{ $mainCat->icon }}" placeholder="bi-tag-fill" data-preview="#mainCatIconPreview{{ $mainCat->id }}">
                                    <button type="button" class="btn btn-navy text-white fw-bold px-3 js-open-icon-picker" data-target-input="#mainCatIconInput{{ $mainCat->id }}" data-target-preview="#mainCatIconPreview{{ $mainCat->id }}" style="background-color: #0A1D37;">
                                        <i class="bi bi-palette2 me-1"></i> اختيار أيقونة
                                    </button>
                                </div>
                                <div class="mt-2 d-flex align-items-center gap-1.5 flex-wrap">
                                    <small class="text-muted fs-8 me-1">شائع:</small>
                                    @foreach(['bi-anchor', 'bi-shield-check', 'bi-fire', 'bi-life-preserver', 'bi-box-seam', 'bi-tools', 'bi-truck', 'bi-tag-fill'] as $qIcon)
                                        <button type="button" class="btn btn-light btn-xs border rounded-2 p-1 px-2 js-quick-icon-btn" data-icon="{{ $qIcon }}" data-target-input="#mainCatIconInput{{ $mainCat->id }}" data-target-preview="#mainCatIconPreview{{ $mainCat->id }}" title="{{ $qIcon }}">
                                            <i class="bi {{ $qIcon }} text-navy"></i>
                                        </button>
                                    @endforeach
                                </div>
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
                        <label class="form-label fw-bold d-flex align-items-center justify-content-between">
                            <span>رمز الأيقونة (Icon)</span>
                            <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold rounded-pill px-2.5 py-0.5 fs-8 js-open-icon-picker" data-target-input="#addCategoryIconInput" data-target-preview="#addCategoryIconPreview">
                                <i class="bi bi-grid-3x3-gap-fill text-warning me-1"></i> تصفح مكتبة الأيقونات
                            </button>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white" id="addCategoryIconPreview" style="width: 46px; justify-content: center;">
                                <i class="bi bi-folder-fill fs-5 text-warning"></i>
                            </span>
                            <input type="text" name="icon" id="addCategoryIconInput" class="form-control font-monospace js-icon-input" placeholder="bi-shield-check" value="" data-preview="#addCategoryIconPreview">
                            <button type="button" class="btn btn-navy text-white fw-bold px-3 js-open-icon-picker" data-target-input="#addCategoryIconInput" data-target-preview="#addCategoryIconPreview" style="background-color: #0A1D37;">
                                <i class="bi bi-palette2 me-1"></i> اختيار أيقونة
                            </button>
                        </div>
                        <div class="mt-2 d-flex align-items-center gap-1.5 flex-wrap">
                            <small class="text-muted fs-8 me-1">شائع:</small>
                            @foreach(['bi-anchor', 'bi-shield-check', 'bi-fire', 'bi-life-preserver', 'bi-box-seam', 'bi-tools', 'bi-truck', 'bi-signpost-split'] as $qIcon)
                                <button type="button" class="btn btn-light btn-xs border rounded-2 p-1 px-2 js-quick-icon-btn" data-icon="{{ $qIcon }}" data-target-input="#addCategoryIconInput" data-target-preview="#addCategoryIconPreview" title="{{ $qIcon }}">
                                    <i class="bi {{ $qIcon }} text-navy"></i>
                                </button>
                            @endforeach
                        </div>
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

{{-- ══════════════════════════════════════════════════════════
     ICON PICKER MODAL (مكتبة أيقونات متكاملة ومصنفة)
══════════════════════════════════════════════════════════ --}}
@php
$iconLibrary = [
    // 1. Marine & Navigation (بحرية وملاحة)
    ['icon' => 'bi-anchor', 'name' => 'anchor', 'ar' => 'مرساة بحرية', 'cat' => 'marine', 'tags' => 'مرساة سفينة يخت بحر ملاحة موانئ'],
    ['icon' => 'bi-compass', 'name' => 'compass', 'ar' => 'بوصلة بحرية', 'cat' => 'marine', 'tags' => 'بوصلة اتجاه ملاحة توجيه'],
    ['icon' => 'bi-life-preserver', 'name' => 'life-preserver', 'ar' => 'طوق نجاة', 'cat' => 'marine', 'tags' => 'طوق نجاة إنقاذ بحري سلامة غرق'],
    ['icon' => 'bi-water', 'name' => 'water', 'ar' => 'مياه وبحار', 'cat' => 'marine', 'tags' => 'مياه بحر أمواج سواحل'],
    ['icon' => 'bi-tsunami', 'name' => 'tsunami', 'ar' => 'أمواج وعواصف', 'cat' => 'marine', 'tags' => 'أمواج عاصفة بحرية طقس'],
    ['icon' => 'bi-wind', 'name' => 'wind', 'ar' => 'رياح وأرصاد', 'cat' => 'marine', 'tags' => 'رياح طقس أرصاد هواء'],
    ['icon' => 'bi-signpost-split', 'name' => 'signpost', 'ar' => 'علامات إرشادية', 'cat' => 'marine', 'tags' => 'علامات لافتات ملاحية توجيه'],
    ['icon' => 'bi-signpost-2', 'name' => 'signpost-2', 'ar' => 'إرشادات موانئ', 'cat' => 'marine', 'tags' => 'إرشادات ممر بحري رصيف'],
    ['icon' => 'bi-geo-alt-fill', 'name' => 'geo-alt', 'ar' => 'موقع وميناء', 'cat' => 'marine', 'tags' => 'ميناء موقع إحداثيات رصيف'],
    ['icon' => 'bi-pin-map-fill', 'name' => 'pin-map', 'ar' => 'خريطة أرصفة', 'cat' => 'marine', 'tags' => 'خريطة مارينا رصيف بحري'],
    ['icon' => 'bi-broadcast', 'name' => 'broadcast', 'ar' => 'رادار واستغاثة', 'cat' => 'marine', 'tags' => 'رادار إشارة لاسلكي نداء استغاثة'],
    ['icon' => 'bi-moisture', 'name' => 'moisture', 'ar' => 'رطوبة وغمر', 'cat' => 'marine', 'tags' => 'رطوبة مياه غطس بدلة غمر'],
    ['icon' => 'bi-binoculars-fill', 'name' => 'binoculars', 'ar' => 'مراقبة واستطلاع', 'cat' => 'marine', 'tags' => 'منظار دربيل برج مراقبة أفق'],
    ['icon' => 'bi-sunset-fill', 'name' => 'sunset', 'ar' => 'خط الأفق', 'cat' => 'marine', 'tags' => 'بحر شمس أفق ملاحة'],

    // 2. Safety & Protection (أمن وسلامة)
    ['icon' => 'bi-shield-check', 'name' => 'shield-check', 'ar' => 'سلامة معتمدة', 'cat' => 'safety', 'tags' => 'سلامة درع أمان فحص معتمد SOLAS'],
    ['icon' => 'bi-shield-fill', 'name' => 'shield', 'ar' => 'درع وقاية', 'cat' => 'safety', 'tags' => 'درع وقاية حماية أمن صناعي'],
    ['icon' => 'bi-shield-shaded', 'name' => 'shield-shaded', 'ar' => 'أمن صناعي', 'cat' => 'safety', 'tags' => 'أمن صناعي سلامة مهنية وقاية'],
    ['icon' => 'bi-shield-lock-fill', 'name' => 'shield-lock', 'ar' => 'حماية وتأمين', 'cat' => 'safety', 'tags' => 'قفل تأمين حماية سلامة غلق'],
    ['icon' => 'bi-shield-exclamation', 'name' => 'shield-alert', 'ar' => 'تنبيه أمني', 'cat' => 'safety', 'tags' => 'تنبيه إنذار أمان خطر تحذير'],
    ['icon' => 'bi-cone-striped', 'name' => 'cone', 'ar' => 'حواجز ومرور', 'cat' => 'safety', 'tags' => 'قمع حاجز موقع عمل أمان'],
    ['icon' => 'bi-exclamation-triangle-fill', 'name' => 'warning', 'ar' => 'تحذير وخطر', 'cat' => 'safety', 'tags' => 'خطر تحذير تنبيه إشارة'],
    ['icon' => 'bi-exclamation-octagon-fill', 'name' => 'stop', 'ar' => 'إيقاف طوارئ', 'cat' => 'safety', 'tags' => 'توقف قف طوارئ زر أمان'],
    ['icon' => 'bi-eye-fill', 'name' => 'eye', 'ar' => 'وقاية العين', 'cat' => 'safety', 'tags' => 'نظارات حماية بصر فحص وقاية'],
    ['icon' => 'bi-heart-pulse-fill', 'name' => 'heart-pulse', 'ar' => 'إسعافات ورعاية', 'cat' => 'safety', 'tags' => 'قلب صحة إسعاف نبض طبي'],
    ['icon' => 'bi-patch-check-fill', 'name' => 'certified', 'ar' => 'اعتماد وجودة', 'cat' => 'safety', 'tags' => 'شهادة أيزو جودة اعتماد رسمي'],
    ['icon' => 'bi-incognito', 'name' => 'mask', 'ar' => 'حماية تنفس', 'cat' => 'safety', 'tags' => 'قناع كمامة تنفس هروب SCBA'],
    ['icon' => 'bi-radioactive', 'name' => 'radioactive', 'ar' => 'مواد خطرة', 'cat' => 'safety', 'tags' => 'مواد خطرة إشعاع كيميائي'],
    ['icon' => 'bi-bandaid-fill', 'name' => 'first-aid', 'ar' => 'إسعاف أولي', 'cat' => 'safety', 'tags' => 'ضماد صيدلية طوارئ إسعاف'],
    ['icon' => 'bi-person-check-fill', 'name' => 'person-safe', 'ar' => 'سلامة الأفراد', 'cat' => 'safety', 'tags' => 'فرد عامل مهندس وقاية'],

    // 3. Fire & Rescue (إطفاء وإنقاذ)
    ['icon' => 'bi-fire', 'name' => 'fire', 'ar' => 'مكافحة حرائق', 'cat' => 'fire', 'tags' => 'نار حريق طفاية إطفاء بودرة فوم'],
    ['icon' => 'bi-lightning-charge-fill', 'name' => 'lightning', 'ar' => 'طاقة وطوارئ', 'cat' => 'fire', 'tags' => 'كهرباء شحن تيار صدمة طاقة'],
    ['icon' => 'bi-bell-fill', 'name' => 'alarm-bell', 'ar' => 'إنذار حريق', 'cat' => 'fire', 'tags' => 'جرس إنذار حريق تنبيه طوارئ'],
    ['icon' => 'bi-megaphone-fill', 'name' => 'megaphone', 'ar' => 'إذاعة وإخلاء', 'cat' => 'fire', 'tags' => 'مكبر صوت إخلاء نداء طوارئ'],
    ['icon' => 'bi-hospital-fill', 'name' => 'hospital', 'ar' => 'محطة إسعاف', 'cat' => 'fire', 'tags' => 'إسعاف مستشفى طبي إنقاذ'],
    ['icon' => 'bi-thermometer-half', 'name' => 'temp', 'ar' => 'مستشعر حرارة', 'cat' => 'fire', 'tags' => 'حرارة حساس قياس مؤشر'],
    ['icon' => 'bi-capsule', 'name' => 'medical', 'ar' => 'مستلزمات طبية', 'cat' => 'fire', 'tags' => 'دواء طب كبسولة علاج'],
    ['icon' => 'bi-person-walking', 'name' => 'exit', 'ar' => 'مخارج طوارئ', 'cat' => 'fire', 'tags' => 'مخرج طوارئ مسار هروب خروج'],

    // 4. Tools & Maintenance (معدات وصيانة)
    ['icon' => 'bi-tools', 'name' => 'tools', 'ar' => 'حقيبة صيانة', 'cat' => 'tools', 'tags' => 'عدة صيانة أدوات تصليح ورشة'],
    ['icon' => 'bi-wrench-adjustable', 'name' => 'wrench-adj', 'ar' => 'مفتاح ميكانيكا', 'cat' => 'tools', 'tags' => 'مفتاح ربط إنجليزي ميكانيكا'],
    ['icon' => 'bi-wrench', 'name' => 'wrench', 'ar' => 'مفتاح ربط', 'cat' => 'tools', 'tags' => 'مفك عدة صيانة تصليح'],
    ['icon' => 'bi-hammer', 'name' => 'hammer', 'ar' => 'مطرقة وتصنيع', 'cat' => 'tools', 'tags' => 'شاكوش مطرقة تشكيل حدادة صلب'],
    ['icon' => 'bi-gear-fill', 'name' => 'gear', 'ar' => 'تروس ومحركات', 'cat' => 'tools', 'tags' => 'محرك موتور ترس ميكانيكا قطع غيار'],
    ['icon' => 'bi-gear-wide-connected', 'name' => 'gears', 'ar' => 'أنظمة تروس', 'cat' => 'tools', 'tags' => 'نظام تروس ميكانيكا تدوير حركة'],
    ['icon' => 'bi-sliders', 'name' => 'controls', 'ar' => 'لوحات تحكم', 'cat' => 'tools', 'tags' => 'تحكم معايرة ضبط مؤشرات'],
    ['icon' => 'bi-cpu-fill', 'name' => 'cpu', 'ar' => 'متحكمات ومعالجة', 'cat' => 'tools', 'tags' => 'إلكترونيات معالج شريحة كمبيوتر'],
    ['icon' => 'bi-plug-fill', 'name' => 'plug', 'ar' => 'توصيلات وكابلات', 'cat' => 'tools', 'tags' => 'كابل سلك فيشة كهرباء'],
    ['icon' => 'bi-battery-charging', 'name' => 'battery', 'ar' => 'بطاريات ومولدات', 'cat' => 'tools', 'tags' => 'بطارية شحن طاقة مولد ديزل'],
    ['icon' => 'bi-fuel-pump-fill', 'name' => 'fuel', 'ar' => 'وقود وتموين', 'cat' => 'tools', 'tags' => 'وقود ديزل بنزين تموين سفن'],
    ['icon' => 'bi-speedometer', 'name' => 'gauge', 'ar' => 'عدادات وقياس', 'cat' => 'tools', 'tags' => 'عداد ضغط بار سرعة مقياس'],
    ['icon' => 'bi-rulers', 'name' => 'rulers', 'ar' => 'أدوات قياس', 'cat' => 'tools', 'tags' => 'مسطرة أبعاد قياس متري'],
    ['icon' => 'bi-nut-fill', 'name' => 'hardware', 'ar' => 'مسامير وروافع', 'cat' => 'tools', 'tags' => 'صامولة مسمار تثبيت صلب روافع'],
    ['icon' => 'bi-screwdriver', 'name' => 'screwdriver', 'ar' => 'مفكات وورش', 'cat' => 'tools', 'tags' => 'مفك عدة يدوي إحكام'],

    // 5. Cargo & Logistics (شحن وتوريدات)
    ['icon' => 'bi-box-seam', 'name' => 'box-seam', 'ar' => 'طرد وبضائع', 'cat' => 'cargo', 'tags' => 'كرتونة شحن بضائع طرد توريد'],
    ['icon' => 'bi-box-seam-fill', 'name' => 'package', 'ar' => 'كرتونة توريد', 'cat' => 'cargo', 'tags' => 'صندوق تغليف بضاعة تسليم'],
    ['icon' => 'bi-boxes', 'name' => 'boxes', 'ar' => 'مستودعات وكراتين', 'cat' => 'cargo', 'tags' => 'مخزن بضائع حاويات طرود كراتين'],
    ['icon' => 'bi-truck', 'name' => 'truck', 'ar' => 'شحن ونقل', 'cat' => 'cargo', 'tags' => 'شاحنة نقل توصيل ميناء لوجستيات'],
    ['icon' => 'bi-cart-check-fill', 'name' => 'cart-check', 'ar' => 'أوامر توريد', 'cat' => 'cargo', 'tags' => 'شراء طلبيات عربة سلة توريدات'],
    ['icon' => 'bi-basket2-fill', 'name' => 'basket', 'ar' => 'سلة مهمات', 'cat' => 'cargo', 'tags' => 'سلة تجهيزات مهمات مستلزمات'],
    ['icon' => 'bi-bag-check-fill', 'name' => 'bag-check', 'ar' => 'حقائب معدات', 'cat' => 'cargo', 'tags' => 'شنطة طقم استلام أكياس'],
    ['icon' => 'bi-archive-fill', 'name' => 'archive', 'ar' => 'أرشيف ومخزون', 'cat' => 'cargo', 'tags' => 'مخزون جرد أرشيف أدراج مستودع'],
    ['icon' => 'bi-upc-scan', 'name' => 'barcode', 'ar' => 'باركود وتتبع', 'cat' => 'cargo', 'tags' => 'باركود سكانر تتبع شحنة بضاعة'],
    ['icon' => 'bi-tag-fill', 'name' => 'tag', 'ar' => 'وسم وتصنيف', 'cat' => 'cargo', 'tags' => 'سعر كود وسم بطاقة صنف'],
    ['icon' => 'bi-tags-fill', 'name' => 'tags', 'ar' => 'تصنيفات متعددة', 'cat' => 'cargo', 'tags' => 'علامات بطاقات أسعار تصنيف'],
    ['icon' => 'bi-layers-fill', 'name' => 'layers', 'ar' => 'طبقات وحزم', 'cat' => 'cargo', 'tags' => 'رزم باليتات شحن طبقات طرود'],
    ['icon' => 'bi-box-arrow-in-down', 'name' => 'import', 'ar' => 'استلام وتفريغ', 'cat' => 'cargo', 'tags' => 'وارد استيراد تفريغ شحنة ميناء'],
    ['icon' => 'bi-box-arrow-up', 'name' => 'export', 'ar' => 'شحن وتصدير', 'cat' => 'cargo', 'tags' => 'صادر تصدير شحن تحميل سفينة'],

    // 6. Ports & Facilities (موانئ ومنشآت)
    ['icon' => 'bi-building', 'name' => 'building', 'ar' => 'مباني ومقرات', 'cat' => 'facilities', 'tags' => 'مبنى شركة إدارة مقر توكيل'],
    ['icon' => 'bi-buildings-fill', 'name' => 'complex', 'ar' => 'منشآت ومصانع', 'cat' => 'facilities', 'tags' => 'مصنع منشأة ورش ميناء صناعي'],
    ['icon' => 'bi-door-open-fill', 'name' => 'warehouse', 'ar' => 'مخازن وعنابر', 'cat' => 'facilities', 'tags' => 'عنبر هنجر باب بوابة مخزن'],
    ['icon' => 'bi-shop', 'name' => 'store', 'ar' => 'منافذ ومعارض', 'cat' => 'facilities', 'tags' => 'محل منفذ بيع معرض متجر'],
    ['icon' => 'bi-houses-fill', 'name' => 'workshops', 'ar' => 'ورش ومجمعات', 'cat' => 'facilities', 'tags' => 'ورش مجمع صناعي ساحة'],
    ['icon' => 'bi-bank', 'name' => 'customs', 'ar' => 'جمارك ومؤسسات', 'cat' => 'facilities', 'tags' => 'جمارك هيئة ميناء رسمي حكومي'],

    // 7. General & Other (عام ومتنوع)
    ['icon' => 'bi-folder-fill', 'name' => 'folder', 'ar' => 'قسم رئيسي', 'cat' => 'general', 'tags' => 'مجلد ملف قسم تصنيف عام'],
    ['icon' => 'bi-grid-fill', 'name' => 'grid', 'ar' => 'كتالوج شبكي', 'cat' => 'general', 'tags' => 'شبكة كتالوج قائمة دليل'],
    ['icon' => 'bi-grid-3x3-gap-fill', 'name' => 'departments', 'ar' => 'أقسام وتصنيفات', 'cat' => 'general', 'tags' => 'أقسام تصنيفات أسطول دليل'],
    ['icon' => 'bi-star-fill', 'name' => 'featured', 'ar' => 'منتج مميز', 'cat' => 'general', 'tags' => 'نجمة مميز مفضل مهم جودة'],
    ['icon' => 'bi-award-fill', 'name' => 'award', 'ar' => 'شهادات وجوائز', 'cat' => 'general', 'tags' => 'وسام جائزة تكريم شهادة اعتماد'],
    ['icon' => 'bi-trophy-fill', 'name' => 'trophy', 'ar' => 'اعتمادات رسمية', 'cat' => 'general', 'tags' => 'كأس ريادة تميز تفوق بطولة'],
    ['icon' => 'bi-check-circle-fill', 'name' => 'check-circle', 'ar' => 'معتمد وجاهز', 'cat' => 'general', 'tags' => 'صح مؤكد متوفر تمام معتمد'],
    ['icon' => 'bi-bookmark-star-fill', 'name' => 'bookmark', 'ar' => 'قسم هام', 'cat' => 'general', 'tags' => 'حفظ إشارة مفضلة قسم رئيسي'],
    ['icon' => 'bi-card-checklist', 'name' => 'checklist', 'ar' => 'فحص ومواصفات', 'cat' => 'general', 'tags' => 'قائمة فحص تدقيق تقرير مواصفة'],
    ['icon' => 'bi-receipt', 'name' => 'receipt', 'ar' => 'عروض أسعار', 'cat' => 'general', 'tags' => 'فاتورة تسعير أمر شراء عرض سعر'],
    ['icon' => 'bi-lightbulb-fill', 'name' => 'lighting', 'ar' => 'كشافات وإضاءة', 'cat' => 'general', 'tags' => 'لمبة نور كشاف فكرة إضاءة طوارئ'],
    ['icon' => 'bi-telephone-fill', 'name' => 'phone', 'ar' => 'اتصال وتواصل', 'cat' => 'general', 'tags' => 'هاتف تلفون اتصال خدمة عملاء'],
    ['icon' => 'bi-headset', 'name' => 'support', 'ar' => 'دعم فني وتوريد', 'cat' => 'general', 'tags' => 'سماعة دعم فني استفسار توريدات'],
];
@endphp

<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="modal-header bg-navy text-white p-3.5 border-0" style="background-color: #0A1D37 !important;">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="bg-white bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-2 border border-warning border-opacity-25" style="width: 38px; height: 38px;">
                        <i class="bi bi-collection-fill fs-5 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white fs-6 m-0">مكتبة أيقونات التصنيفات — أليكس مارين</h5>
                        <p class="text-white-50 fs-8 m-0 mt-0.5">اختر أيقونة معبرة لقسمك من بين أكثر من 100 أيقونة بحرية وصناعية معتمدة</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Search & Filter Tabs -->
            <div class="p-3 bg-light border-bottom">
                <!-- Search Input -->
                <div class="position-relative mb-2.5">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="iconPickerSearch" class="form-control rounded-pill ps-5 bg-white border-1" placeholder="ابحث باسم الأيقونة عربي أو إنجليزي (مثل: anchor, shield, fire, box, tool, sea, water)...">
                </div>

                <!-- Category Filter Tabs -->
                <div class="d-flex align-items-center gap-1.5 flex-wrap" id="iconFilterTabs">
                    <button type="button" class="btn btn-sm btn-navy rounded-pill px-3 py-1 fs-8 fw-bold js-icon-tab active" data-filter="all">
                        الكل ({{ count($iconLibrary) }})
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="marine">
                        ⚓ بحرية وملاحة
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="safety">
                        🛡️ أمن وسلامة
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="fire">
                        🧯 إطفاء وإنقاذ
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="tools">
                        🔧 معدات وصيانة
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="cargo">
                        📦 شحن وتوريدات
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="facilities">
                        🏢 موانئ ومنشآت
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-8 js-icon-tab" data-filter="general">
                        🏷️ عام
                    </button>
                </div>
            </div>

            <!-- Modal Body: Icon Grid -->
            <div class="modal-body p-3.5" style="min-height: 380px; max-height: 480px;">
                <div class="row g-2.5 row-cols-3 row-cols-sm-4 row-cols-md-6" id="iconLibraryGrid">
                    @foreach($iconLibrary as $item)
                        <div class="col icon-picker-col" data-icon="{{ $item['icon'] }}" data-category="{{ $item['cat'] }}" data-search="{{ strtolower($item['name'] . ' ' . $item['ar'] . ' ' . $item['tags'] . ' ' . $item['icon']) }}">
                            <div class="card h-100 border text-center p-2.5 rounded-3 icon-picker-card js-select-icon-card cursor-pointer" role="button" data-icon="{{ $item['icon'] }}" title="{{ $item['ar'] }} ({{ $item['icon'] }})">
                                <div class="icon-glyph-wrapper mb-1">
                                    <i class="bi {{ $item['icon'] }} fs-3 text-navy"></i>
                                </div>
                                <span class="fs-8 fw-bold text-dark text-truncate d-block">{{ $item['name'] }}</span>
                                <small class="text-muted d-block text-truncate" style="font-size: 0.68rem;">{{ $item['ar'] }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- No Results State -->
                <div id="noIconsFound" class="text-center py-5 d-none">
                    <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                    <h6 class="fw-bold text-navy">لم يتم العثور على أيقونة مطابقة</h6>
                    <p class="text-muted fs-8 mb-0">جرب البحث بكلمة أخرى مثل: sea, safe, box, tool...</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light p-3 d-flex align-items-center justify-content-between">
                <span class="fs-8 text-muted" id="iconSelectionHint">
                    <i class="bi bi-info-circle me-1"></i> انقر على أي أيقونة لاعتمادها فوراً وإغلاق المكتبة
                </span>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<style>
.icon-picker-card {
    background-color: #ffffff;
    transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.icon-picker-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(10, 29, 55, 0.12) !important;
    border-color: #E5A919 !important;
}
.icon-picker-card:hover i {
    color: #E5A919 !important;
    transform: scale(1.1);
}
.icon-glyph-wrapper i {
    transition: transform 0.2s ease, color 0.2s ease;
}
.icon-picker-card:active {
    transform: scale(0.96);
}
#iconPickerModal {
    z-index: 1070 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1065 !important;
}
.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let activeTargetInput = null;
    let activeTargetPreview = null;
    let iconModalInstance = null;

    const iconModalEl = document.getElementById('iconPickerModal');
    if (iconModalEl) {
        iconModalInstance = new bootstrap.Modal(iconModalEl, {
            backdrop: true,
            keyboard: true
        });
    }

    // Open Icon Picker Modal
    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('.js-open-icon-picker');
        if (!trigger) return;

        e.preventDefault();
        const inputSelector = trigger.getAttribute('data-target-input');
        const previewSelector = trigger.getAttribute('data-target-preview');

        activeTargetInput = document.querySelector(inputSelector);
        activeTargetPreview = document.querySelector(previewSelector);

        if (iconModalInstance) {
            // Reset search & filter
            const searchInput = document.getElementById('iconPickerSearch');
            if (searchInput) searchInput.value = '';
            filterIcons('', 'all');

            // Reset tabs
            document.querySelectorAll('.js-icon-tab').forEach(tab => {
                if (tab.getAttribute('data-filter') === 'all') {
                    tab.classList.add('btn-navy', 'active');
                    tab.classList.remove('btn-outline-secondary');
                } else {
                    tab.classList.remove('btn-navy', 'active');
                    tab.classList.add('btn-outline-secondary');
                }
            });

            iconModalInstance.show();
        }
    });

    // Quick Icon Buttons
    document.addEventListener('click', function(e) {
        const quickBtn = e.target.closest('.js-quick-icon-btn');
        if (!quickBtn) return;

        e.preventDefault();
        const icon = quickBtn.getAttribute('data-icon');
        const targetInput = document.querySelector(quickBtn.getAttribute('data-target-input'));
        const targetPreview = document.querySelector(quickBtn.getAttribute('data-target-preview'));

        if (targetInput) {
            targetInput.value = icon;
            targetInput.dispatchEvent(new Event('input'));
        }
        if (targetPreview) {
            targetPreview.innerHTML = `<i class="bi ${icon} fs-5 text-warning"></i>`;
        }
    });

    // Select Icon from Modal Grid
    document.addEventListener('click', function(e) {
        const card = e.target.closest('.js-select-icon-card');
        if (!card) return;

        e.preventDefault();
        const icon = card.getAttribute('data-icon');

        if (activeTargetInput) {
            activeTargetInput.value = icon;
            activeTargetInput.dispatchEvent(new Event('input'));
        }
        if (activeTargetPreview) {
            activeTargetPreview.innerHTML = `<i class="bi ${icon} fs-5 text-warning"></i>`;
        }

        if (iconModalInstance) {
            iconModalInstance.hide();
        }
    });

    // Real-time Preview when typing directly in input
    document.addEventListener('input', function(e) {
        if (e.target && e.target.classList.contains('js-icon-input')) {
            const previewSelector = e.target.getAttribute('data-preview');
            const previewEl = document.querySelector(previewSelector);
            if (previewEl) {
                const val = e.target.value.trim();
                const iconClass = val ? val : 'bi-folder-fill';
                previewEl.innerHTML = `<i class="bi ${iconClass} fs-5 text-warning"></i>`;
            }
        }
    });

    // Search & Filter Logic in Icon Library
    const searchInput = document.getElementById('iconPickerSearch');
    const tabs = document.querySelectorAll('.js-icon-tab');

    let currentSearchTerm = '';
    let currentCategoryFilter = 'all';

    function filterIcons(term, cat) {
        const items = document.querySelectorAll('#iconLibraryGrid .icon-picker-col');
        let visibleCount = 0;

        items.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            const itemSearch = item.getAttribute('data-search') || '';

            const matchesCat = (cat === 'all' || itemCat === cat);
            const matchesSearch = (!term || itemSearch.includes(term.toLowerCase()));

            if (matchesCat && matchesSearch) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        const noResults = document.getElementById('noIconsFound');
        if (noResults) {
            noResults.classList.toggle('d-none', visibleCount > 0);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearchTerm = this.value.trim();
            filterIcons(currentSearchTerm, currentCategoryFilter);
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => {
                t.classList.remove('btn-navy', 'active');
                t.classList.add('btn-outline-secondary');
            });
            this.classList.add('btn-navy', 'active');
            this.classList.remove('btn-outline-secondary');

            currentCategoryFilter = this.getAttribute('data-filter') || 'all';
            filterIcons(currentSearchTerm, currentCategoryFilter);
        });
    });
});
</script>

@endsection
