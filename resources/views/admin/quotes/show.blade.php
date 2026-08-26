@extends('layouts.admin')

@section('title', 'تفاصيل RFQ ' . $quote->quote_number . ' — أليكس مارين')
@section('page_title', 'معالجة وتسعير طلب عرض السعر: ' . $quote->quote_number)

@section('content')

<div class="row g-4 mb-4">
    <!-- Customer Info Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">بيانات الشركة العارضة</h5>
            <div class="d-flex flex-column gap-2 text-secondary mb-4">
                <div><strong>اسم الشركة:</strong> {{ $quote->company_name }}</div>
                <div><strong>اسم المسئول:</strong> {{ $quote->customer_name }}</div>
                <div><strong>البريد الإلكتروني:</strong> {{ $quote->email }}</div>
                <div><strong>رقم الهاتف:</strong> <span dir="ltr">{{ $quote->phone }}</span></div>
                <div><strong>تاريخ الطلب:</strong> {{ $quote->created_at->format('Y-m-d H:i') }}</div>
                <div><strong>الحالة الحالية:</strong> <span class="badge bg-primary fs-7">{{ $quote->status }}</span></div>
            </div>

            <div class="pt-3 border-top d-flex flex-column gap-2">
                <a href="{{ route('admin.quotes.print', $quote->id) }}" target="_blank" class="btn btn-outline-dark">
                    <i class="bi bi-printer me-1"></i> طباعة / تصدير عرض السعر PDF
                </a>

                @if(!$quote->order)
                    <form action="{{ route('admin.quotes.convert', $quote->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من تحويل هذا الطلب إلى أمر شراء رسمياً؟');">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-cart-check me-1"></i> تحويل إلى أمر شراء (Convert to Order)
                        </button>
                    </form>
                @else
                    <a href="{{ route('admin.orders.show', $quote->order->id) }}" class="btn btn-info text-white">
                        <i class="bi bi-check-circle me-1"></i> تم تحويله إلى أمر شراء (ORD-{{ $quote->order->order_number }})
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Items Pricing Form -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">تسعير الأصناف والملاحظات الفنية</h5>

            <form action="{{ route('admin.quotes.update', $quote->id) }}" method="POST">
                @csrf
                <div class="table-responsive mb-4">
                    <table class="table align-middle table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>اسم المنتج</th>
                                <th>كود SKU</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة (ج.م)</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $calcTotal = 0; @endphp
                            @foreach($quote->items as $item)
                                @php
                                    $itemPrice = $item->unit_price ?? 0;
                                    $itemSubtotal = $itemPrice * $item->quantity;
                                    $calcTotal += $itemSubtotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $item->product_name }}</div>
                                        @if($item->notes)<small class="text-muted">{{ $item->notes }}</small>@endif
                                    </td>
                                    <td><code>{{ $item->sku ?: 'N/A' }}</code></td>
                                    <td><span class="badge bg-secondary">{{ $item->quantity }}</span></td>
                                    <td style="width: 140px;">
                                        <input type="number" step="0.01" name="items[{{ $item->id }}][price]" class="form-control form-control-sm text-center" value="{{ $item->unit_price }}" placeholder="0.00">
                                    </td>
                                    <td class="fw-bold text-success">
                                        {{ number_format($itemSubtotal, 2) }} ج.م
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold">إجمالي عرض السعر التقديري:</th>
                                <th class="text-success fs-5 fw-bold">{{ number_format($calcTotal, 2) }} ج.م</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">تعديل حالة الطلب</label>
                        <select name="status" class="form-select">
                            <option value="جديد" {{ $quote->status == 'جديد' ? 'selected' : '' }}>جديد</option>
                            <option value="قيد المراجعة" {{ $quote->status == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة الفنية</option>
                            <option value="تم التسعير" {{ $quote->status == 'تم التسعير' ? 'selected' : '' }}>تم التسعير</option>
                            <option value="مقبول" {{ $quote->status == 'مقبول' ? 'selected' : '' }}>مقبول من العميل</option>
                            <option value="مرفوض" {{ $quote->status == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">ملاحظات الإدارة الداخلية (تظهر للإدارة فقط)</label>
                        <input type="text" name="admin_notes" class="form-control" value="{{ $quote->admin_notes }}" placeholder="مثال: خصم خاص 5% للمشتريات">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-save me-1"></i> حفظ التسعير وتحديث الحالة
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
