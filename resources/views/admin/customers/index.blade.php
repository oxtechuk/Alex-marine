@extends('layouts.admin')

@section('title', 'إدارة سجلات العملاء — أليكس مارين')
@section('page_title', 'سجل العملاء وإدارة الحسابات')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-navy mb-1">دليل وقاعدة بيانات العملاء</h4>
        <small class="text-muted">جميع العملاء المسجلين والذين أجروا عمليات شراء أو عروض أسعار</small>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sales.create') }}" class="btn btn-success fw-bold rounded-pill px-3">
            <i class="bi bi-cart-plus me-1"></i> بيع جديد / POS
        </a>
        <button type="button" class="btn btn-primary fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-person-plus-fill me-1"></i> إضافة عميل جديد
        </button>
    </div>
</div>

<!-- Customers Directory Table -->
<div class="alex-card bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark" style="background-color: #0A1D37;">
                <tr>
                    <th>#</th>
                    <th>اسم العميل / الشركة</th>
                    <th>رقم الهاتف</th>
                    <th>البريد الإلكتروني</th>
                    <th class="text-center">عدد المبيعات</th>
                    <th class="text-center">طلبات الأسعار</th>
                    <th>إجمالي المشتريات</th>
                    <th>تاريخ التسجيل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $customer->id }}</td>
                        <td>
                            <div class="fw-bold text-navy fs-6">{{ $customer->name }}</div>
                            @if($customer->company_name)
                                <span class="badge bg-light text-dark border">{{ $customer->company_name }}</span>
                            @endif
                        </td>
                        <td>
                            @if($customer->phone)
                                <span dir="ltr" class="fw-semibold text-dark"><i class="bi bi-telephone text-success me-1"></i> {{ $customer->phone }}</span>
                            @else
                                <span class="text-muted fs-8">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            <span class="fs-7 text-muted">{{ $customer->email }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill px-3 py-2 fs-7">{{ $customer->orders_count ?? 0 }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info text-white rounded-pill px-3 py-2 fs-7">{{ $customer->quote_requests_count ?? 0 }}</span>
                        </td>
                        <td class="fw-extrabold text-success">
                            {{ number_format($customer->orders_sum_total_amount ?? 0, 2) }} ج.م
                        </td>
                        <td class="fs-8 text-muted">
                            {{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-2 text-secondary"></i>
                            لا يوجد عملاء مسجلين حالياً. قم بإضافة عميل جديد أو إنشاء أمر بيع مباشر.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $customers->links() }}
    </div>
</div>

<!-- Modal: Add New Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-navy text-white p-3" style="background-color: #0A1D37;">
                <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-plus-fill me-2 text-warning"></i>تسجيل عميل جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.customers.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-navy">اسم العميل الثلاثي / التجاري <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: شركة النيل للتوريدات أو أحمد علي" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control" placeholder="010XXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" placeholder="client@domain.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-navy">اسم الشركة / المؤسسة</label>
                        <input type="text" name="company_name" class="form-control" placeholder="اختياري">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-navy">العنوان التفصيلي</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="المدينة، الشارع، الميناء"></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark rounded-pill px-4" style="background-color: #D4A017; border: none;">حفظ العميل</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
