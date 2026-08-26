<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عرض سعر - {{ $quote->quote_number }} - أليكس مارين</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; direction: rtl; text-align: right; padding: 20px; color: #333; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #0A1D37; padding-bottom: 15px; margin-bottom: 20px; }
        .logo-title { font-size: 24px; font-weight: bold; color: #0A1D37; }
        .company-info { font-size: 13px; color: #666; line-height: 1.5; }
        .quote-box { background-color: #F2F4F7; border-radius: 8px; padding: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 10px; font-size: 14px; }
        th { background-color: #0A1D37; color: #fff; text-align: right; }
        .total-row { background-color: #f8f9fa; font-weight: bold; }
        .footer { margin-top: 50px; font-size: 12px; text-align: center; color: #777; border-top: 1px solid #ddd; padding-top: 15px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print();" style="padding: 10px 20px; background-color: #0A1D37; color: white; border: none; border-radius: 5px; cursor: pointer;">
            طباعة عرض السعر / حفظ PDF
        </button>
    </div>

    <div class="header">
        <div>
            <div class="logo-title">ALEX MARINE — أليكس مارين</div>
            <div>للتوريدات البحرية ومهمات الأمن الصناعي</div>
            <div class="company-info">الإسكندرية - المنطقة الجمركية | هاتف: +20 120 000 1122 | البريد: info@alexmarine.eg</div>
        </div>
        <div style="text-align: left;">
            <h2 style="margin: 0; color: #D4A017;">عرض سعر رسمي</h2>
            <div style="font-size: 14px; font-weight: bold;">{{ $quote->quote_number }}</div>
            <div style="font-size: 12px; color: #777;">التاريخ: {{ $quote->created_at->format('Y-m-d') }}</div>
        </div>
    </div>

    <div class="quote-box">
        <div>
            <strong>السادة / </strong> {{ $quote->company_name }}<br>
            <strong>عناية السيد / </strong> {{ $quote->customer_name }}<br>
            <strong>الهاتف / </strong> {{ $quote->phone }}
        </div>
        <div>
            <strong>البريد الإلكتروني:</strong> {{ $quote->email }}<br>
            <strong>حالة عرض السعر:</strong> {{ $quote->status }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">م</th>
                <th>اسم المنتج والتوصيف الفني</th>
                <th>كود SKU</th>
                <th style="width: 70px;">الكمية</th>
                <th>سعر الوحدة (ج.م)</th>
                <th>الإجمالي (ج.م)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($quote->items as $index => $item)
                @php
                    $price = $item->unit_price ?? 0;
                    $subtotal = $price * $item->quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->notes)<br><small style="color: #666;">ملاحظات: {{ $item->notes }}</small>@endif
                    </td>
                    <td>{{ $item->sku ?: '—' }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td>{{ number_format($price, 2) }}</td>
                    <td>{{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align: left;">الإجمالي الكلي قبل الضريبة:</td>
                <td>{{ number_format($total, 2) }} ج.م</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-bottom: 30px;">
        <h4 style="margin-bottom: 5px; color: #0A1D37;">الشروط العامة للتوريد:</h4>
        <ul style="font-size: 13px; color: #555; line-height: 1.6; margin: 0; padding-right: 20px;">
            <li>هذا العرض صادر من شركة أليكس مارين وساري لمدة 15 يوماً من تاريخه.</li>
            <li>التسليم بمخازن الشركة أو موقع الميناء حسب الاتفاق.</li>
            <li>الأسعار المعروضة تشمل الفحص والتسليم الأولي المعتمد.</li>
        </ul>
    </div>

    <div style="display: flex; justify-content: space-between; margin-top: 40px;">
        <div style="text-align: center; width: 200px;">
            <strong>توقيع إدارة المبيعات</strong><br><br><br>
            ______________________
        </div>
        <div style="text-align: center; width: 200px;">
            <strong>خاتم الاعتماد والشركة</strong><br><br><br>
            ______________________
        </div>
    </div>

    <div class="footer">
        © ALEX MARINE — جميع الحقوق محفوظة | التوريدات البحرية ومهمات الأمن الصناعي
    </div>

</body>
</html>
