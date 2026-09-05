@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', ($isEn ? 'Customer Portal' : 'بوابة العميل') . ' — ' . ($isEn ? 'ALEX MARINE' : 'أليكس مارين'))

@section('content')
<section class="py-4 bg-white border-bottom">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="fw-bold text-dark fs-2 mb-1">{{ $isEn ? 'Welcome back, ' : 'مرحباً، ' }}{{ $user->name }}</h1>
            <p class="text-muted m-0">{{ $user->company_name }} | {{ $user->email }}</p>
        </div>
        <a href="{{ route('quote.index') }}" class="btn btn-alex-gold">
            <i class="bi bi-plus-lg me-1"></i> {{ $isEn ? 'New RFQ Quotation Request' : 'طلب عرض سعر جديد' }}
        </a>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="alex-card p-4">
            <h3 class="fw-bold text-dark fs-4 mb-4"><i class="bi bi-clock-history text-primary me-2"></i> {{ $isEn ? 'Quotation Requests History' : 'سجل طلبات عروض الأسعار' }}</h3>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ $isEn ? 'RFQ Number' : 'رقم الطلب (RFQ)' }}</th>
                            <th>{{ $isEn ? 'Date' : 'التاريخ' }}</th>
                            <th>{{ $isEn ? 'Status' : 'حالة الطلب' }}</th>
                            <th>{{ $isEn ? 'Total Estimate' : 'إجمالي التقدير' }}</th>
                            <th>{{ $isEn ? 'Notes' : 'ملاحظات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $q)
                            <tr>
                                <td class="fw-bold text-primary">{{ $q->quote_number }}</td>
                                <td class="text-muted small">{{ $q->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($q->status == 'جديد')
                                        <span class="badge bg-warning text-dark">{{ $isEn ? 'Under Technical Review' : 'قيد المراجعة الفنية' }}</span>
                                    @elseif($q->status == 'تم التسعير' || $q->status == 'مقبول')
                                        <span class="badge bg-success">{{ $isEn ? 'Quoted & Approved' : 'تم التسعير والمعاينة' }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $q->status }}</span>
                                    @endif
                                </td>
                                <td class="fw-bold">
                                    {{ $q->total_estimated ? number_format($q->total_estimated, 2) . ' ' . ($isEn ? 'EGP' : 'ج.م') : ($isEn ? 'Pending Calculation' : 'قيد المحاسبة') }}
                                </td>
                                <td class="text-muted small">{{ $q->notes ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">{{ $isEn ? 'You have not submitted any RFQ quotation requests yet.' : 'لم تقم بإرسال طلبات عروض أسعار سابقة بعد.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
