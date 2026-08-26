@extends('layouts.admin')

@section('title', 'أوامر الشراء — لوحة الإدارة')
@section('page_title', 'إدارة أوامر الشراء (Orders)')

@section('content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle m-0">
                <thead class="table-light">
                    <tr>
                        <th>رقم الأمر</th>
                        <th>اسم الشركة</th>
                        <th>اسم المسئول</th>
                        <th>التاريخ</th>
                        <th>حالة التجهيز</th>
                        <th>إجمالي المبلغ</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                        <tr>
                            <td class="fw-bold text-success">{{ $o->order_number }}</td>
                            <td><strong>{{ $o->company_name }}</strong></td>
                            <td>{{ $o->customer_name }}</td>
                            <td class="small text-muted">{{ $o->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-success">{{ $o->status }}</span>
                            </td>
                            <td class="fw-bold text-dark">{{ number_format($o->total_amount, 2) }} ج.م</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> التفاصيل
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">لا توجد أوامر شراء حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
