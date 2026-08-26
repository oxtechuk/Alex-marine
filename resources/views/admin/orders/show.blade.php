@extends('layouts.admin')

@section('title', 'تفاصيل أمر الشراء ' . $order->order_number)
@section('page_title', 'أمر الشراء: ' . $order->order_number)

@section('content')

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">بيانات أمر الشراء</h5>
            <div class="d-flex flex-column gap-2 text-secondary">
                <div><strong>رقم الأمر:</strong> <span class="text-success fw-bold">{{ $order->order_number }}</span></div>
                <div><strong>اسم الشركة:</strong> {{ $order->company_name }}</div>
                <div><strong>المسئول:</strong> {{ $order->customer_name }}</div>
                <div><strong>الهاتف:</strong> {{ $order->phone }}</div>
                <div><strong>البريد:</strong> {{ $order->email }}</div>
                <div><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
                <div><strong>حالة الدفع:</strong> {{ $order->payment_status }}</div>
                <div><strong>حالة الشحن والتسليم:</strong> <span class="badge bg-success">{{ $order->status }}</span></div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">الأصناف والتجهيز</h5>

            <div class="table-responsive">
                <table class="table align-middle table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>كود SKU</th>
                            <th>الكمية</th>
                            <th>سعر الوحدة</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td><strong>{{ $item->product_name }}</strong></td>
                                <td><code>{{ $item->sku ?: '—' }}</code></td>
                                <td><span class="badge bg-secondary">{{ $item->quantity }}</span></td>
                                <td>{{ number_format($item->unit_price, 2) }} ج.م</td>
                                <td class="fw-bold text-success">{{ number_format($item->total_price, 2) }} ج.م</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">الإجمالي المستحق:</th>
                            <th class="text-success fs-5 fw-bold">{{ number_format($order->total_amount, 2) }} ج.م</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
