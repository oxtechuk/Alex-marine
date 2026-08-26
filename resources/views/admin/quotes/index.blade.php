@extends('layouts.admin')

@section('title', 'طلبات عروض الأسعار — لوحة الإدارة')
@section('page_title', 'إدارة طلبات عروض الأسعار (RFQ)')

@section('content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle m-0">
                <thead class="table-light">
                    <tr>
                        <th>رقم الطلب (RFQ)</th>
                        <th>اسم الشركة</th>
                        <th>اسم المسئول</th>
                        <th>الهاتف</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>الإجمالي التقديري</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $q)
                        <tr>
                            <td class="fw-bold text-primary">{{ $q->quote_number }}</td>
                            <td><strong>{{ $q->company_name }}</strong></td>
                            <td>{{ $q->customer_name }}</td>
                            <td dir="ltr">{{ $q->phone }}</td>
                            <td class="small text-muted">{{ $q->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge {{ $q->status == 'جديد' ? 'bg-warning text-dark' : ($q->status == 'مقبول' ? 'bg-success' : 'bg-info') }}">
                                    {{ $q->status }}
                                </span>
                            </td>
                            <td class="fw-bold">
                                {{ $q->total_estimated ? number_format($q->total_estimated, 2) . ' ج.م' : '—' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.quotes.show', $q->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i> التفاصيل والتسعير
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">لا توجد طلبات عروض أسعار مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $quotes->links() }}
        </div>
    </div>
</div>
@endsection
