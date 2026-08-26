@extends('layouts.admin')

@section('title', 'إنشاء أمر بيع فوري (POS) — أليكس مارين')
@section('page_title', 'نظام نقطة البيع والبيع المباشر (POS System)')

@section('content')

<!-- Header Banner -->
<div class="card border-0 shadow-sm rounded-4 bg-navy text-white p-4 mb-4" style="background: linear-gradient(135deg, #0A1D37 0%, #0D3B66 100%);">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-white bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-3 border border-warning border-opacity-25" style="width: 48px; height: 48px;">
            <i class="bi bi-cart-plus-fill fs-3 text-warning"></i>
        </div>
        <div>
            <h4 class="fw-extrabold text-white m-0">نظام البيع المباشر وإنشاء الفواتير (POS)</h4>
            <p class="text-white-50 fs-7 m-0 mt-1">إصدار الفواتير الفورية واختيار المنتجات حسب الأقساب والتسميع الآلي لأسعار البيع</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.sales.store') }}" method="POST" id="saleForm">
    @csrf

    <div class="row g-4">
        
        <!-- Left Side: Sale Options & Customer Details -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 sticky-top" style="top: 20px; z-index: 10;">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <div class="bg-navy bg-opacity-10 text-navy rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-badge-fill fs-5 text-navy"></i>
                    </div>
                    <div>
                        <h5 class="fw-extrabold text-navy m-0 fs-6">بيانات الفاتورة والفرع</h5>
                        <small class="text-muted fs-8">اختر نوع العميل والفرع التابع للبيع</small>
                    </div>
                </div>

                <!-- Branch Selection -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">الفرع التابع للعملية <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-select fw-bold" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name_ar }} ({{ $branch->city }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Customer Type Toggle -->
                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <label class="form-label fw-bold text-navy mb-2 fs-7">نوع العميل <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="customer_type" id="custCash" value="cash" checked onchange="toggleCustomerFields()">
                            <label class="form-check-label fw-bold text-success" for="custCash">
                                <i class="bi bi-cash-stack me-1"></i> عميل نقدي
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="customer_type" id="custExisting" value="existing" onchange="toggleCustomerFields()">
                            <label class="form-check-label fw-bold text-navy" for="custExisting">
                                <i class="bi bi-person-check-fill me-1"></i> عميل مسجل
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Cash Customer Fields -->
                <div id="cashFields" class="mb-3">
                    <div class="mb-2">
                        <label class="form-label fw-bold fs-7">اسم العميل النقدي</label>
                        <input type="text" name="customer_name" class="form-control form-control-sm" value="عميل نقدي" placeholder="اسم العميل">
                    </div>
                    <div>
                        <label class="form-label fw-bold fs-7">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control form-control-sm" placeholder="010XXXXXXXX">
                    </div>
                </div>

                <!-- Existing Customer Selection -->
                <div id="existingFields" class="mb-3 d-none">
                    <label class="form-label fw-bold text-navy fs-7">اختر العميل المسجل <span class="text-danger">*</span></label>
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
                        <option value="نقدي / مدفوع" selected>💵 نقدي / كاش (Cash)</option>
                        <option value="تحويل بنكي / فوري">📱 تحويل بنكي / Instapay</option>
                        <option value="آجل / حسب الاتفاق">📄 آجل / حسابات</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold fs-7">ملاحظات الفاتورة</label>
                    <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="ملاحظات التسليم أو الضمان..."></textarea>
                </div>

                <!-- Grand Total Footer Summary Box -->
                <div class="p-3 bg-navy text-white rounded-4 shadow-sm border border-warning border-opacity-25 text-center" style="background-color: #0A1D37 !important;">
                    <span class="fs-7 text-warning fw-bold d-block mb-1">إجمالي فاتورة POS المباشرة</span>
                    <span class="fs-2 fw-extrabold text-white" id="grandTotalText">0.00 جـ.م</span>
                    
                    <button type="submit" class="btn btn-navy w-100 fw-extrabold rounded-pill py-2.5 text-white mt-3 fs-6 shadow border border-warning border-opacity-50">
                        <i class="bi bi-printer-fill text-warning me-2"></i> تأكيد وحفظ الفاتورة
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Side: POS Interactive Product Browser & Cart -->
        <div class="col-lg-8">
            
            <!-- 1. POS Interactive Product Browser Header -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-grid-3x3-gap-fill fs-3 text-warning"></i>
                        <div>
                            <h5 class="fw-extrabold text-navy m-0 fs-6">تصفح المنتجات واختيار الأقسام</h5>
                            <small class="text-muted fs-8">اضغط على أي منتج لإضافته فورياً للفاتورة مع سعر البيع</small>
                        </div>
                    </div>
                </div>

                <!-- Quick Search Input -->
                <div class="mb-3">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" id="posSearchInput" class="form-control border-start-0 bg-light fs-6" placeholder="🔍 بحث سريع باسم المنتج أو كود SKU..." onkeyup="filterPosProducts()">
                    </div>
                </div>

                <!-- Category Filters (Pills) -->
                <div class="d-flex gap-2 overflow-auto pb-2" id="categoryPills">
                    <button type="button" class="btn btn-navy btn-sm rounded-pill px-3 fw-bold pos-cat-btn active" data-cat="all" onclick="filterByCategory('all', this)" style="background-color: #0A1D37; color: white;">
                        🌐 جميع الأقسام (الكل)
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold pos-cat-btn" data-cat="{{ $cat->id }}" onclick="filterByCategory('{{ $cat->id }}', this)">
                            {{ $cat->name_ar }}
                        </button>
                    @endforeach
                </div>

                <!-- Visual Product Cards Grid -->
                <div class="row g-3 mt-2 overflow-auto style-scrollbar" style="max-height: 280px;" id="posProductsGrid">
                    @foreach($products as $prod)
                        @php
                            $pImg = !empty($prod->image) && is_string($prod->image) ? (\Illuminate\Support\Str::startsWith($prod->image, ['http://', 'https://']) ? $prod->image : asset($prod->image)) : null;
                        @endphp
                        <div class="col-md-4 col-6 pos-product-item" data-cat-id="{{ $prod->category_id }}" data-name="{{ mb_strtolower($prod->name_ar . ' ' . $prod->name_en) }}" data-sku="{{ mb_strtolower($prod->sku) }}">
                            <div class="card h-100 border rounded-3 p-2 bg-light hover-shadow cursor-pointer product-card-clickable" onclick="addSpecificProductToInvoice({{ $prod->id }}, '{{ addslashes($prod->name_ar) }}', '{{ $prod->sku }}', {{ $prod->price ?? 0 }})">
                                <div class="d-flex align-items-center gap-2">
                                    @if($pImg)
                                        <img src="{{ $pImg }}" style="width: 42px; height: 42px; object-fit: cover;" class="rounded-3 border">
                                    @else
                                        <div class="bg-white rounded-3 d-flex align-items-center justify-content-center border text-muted" style="width: 42px; height: 42px;">
                                            <i class="bi bi-box-seam fs-6"></i>
                                        </div>
                                    @endif
                                    <div class="overflow-hidden">
                                        <div class="fw-bold text-navy text-truncate fs-8" title="{{ $prod->name_ar }}">{{ $prod->name_ar }}</div>
                                        <div class="d-flex align-items-center justify-content-between gap-1 mt-1">
                                            <span class="badge bg-white text-secondary border font-monospace fs-8">{{ $prod->sku }}</span>
                                            <span class="badge bg-navy text-white fw-bold fs-8">{{ number_format($prod->price ?? 0, 2) }} جـ.م</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- 2. Invoice Line Items Table Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cart-check-fill fs-3 text-marine"></i>
                        <div>
                            <h5 class="fw-extrabold text-navy m-0 fs-6">جدول بنود فاتورة البيع المباشر</h5>
                            <small class="text-muted fs-8">المنتجات المضافة للفاتورة حالياً</small>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-navy fw-bold rounded-pill px-3" onclick="addItemRow()">
                        <i class="bi bi-plus-circle me-1 text-warning"></i> إضافة صف يدوي
                    </button>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle" id="itemsTable">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 45%;">المنتج والـ SKU <span class="text-danger">*</span></th>
                                <th style="width: 20%;">الكمية <span class="text-danger">*</span></th>
                                <th style="width: 25%;">سعر البيع (جـ.م) <span class="text-danger">*</span></th>
                                <th style="width: 10%;" class="text-center">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Item Row 0 -->
                            <tr class="item-row">
                                <td>
                                    <select name="items[0][product_id]" class="form-select product-select fw-semibold" required onchange="updateProductPrice(this)">
                                        <option value="">-- اختر المنتج --</option>
                                        @foreach($products as $prod)
                                            <option value="{{ $prod->id }}" data-sku="{{ $prod->sku }}" data-price="{{ $prod->price ?? 0 }}">
                                                {{ $prod->name_ar }} ({{ $prod->sku }}) {{ $prod->price ? '— '.number_format($prod->price, 2).' جـ.م' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="items[0][quantity]" class="form-control qty-input font-monospace fw-bold" value="1" min="1" required onchange="calculateGrandTotal()" onkeyup="calculateGrandTotal()">
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="items[0][unit_price]" class="form-control price-input font-monospace fw-bold text-success" value="0.00" required onchange="calculateGrandTotal()" onkeyup="calculateGrandTotal()">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeRow(this)"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
</form>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(10,29,55,0.08);
        border-color: #0A1D37 !important;
        transition: all 0.2s ease;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    let itemIndex = 1;

    function toggleCustomerFields() {
        const isCash = document.getElementById('custCash').checked;
        const cashDiv = document.getElementById('cashFields');
        const existingDiv = document.getElementById('existingFields');

        if (isCash) {
            cashDiv.classList.remove('d-none');
            existingDiv.classList.add('d-none');
        } else {
            cashDiv.classList.add('d-none');
            existingDiv.classList.remove('d-none');
        }
    }

    function filterByCategory(catId, btnElement) {
        document.querySelectorAll('.pos-cat-btn').forEach(btn => {
            btn.classList.remove('active', 'btn-navy');
            btn.classList.add('btn-outline-secondary');
            btn.style.backgroundColor = '';
            btn.style.color = '';
        });

        btnElement.classList.remove('btn-outline-secondary');
        btnElement.classList.add('active', 'btn-navy');
        btnElement.style.backgroundColor = '#0A1D37';
        btnElement.style.color = 'white';

        const items = document.querySelectorAll('.pos-product-item');
        items.forEach(item => {
            if (catId === 'all' || item.getAttribute('data-cat-id') === catId) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    }

    function filterPosProducts() {
        const query = document.getElementById('posSearchInput').value.toLowerCase().trim();
        const items = document.querySelectorAll('.pos-product-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name');
            const sku = item.getAttribute('data-sku');

            if (name.includes(query) || sku.includes(query)) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    }

    function addSpecificProductToInvoice(productId, productName, sku, price) {
        const rows = document.querySelectorAll('.item-row');
        let targetRow = null;

        const firstRowSelect = rows[0].querySelector('.product-select');
        if (firstRowSelect && !firstRowSelect.value) {
            targetRow = rows[0];
        } else {
            rows.forEach(r => {
                const sel = r.querySelector('.product-select');
                if (sel && sel.value == productId) {
                    targetRow = r;
                }
            });
        }

        if (targetRow && targetRow.querySelector('.product-select').value == productId) {
            const qtyInput = targetRow.querySelector('.qty-input');
            qtyInput.value = parseInt(qtyInput.value || 0) + 1;
        } else if (targetRow && !targetRow.querySelector('.product-select').value) {
            const select = targetRow.querySelector('.product-select');
            select.value = productId;
            const priceInput = targetRow.querySelector('.price-input');
            if (priceInput) {
                priceInput.value = parseFloat(price).toFixed(2);
            }
        } else {
            addItemRow();
            const newRows = document.querySelectorAll('.item-row');
            const lastRow = newRows[newRows.length - 1];
            const select = lastRow.querySelector('.product-select');
            select.value = productId;
            const priceInput = lastRow.querySelector('.price-input');
            if (priceInput) {
                priceInput.value = parseFloat(price).toFixed(2);
            }
        }

        calculateGrandTotal();
    }

    function addItemRow() {
        const tableBody = document.querySelector('#itemsTable tbody');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        const select = newRow.querySelector('.product-select');
        const qty = newRow.querySelector('.qty-input');
        const price = newRow.querySelector('.price-input');

        select.name = `items[${itemIndex}][product_id]`;
        select.value = '';
        qty.name = `items[${itemIndex}][quantity]`;
        qty.value = '1';
        price.name = `items[${itemIndex}][unit_price]`;
        price.value = '0.00';

        tableBody.appendChild(newRow);
        itemIndex++;
        calculateGrandTotal();
    }

    function removeRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('tr').remove();
            calculateGrandTotal();
        } else {
            alert('يجب إضافة منتج واحد على الأقل في العملية.');
        }
    }

    function updateProductPrice(select) {
        const selectedOption = select.options[select.selectedIndex];
        const price = selectedOption.getAttribute('data-price') || 0;
        const row = select.closest('tr');
        const priceInput = row.querySelector('.price-input');
        if (priceInput) {
            priceInput.value = parseFloat(price).toFixed(2);
        }
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            grandTotal += (qty * price);
        });

        document.getElementById('grandTotalText').innerText = grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' جـ.م';
    }
</script>

@endsection
