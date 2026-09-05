@extends('layouts.admin')

@section('title', 'إنشاء أمر بيع سريع (POS) — أليكس مارين')
@section('page_title', 'نظام البيع السريع وإصدار الفواتير المباشرة (Quick POS)')

@section('content')

<!-- Header Banner -->
<div class="card-luxury p-4 mb-4 bg-navy text-white" style="background: linear-gradient(135deg, #0A192F 0%, #162E4E 100%);">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-4 bg-gold text-dark d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px;">
            <i class="bi bi-cart-plus-fill fs-3 text-navy"></i>
        </div>
        <div>
            <h4 class="fw-extrabold text-white m-0">نظام البيع المباشر والفواتير الفورية (POS)</h4>
            <p class="text-white-50 fs-7 m-0 mt-1">إصدار أوامر البيع والفواتير المباشرة لعملاء المعرض والفروع بسرعة وسهولة</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.sales.store') }}" method="POST" id="posSaleForm">
    @csrf

    <div class="row g-4">
        
        <!-- Left Column: Customer & Invoice Settings -->
        <div class="col-lg-4">
            <div class="card-luxury p-4 sticky-top" style="top: 20px; z-index: 10;">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-person-badge-fill fs-4 text-gold"></i>
                    <div>
                        <h5 class="fw-bold text-navy m-0 fs-6">بيانات الفاتورة والعميل</h5>
                        <small class="text-muted fs-8">حدد الفرع وطريقة الدفع ونوع العميل</small>
                    </div>
                </div>

                <!-- Branch Selection -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">الفرع المسؤول عن البيع <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-select fw-bold" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name_ar }} ({{ $branch->city }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Customer Type Toggle -->
                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <label class="form-label fw-bold text-navy mb-2 fs-7">نوع العميل</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="customer_type" id="custCash" value="cash" checked onchange="toggleCustomerFields()">
                            <label class="form-check-label fw-bold text-navy" for="custCash">
                                <i class="bi bi-cash-stack text-gold me-1"></i> عميل نقدي
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="customer_type" id="custExisting" value="existing" onchange="toggleCustomerFields()">
                            <label class="form-check-label fw-bold text-navy" for="custExisting">
                                <i class="bi bi-person-check-fill text-gold me-1"></i> عميل مسجل
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Cash Customer Fields -->
                <div id="cashFields" class="mb-3">
                    <div class="mb-2">
                        <label class="form-label fw-bold text-navy fs-8">اسم العميل النقدي</label>
                        <input type="text" name="customer_name" class="form-control form-control-sm" value="عميل نقدي" placeholder="اسم العميل">
                    </div>
                    <div>
                        <label class="form-label fw-bold text-navy fs-8">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control form-control-sm" placeholder="010XXXXXXXX">
                    </div>
                </div>

                <!-- Existing Customer Selection -->
                <div id="existingFields" class="mb-3 d-none">
                    <label class="form-label fw-bold text-navy fs-7">اختر العميل المسجل</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">-- اختر العميل من الدليل --</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }} {{ $cust->company_name ? '('.$cust->company_name.')' : '' }} — {{ $cust->phone }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Status -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">طريقة الدفع والسداد <span class="text-danger">*</span></label>
                    <select name="payment_status" class="form-select fw-bold" required>
                        <option value="نقدي / مدفوع (Cash)" selected>💵 نقدي / كاش (Cash)</option>
                        <option value="تحويل بنكي / Instapay">📱 تحويل بنكي / Instapay</option>
                        <option value="آجل / حسابات">📄 آجل / حسابات</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-navy fs-8">ملاحظات الفاتورة</label>
                    <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="ملاحظات التسليم أو الضمان..."></textarea>
                </div>

                <!-- Grand Total Footer Summary Box -->
                <div class="p-3 bg-navy text-white rounded-4 shadow-sm text-center">
                    <span class="fs-8 text-gold fw-bold d-block mb-1">المبلغ الإجمالي المستحق</span>
                    <span class="fs-2 fw-extrabold text-white" id="posGrandTotalText">0.00 جـ.م</span>
                    
                    <button type="submit" class="btn btn-gold w-100 fw-bold rounded-pill py-2.5 mt-3 fs-6">
                        <i class="bi bi-printer-fill me-1"></i> حفظ وتأكيد الفاتورة
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Interactive Product Search & Cart Table -->
        <div class="col-lg-8">
            
            <!-- Product Fast Search -->
            <div class="card-luxury p-3 mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-gold"><i class="bi bi-search fs-5"></i></span>
                    <input type="text" id="posSearchInput" class="form-control border-start-0 fs-6" placeholder="🔍 بحث سريع باسم المنتج أو كود SKU لإضافته فوراً..." onkeyup="filterPosCatalog()">
                </div>

                <!-- Quick Product Dropdown / Results List -->
                <div id="posSearchResults" class="mt-2 overflow-auto" style="max-height: 220px; display: none;">
                    <div class="list-group list-group-flush border rounded-3" id="posResultsList">
                        @foreach($products as $p)
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-3 pos-item-result"
                                    data-id="{{ $p->id }}"
                                    data-name="{{ $p->name_ar }}"
                                    data-sku="{{ $p->sku }}"
                                    data-price="{{ $p->price }}"
                                    onclick="addPosItem({{ $p->id }}, '{{ addslashes($p->name_ar) }}', '{{ $p->sku }}', {{ $p->price }})">
                                <div>
                                    <strong class="text-navy">{{ $p->name_ar }}</strong>
                                    <span class="text-muted fs-8 ms-2"><code>{{ $p->sku ?: '—' }}</code></span>
                                </div>
                                <span class="badge badge-gold px-2 py-1 fs-7">{{ number_format($p->price, 2) }} ج.م <i class="bi bi-plus-lg ms-1"></i></span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Table -->
            <div class="card-luxury p-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cart3 fs-4 text-gold"></i>
                        <h5 class="fw-bold text-navy m-0">أصناف الفاتورة الحالية</h5>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="clearPosCart()">
                        <i class="bi bi-trash me-1"></i> إفراغ السلة
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-luxury align-middle m-0" id="posCartTable">
                        <thead>
                            <tr>
                                <th style="width: 40%;">المنتج</th>
                                <th class="text-center" style="width: 15%;">الكمية</th>
                                <th class="text-center" style="width: 20%;">سعر الوحدة (ج.م)</th>
                                <th class="text-center" style="width: 15%;">الإجمالي</th>
                                <th class="text-center" style="width: 10%;">حذف</th>
                            </tr>
                        </thead>
                        <tbody id="posCartBody">
                            <tr id="emptyCartRow">
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-cart-x fs-1 d-block mb-2 text-gold"></i>
                                    الفاتورة فارغة. ابحث عن منتج واضغط عليه لإضافته هنا فوراً.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</form>

<script>
let cartItems = {};

function toggleCustomerFields() {
    const isExisting = document.getElementById('custExisting').checked;
    document.getElementById('existingFields').classList.toggle('d-none', !isExisting);
    document.getElementById('cashFields').classList.toggle('d-none', isExisting);
}

function filterPosCatalog() {
    const query = document.getElementById('posSearchInput').value.toLowerCase().trim();
    const resultsContainer = document.getElementById('posSearchResults');
    const items = document.querySelectorAll('.pos-item-result');

    if (!query) {
        resultsContainer.style.display = 'none';
        return;
    }

    let matchCount = 0;
    items.forEach(el => {
        const name = el.getAttribute('data-name').toLowerCase();
        const sku = (el.getAttribute('data-sku') || '').toLowerCase();
        if (name.includes(query) || sku.includes(query)) {
            el.style.display = 'flex';
            matchCount++;
        } else {
            el.style.display = 'none';
        }
    });

    resultsContainer.style.display = matchCount > 0 ? 'block' : 'none';
}

function addPosItem(id, name, sku, price) {
    if (cartItems[id]) {
        cartItems[id].quantity += 1;
    } else {
        cartItems[id] = {
            id: id,
            name: name,
            sku: sku || '—',
            quantity: 1,
            unit_price: parseFloat(price) || 0
        };
    }
    renderPosCart();
    document.getElementById('posSearchInput').value = '';
    document.getElementById('posSearchResults').style.display = 'none';
}

function removePosItem(id) {
    delete cartItems[id];
    renderPosCart();
}

function updatePosItemQty(id, val) {
    const qty = parseInt(val) || 1;
    if (cartItems[id]) {
        cartItems[id].quantity = qty > 0 ? qty : 1;
        renderPosCart();
    }
}

function updatePosItemPrice(id, val) {
    const price = parseFloat(val) || 0;
    if (cartItems[id]) {
        cartItems[id].unit_price = price >= 0 ? price : 0;
        renderPosCart();
    }
}

function clearPosCart() {
    cartItems = {};
    renderPosCart();
}

function renderPosCart() {
    const tbody = document.getElementById('posCartBody');
    tbody.innerHTML = '';

    const keys = Object.keys(cartItems);
    if (keys.length === 0) {
        tbody.innerHTML = `
            <tr id="emptyCartRow">
                <td colspan="5" class="text-center text-muted py-5">
                    <i class="bi bi-cart-x fs-1 d-block mb-2 text-gold"></i>
                    الفاتورة فارغة. ابحث عن منتج واضغط عليه لإضافته هنا فوراً.
                </td>
            </tr>
        `;
        document.getElementById('posGrandTotalText').textContent = '0.00 جـ.م';
        return;
    }

    let grand = 0;
    keys.forEach((key, index) => {
        const item = cartItems[key];
        const subtotal = item.quantity * item.unit_price;
        grand += subtotal;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <strong class="text-navy">${item.name}</strong>
                <small class="text-muted d-block">كود: <code>${item.sku}</code></small>
            </td>
            <td>
                <input type="number" name="items[${index}][quantity]" value="${item.quantity}" min="1" class="form-control form-control-sm text-center fw-bold" onchange="updatePosItemQty(${item.id}, this.value)">
            </td>
            <td>
                <input type="number" step="0.01" name="items[${index}][unit_price]" value="${item.unit_price.toFixed(2)}" min="0" class="form-control form-control-sm text-center fw-bold text-navy" onchange="updatePosItemPrice(${item.id}, this.value)">
            </td>
            <td class="text-center fw-extrabold text-navy">
                ${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} ج.م
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-1" onclick="removePosItem(${item.id})">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('posGrandTotalText').textContent = grand.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' جـ.م';
}
</script>

@endsection
