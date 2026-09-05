@extends('layouts.admin')

@section('title', 'تفاصيل أمر الشراء ' . $order->order_number . ' — أليكس مارين')
@section('page_title', 'أمر الشراء وإدارة البيع: ' . $order->order_number)

@section('content')

@php
    $waMessage = "مرحباً " . ($order->customer_name ?: 'عزيزنا العميل') . "، بخصوص أمر الشراء رقم (" . $order->order_number . ") بقيمة " . number_format($order->total_amount, 2) . " ج.م من شركة أليكس مارين للمهمات البحرية.";
    $waLink = \App\Helpers\WhatsAppHelper::link($order->phone, $waMessage);
@endphp

<!-- Main Order Banner -->
<div class="card-luxury p-4 mb-4 bg-navy text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0A192F 0%, #162E4E 100%);">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 position-relative" style="z-index: 2;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-4 bg-gold text-dark d-flex align-items-center justify-content-center shadow" style="width: 54px; height: 54px;">
                <i class="bi bi-receipt-cutoff fs-3 text-navy"></i>
            </div>
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h3 class="fw-extrabold text-white m-0">{{ $order->order_number }}</h3>
                    <span class="badge {{ str_contains($order->status, 'مكتمل') ? 'bg-success' : 'badge-gold' }} fs-7 px-3 py-1.5 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> {{ $order->status }}
                    </span>
                    <span class="badge bg-white bg-opacity-20 text-white fs-7 px-3 py-1.5 rounded-pill">
                        💳 {{ $order->payment_status }}
                    </span>
                </div>
                <p class="text-white-50 fs-7 m-0">تاريخ الإنشاء: {{ $order->created_at->format('Y-m-d — H:i') }} | الفرع: {{ $order->branch ? $order->branch->name_ar : 'الرئيسي' }}</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if(!empty($order->phone))
                <a href="{{ $waLink }}" target="_blank" class="btn btn-whatsapp px-3 py-2 shadow">
                    <i class="bi bi-whatsapp fs-5"></i>
                    <span>محادثة واتساب العميل</span>
                </a>
            @endif
            <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-3 py-2">
                <i class="bi bi-printer me-1"></i> طباعة الفاتورة
            </button>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Customer Details & Complete Sale Action -->
    <div class="col-lg-4">
        
        <!-- Customer Info Card -->
        <div class="card-luxury p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle fs-4 text-gold"></i>
                    <h5 class="fw-bold text-navy m-0">بيانات العميل</h5>
                </div>
                @if(!empty($order->phone))
                    <a href="{{ $waLink }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب فورية">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                @endif
            </div>

            <div class="d-flex flex-column gap-2 text-dark fs-7">
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">اسم العميل:</span>
                    <strong class="text-navy">{{ $order->customer_name ?: 'عميل نقدي' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">الشركة / الجهة:</span>
                    <strong class="text-navy">{{ $order->company_name ?: '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">الهاتف:</span>
                    <div class="d-flex align-items-center gap-1" dir="ltr">
                        <strong class="text-navy">{{ $order->phone ?: '—' }}</strong>
                    </div>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                    <span class="text-muted">البريد الإلكتروني:</span>
                    <span class="text-navy">{{ $order->email ?: '—' }}</span>
                </div>
                @if($order->quoteRequest)
                    <div class="d-flex justify-content-between py-1 border-bottom border-light">
                        <span class="text-muted">طلب العرض الأصلي:</span>
                        <a href="{{ route('admin.quotes.show', $order->quoteRequest->id) }}" class="fw-bold text-gold text-decoration-none">
                            {{ $order->quoteRequest->quote_number }}
                        </a>
                    </div>
                @endif
                <div class="py-1">
                    <span class="text-muted d-block mb-1">ملاحظات الطلب:</span>
                    <div class="bg-light p-2 rounded-3 text-secondary">{{ $order->notes ?: 'لا توجد ملاحظات مسجلة.' }}</div>
                </div>
            </div>
        </div>

        <!-- Complete Sale / Action Card -->
        <div class="card-luxury p-4 border-2 border-warning shadow-sm" style="border-color: rgba(212, 175, 55, 0.4) !important;">
            <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
                <i class="bi bi-cash-coin fs-4 text-gold"></i>
                <h5 class="fw-bold text-navy m-0">تأكيد وإتمام البيع (Complete Sale)</h5>
            </div>

            <form action="{{ route('admin.orders.complete-sale', $order->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">طريقة السداد / الدفع <span class="text-danger">*</span></label>
                    <select name="payment_status" class="form-select fw-bold border-secondary border-opacity-25" required>
                        <option value="نقدي / مدفوع (Cash)" {{ $order->payment_status == 'نقدي / مدفوع (Cash)' ? 'selected' : '' }}>💵 نقدي / كاش (Cash)</option>
                        <option value="تحويل بنكي / Instapay" {{ $order->payment_status == 'تحويل بنكي / Instapay' ? 'selected' : '' }}>📱 تحويل بنكي / Instapay</option>
                        <option value="آجل / حسابات" {{ $order->payment_status == 'آجل / حسابات' ? 'selected' : '' }}>📄 آجل / حسابات</option>
                        <option value="شيك بنكي" {{ $order->payment_status == 'شيك بنكي' ? 'selected' : '' }}>🏛️ شيك بنكي</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">فرع البيع والتسليم</label>
                    <select name="branch_id" class="form-select fs-7">
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ $order->branch_id == $b->id ? 'selected' : '' }}>{{ $b->name_ar }} ({{ $b->city }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">ملاحظات الإتمام أو الفاتورة</label>
                    <textarea name="notes" rows="2" class="form-control fs-7" placeholder="ملاحظات التسليم أو رقم إيصال التحويل...">{{ $order->notes }}</textarea>
                </div>

                <div class="p-3 bg-navy text-white rounded-3 text-center mb-3">
                    <span class="fs-8 text-gold fw-bold d-block mb-1">المبلغ الإجمالي النهائي</span>
                    <span class="fs-3 fw-extrabold text-white">{{ number_format($order->total_amount, 2) }} ج.م</span>
                </div>

                <button type="submit" class="btn btn-gold w-100 py-2.5 rounded-pill fs-6 fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> عمل بيع وتأكيد الفاتورة
                </button>
            </form>
        </div>

    </div>

    <!-- Right Column: Order Items Management & Live Price Editor -->
    <div class="col-lg-8">
        
        <!-- 1. Order Items Live Table & Editor -->
        <div class="card-luxury p-4 mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-boxes fs-4 text-gold"></i>
                    <h5 class="fw-bold text-navy m-0">أصناف أمر الشراء (تعديل مباشر للأسعار والكميات)</h5>
                </div>
                <button type="button" class="btn btn-sm btn-outline-navy rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#addProductCollapse">
                    <i class="bi bi-plus-circle-fill text-gold me-1"></i> إضافة منتج للطلب
                </button>
            </div>

            <!-- Add Product Collapsible Panel -->
            <div class="collapse mb-4" id="addProductCollapse">
                <div class="p-3 bg-light rounded-4 border border-secondary border-opacity-25 shadow-sm">
                    <h6 class="fw-bold text-navy mb-2"><i class="bi bi-cart-plus me-1 text-gold"></i> إضافة منتج جديد إلى هذا الطلب</h6>
                    <form action="{{ route('admin.orders.items.add', $order->id) }}" method="POST" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-md-5">
                            <label class="form-label fs-8 fw-bold text-navy">اختر المنتج من الكتالوج</label>
                            <select name="product_id" id="quickProductSelect" class="form-select form-select-sm" required onchange="updateProductDefaultPrice()">
                                <option value="" data-price="0">-- اختر المنتج --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" data-price="{{ $p->price }}" data-sku="{{ $p->sku }}">{{ $p->name_ar }} ({{ $p->sku ?: 'بلا كود' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-8 fw-bold text-navy">الكمية</label>
                            <input type="number" name="quantity" id="quickQty" value="1" min="1" class="form-control form-control-sm text-center fw-bold" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-8 fw-bold text-navy">سعر الوحدة (ج.م)</label>
                            <input type="number" step="0.01" name="unit_price" id="quickPrice" value="0.00" min="0" class="form-control form-control-sm text-center fw-bold" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-navy btn-sm w-100 rounded-3 fw-bold">
                                <i class="bi bi-plus-lg"></i> إضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Items Form for bulk price/quantity changes -->
            <form action="{{ route('admin.orders.update-items', $order->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-luxury align-middle m-0" id="orderItemsTable">
                        <thead>
                            <tr>
                                <th style="width: 40%;">المنتج</th>
                                <th class="text-center" style="width: 15%;">الكمية</th>
                                <th class="text-center" style="width: 20%;">سعر الوحدة (ج.م)</th>
                                <th class="text-center" style="width: 15%;">الإجمالي</th>
                                <th class="text-center" style="width: 10%;">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-navy">{{ $item->product_name }}</div>
                                        <small class="text-muted">كود: <code>{{ $item->sku ?: '—' }}</code></small>
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm text-center fw-bold item-qty-input" oninput="recalcRowTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="items[{{ $item->id }}][unit_price]" value="{{ $item->unit_price }}" min="0" class="form-control form-control-sm text-center fw-bold text-navy item-price-input" oninput="recalcRowTotal(this)">
                                    </td>
                                    <td class="text-center fw-extrabold text-navy row-total-text">
                                        {{ number_format($item->total_price, 2) }} ج.م
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-1" title="حذف الصنف" onclick="if(confirm('هل أنت متأكد من حذف هذا الصنف من أمر الشراء؟')) { document.getElementById('delete-item-{{ $item->id }}').submit(); }">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">لا توجد أصناف في هذا الطلب حتى الآن. يمكنك إضافة منتجات من الزر أعلاه.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <th colspan="3" class="text-end fw-extrabold text-navy fs-6">إجمالي أمر الشراء:</th>
                                <th class="text-center text-navy fw-extrabold fs-5" id="liveGrandTotal">
                                    {{ number_format($order->total_amount, 2) }} ج.م
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->items->count() > 0)
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-navy rounded-pill px-4 fw-bold">
                            <i class="bi bi-save2-fill text-gold me-1"></i> حفظ التعديلات على الأسعار والكميات
                        </button>
                    </div>
                @endif
            </form>

            <!-- Hidden delete forms -->
            @foreach($order->items as $item)
                <form id="delete-item-{{ $item->id }}" action="{{ route('admin.orders.items.delete', [$order->id, $item->id]) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>

    </div>
</div>

<script>
function updateProductDefaultPrice() {
    const sel = document.getElementById('quickProductSelect');
    const selectedOption = sel.options[sel.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 0;
    document.getElementById('quickPrice').value = parseFloat(price).toFixed(2);
}

function recalcRowTotal(input) {
    const row = input.closest('tr');
    const qtyInput = row.querySelector('.item-qty-input');
    const priceInput = row.querySelector('.item-price-input');
    const totalCell = row.querySelector('.row-total-text');

    const qty = parseFloat(qtyInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    const total = qty * price;

    totalCell.textContent = total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ج.م';

    // Recalculate grand total
    let grand = 0;
    document.querySelectorAll('#orderItemsTable tbody tr').forEach(r => {
        const q = parseFloat(r.querySelector('.item-qty-input')?.value) || 0;
        const p = parseFloat(r.querySelector('.item-price-input')?.value) || 0;
        grand += (q * p);
    });

    document.getElementById('liveGrandTotal').textContent = grand.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ج.م';
}
</script>

@endsection
