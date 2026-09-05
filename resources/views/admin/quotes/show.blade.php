@extends('layouts.admin')

@section('title', 'تفاصيل RFQ ' . $quote->quote_number . ' — أليكس مارين')
@section('page_title', 'معالجة وتسعير طلب عرض السعر: ' . $quote->quote_number)

@section('content')

@php
    $waMsg = "مرحباً " . ($quote->customer_name ?: 'عزيزنا العميل') . "، بخصوص عرض السعر رقم (" . $quote->quote_number . ") لدى شركة أليكس مارين للمهمات البحرية.";
    $waUrl = \App\Helpers\WhatsAppHelper::link($quote->phone, $waMsg);
@endphp

<!-- RFQ Header Banner -->
<div class="card-luxury p-4 mb-4 bg-navy text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0A192F 0%, #162E4E 100%);">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 position-relative" style="z-index: 2;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-4 bg-gold text-dark d-flex align-items-center justify-content-center shadow" style="width: 54px; height: 54px;">
                <i class="bi bi-file-earmark-spreadsheet fs-3 text-navy"></i>
            </div>
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h3 class="fw-extrabold text-white m-0">{{ $quote->quote_number }}</h3>
                    <span class="badge {{ $quote->status == 'جديد' ? 'badge-gold' : ($quote->status == 'مقبول' ? 'bg-success' : 'badge-navy') }} fs-7 px-3 py-1.5 rounded-pill">
                        {{ $quote->status }}
                    </span>
                </div>
                <p class="text-white-50 fs-7 m-0">تاريخ الطلب: {{ $quote->created_at->format('Y-m-d — H:i') }} | الشركة: {{ $quote->company_name ?: 'طلب مباشر' }}</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if(!empty($quote->phone))
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-whatsapp px-3 py-2 shadow">
                    <i class="bi bi-whatsapp fs-5"></i>
                    <span>محادثة واتساب العميل</span>
                </a>
            @endif
            <a href="{{ route('admin.quotes.print', $quote->id) }}" target="_blank" class="btn btn-outline-light rounded-pill px-3 py-2">
                <i class="bi bi-printer me-1"></i> طباعة PDF
            </a>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Customer Info Card -->
    <div class="col-lg-4">
        <div class="card-luxury p-4 h-100">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-building fs-4 text-gold"></i>
                    <h5 class="fw-bold text-navy m-0">بيانات جهة الطلب</h5>
                </div>
                @if(!empty($quote->phone))
                    <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                @endif
            </div>

            <div class="d-flex flex-column gap-2 text-dark fs-7 mb-4">
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">اسم الشركة:</span>
                    <strong class="text-navy">{{ $quote->company_name ?: '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">اسم المسئول:</span>
                    <strong class="text-navy">{{ $quote->customer_name ?: '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">البريد الإلكتروني:</span>
                    <span class="text-navy">{{ $quote->email ?: '—' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">الهاتف:</span>
                    <strong class="text-navy" dir="ltr">{{ $quote->phone ?: '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">تاريخ الطلب:</span>
                    <span class="text-muted">{{ $quote->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>

            <div class="pt-3 border-top d-flex flex-column gap-2">
                @if(!$quote->order)
                    <form action="{{ route('admin.quotes.convert', $quote->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من تحويل هذا الطلب رسمياً إلى أمر شراء وفاتورة بيع؟');">
                        @csrf
                        <button type="submit" class="btn btn-gold w-100 py-2.5 rounded-pill fw-bold fs-6">
                            <i class="bi bi-cart-check-fill me-1"></i> تحويل إلى أمر شراء (Convert to Order)
                        </button>
                    </form>
                @else
                    <a href="{{ route('admin.orders.show', $quote->order->id) }}" class="btn btn-navy w-100 py-2.5 rounded-pill fw-bold">
                        <i class="bi bi-check-circle-fill text-gold me-1"></i> تم التحويل لأمر شراء ({{ $quote->order->order_number }})
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Items Pricing Form -->
    <div class="col-lg-8">
        <div class="card-luxury p-4">
            <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
                <i class="bi bi-calculator-fill fs-4 text-gold"></i>
                <h5 class="fw-bold text-navy m-0">تسعير الأصناف والملاحظات الفنية</h5>
            </div>

            <form action="{{ route('admin.quotes.update', $quote->id) }}" method="POST">
                @csrf
                <div class="table-responsive mb-4">
                    <table class="table table-luxury align-middle m-0" id="quotePricingTable">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>كود SKU</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">سعر الوحدة (ج.م)</th>
                                <th class="text-center">الإجمالي</th>
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
                                        <div class="fw-bold text-navy">{{ $item->product_name }}</div>
                                        @if($item->notes)<small class="text-muted d-block">{{ $item->notes }}</small>@endif
                                    </td>
                                    <td><code>{{ $item->sku ?: '—' }}</code></td>
                                    <td class="text-center">
                                        <span class="badge badge-navy px-3 py-1.5 fs-7 r-qty" data-qty="{{ $item->quantity }}">{{ $item->quantity }}</span>
                                    </td>
                                    <td style="width: 150px;">
                                        <input type="number" step="0.01" name="items[{{ $item->id }}][price]" class="form-control form-control-sm text-center fw-bold text-navy r-price-input" value="{{ $item->unit_price }}" placeholder="0.00" oninput="recalcQuoteTable()">
                                    </td>
                                    <td class="text-center fw-bold text-navy r-subtotal">
                                        {{ number_format($itemSubtotal, 2) }} ج.م
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <th colspan="4" class="text-end fw-extrabold text-navy fs-6">إجمالي عرض السعر التقديري:</th>
                                <th class="text-center text-navy fw-extrabold fs-5" id="quoteLiveGrandTotal">{{ number_format($calcTotal, 2) }} ج.م</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-navy fs-7">تعديل حالة طلب التسعير</label>
                        <select name="status" class="form-select fw-bold">
                            <option value="جديد" {{ $quote->status == 'جديد' ? 'selected' : '' }}>جديد</option>
                            <option value="قيد المراجعة" {{ $quote->status == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة الفنية</option>
                            <option value="تم التسعير" {{ $quote->status == 'تم التسعير' ? 'selected' : '' }}>تم التسعير وإرسال العرض</option>
                            <option value="مقبول" {{ $quote->status == 'مقبول' ? 'selected' : '' }}>مقبول من العميل</option>
                            <option value="مرفوض" {{ $quote->status == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-navy fs-7">ملاحظات الإدارة الداخلية (للإدارة فقط)</label>
                        <input type="text" name="admin_notes" class="form-control" value="{{ $quote->admin_notes }}" placeholder="مثال: خصم 5%، تسليم ميناء الإسكندرية...">
                    </div>
                </div>

                <button type="submit" class="btn btn-navy btn-lg w-100 rounded-pill fw-bold">
                    <i class="bi bi-save2-fill text-gold me-1"></i> حفظ التسعير وتحديث الحالة
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function recalcQuoteTable() {
    let grand = 0;
    document.querySelectorAll('#quotePricingTable tbody tr').forEach(row => {
        const qty = parseFloat(row.querySelector('.r-qty')?.getAttribute('data-qty')) || 0;
        const price = parseFloat(row.querySelector('.r-price-input')?.value) || 0;
        const subtotal = qty * price;
        row.querySelector('.r-subtotal').textContent = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ج.م';
        grand += subtotal;
    });
    document.getElementById('quoteLiveGrandTotal').textContent = grand.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ج.م';
}
</script>

@endsection
