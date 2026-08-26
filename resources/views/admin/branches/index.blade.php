@extends('layouts.admin')

@section('title', 'إدارة فروع الشركة — أليكس مارين')
@section('page_title', 'إدارة الفروع والمواقع البحرية')

@section('content')

<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold text-navy mb-1">فروع الشركة والمستودعات المعتمدة</h5>
        <p class="text-muted fs-7 m-0">يمكن لكل فرع البيع والتوريد المباشر ومتابعة المخزون والطلبات الخاصة به عبر المنصة</p>
    </div>
    <button type="button" class="btn btn-warning rounded-pill px-4 fw-bold text-dark" style="background-color: #D4A017; border: none;" data-bs-toggle="modal" data-bs-target="#addBranchModal">
        <i class="bi bi-plus-circle me-1"></i> إضافة فرع جديد
    </button>
</div>

<!-- Branches Grid / Table -->
<div class="row g-4 mb-4">
    @foreach($branches as $b)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-top border-4 {{ $b->code == 'ALX-MAIN' ? 'border-primary' : 'border-success' }}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-navy text-white px-2 py-1 fs-8 rounded-pill mb-1" style="background-color: #0A1D37;">
                            كود الفرع: {{ $b->code }}
                        </span>
                        <h4 class="fw-extrabold text-navy m-0">{{ $b->name_ar }}</h4>
                        <small class="text-muted">{{ $b->name_en ?: $b->city }}</small>
                    </div>
                    <span class="badge {{ $b->is_active ? 'bg-success-subtle text-success border border-success' : 'bg-secondary text-white' }} px-3 py-2 rounded-pill fw-bold">
                        <i class="bi {{ $b->is_active ? 'bi-check-circle' : 'bi-dash-circle' }} me-1"></i> {{ $b->is_active ? 'نشط ويعمل' : 'غير نشط' }}
                    </span>
                </div>

                <div class="row g-3 py-3 border-top border-bottom my-2 bg-light rounded-3 px-1">
                    <div class="col-4 text-center border-end">
                        <div class="fs-8 text-muted fw-bold">المنتجات بالفرع</div>
                        <div class="h5 fw-bold text-navy m-0">{{ $b->products_count }}</div>
                    </div>
                    <div class="col-4 text-center border-end">
                        <div class="fs-8 text-muted fw-bold">طلبات الأسعار</div>
                        <div class="h5 fw-bold text-warning m-0">{{ $b->quote_requests_count }}</div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="fs-8 text-muted fw-bold">أوامر الشراء</div>
                        <div class="h5 fw-bold text-success m-0">{{ $b->orders_count }}</div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 text-muted fs-7 mb-3">
                    <div><i class="bi bi-person-badge text-primary me-2"></i><strong>المسؤول:</strong> {{ $b->manager_name ?: 'غير محدد' }}</div>
                    <div><i class="bi bi-telephone text-primary me-2"></i><strong>الهاتف:</strong> <span dir="ltr">{{ $b->phone ?: 'غير محدد' }}</span></div>
                    <div><i class="bi bi-geo-alt text-primary me-2"></i><strong>العنوان:</strong> {{ $b->address ?: 'غير محدد' }}</div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editBranchModal{{ $b->id }}">
                        <i class="bi bi-pencil me-1"></i> تعديل البيانات
                    </button>
                    <form action="{{ route('admin.branches.delete', $b->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من رغبتك في حذف فرع ({{ $b->name_ar }})؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-trash me-1"></i> حذف الفرع
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Branch Modal -->
        <div class="modal fade" id="editBranchModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0">
                    <form action="{{ route('admin.branches.update', $b->id) }}" method="POST">
                        @csrf
                        <div class="modal-header bg-navy text-white" style="background-color: #0A1D37 !important;">
                            <h5 class="modal-title fw-bold text-white"><i class="bi bi-pencil-square me-2 text-warning"></i> تعديل بيانات الفرع ({{ $b->code }})</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الفرع (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" value="{{ $b->name_ar }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الفرع (English)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ $b->name_en }}">
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">كود الفرع <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control" value="{{ $b->code }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">المدينة / النطاق <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" value="{{ $b->city }}" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">اسم المدير المسؤول</label>
                                    <input type="text" name="manager_name" class="form-control" value="{{ $b->manager_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">رقم الهاتف</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $b->phone }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني للفرع</label>
                                <input type="email" name="email" class="form-control" value="{{ $b->email }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">العنوان التفصيلي / الميناء</label>
                                <textarea name="address" class="form-control" rows="2">{{ $b->address }}</textarea>
                            </div>
                            <div class="form-check form-switch p-3 bg-light rounded-3">
                                <input class="form-check-input me-0 ms-2" type="checkbox" name="is_active" value="1" id="act{{ $b->id }}" {{ $b->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="act{{ $b->id }}">تفعيل الفرع للبيع والتوريد عبر المنصة</label>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark" style="background-color: #D4A017; border: none;">حفظ التعديلات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach
</div>

<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form action="{{ route('admin.branches.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-navy text-white" style="background-color: #0A1D37 !important;">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-building-add me-2 text-warning"></i> إضافة فرع جديد للنظام</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم الفرع (عربي) <span class="text-danger">*</span></label>
                        <input type="text" name="name_ar" class="form-control" placeholder="مثال: فرع ميناء بورسعيد والفرع الشمالي" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم الفرع (English)</label>
                        <input type="text" name="name_en" class="form-control" placeholder="Port Said Branch">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">كود الفرع <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" placeholder="PSD-03" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">المدينة / النطاق <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" placeholder="بورسعيد" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">اسم المدير المسؤول</label>
                            <input type="text" name="manager_name" class="form-control" placeholder="اسم مدير الفرع">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control" placeholder="+20 120 000 0000">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">البريد الإلكتروني للفرع</label>
                        <input type="email" name="email" class="form-control" placeholder="branch@alexmarine.eg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">العنوان التفصيلي / الميناء</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="العنوان ورقم الرصيف"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark" style="background-color: #D4A017; border: none;">حفظ وإضافة الفرع</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
