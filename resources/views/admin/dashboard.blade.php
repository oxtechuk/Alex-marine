@extends('layouts.admin')

@section('title', 'لوحة الإدارة والتحليلات الشاملة — أليكس مارين')
@section('page_title', 'لوحة التحكم والتحليلات الشاملة (Dashboard)')

@section('content')

<!-- 1. Interactive Filter Toolbar (Time Period + Branch Filter) -->
<div class="card-luxury p-3 mb-4">
    <form action="{{ route('admin.dashboard') }}" method="GET" id="dashboardFilterForm">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            
            <div class="d-flex align-items-center gap-3 flex-wrap flex-grow-1">
                <!-- Branch Selector -->
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-bold text-navy text-nowrap fs-7"><i class="bi bi-building text-gold me-1"></i> تصفية بالفرع:</label>
                    <select name="branch_id" class="form-select form-select-sm fw-bold border-secondary border-opacity-25" style="min-width: 200px;" onchange="document.getElementById('dashboardFilterForm').submit()">
                        <option value=""> جميع الفروع والمخازن </option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ $selectedBranchId == $b->id ? 'selected' : '' }}>
                                 {{ $b->name_ar }} ({{ $b->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Time Period Selector -->
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-bold text-navy text-nowrap fs-7"><i class="bi bi-calendar-check text-gold me-1"></i> الفترة:</label>
                    <select name="period" class="form-select form-select-sm fw-bold border-secondary border-opacity-25" style="min-width: 160px;" onchange="document.getElementById('dashboardFilterForm').submit()">
                        <option value="all" {{ $selectedPeriod == 'all' ? 'selected' : '' }}>كل الأوقات</option>
                        <option value="today" {{ $selectedPeriod == 'today' ? 'selected' : '' }}> اليوم </option>
                        <option value="this_week" {{ $selectedPeriod == 'this_week' ? 'selected' : '' }}> هذا الأسبوع </option>
                        <option value="this_month" {{ $selectedPeriod == 'this_month' ? 'selected' : '' }}> هذا الشهر</option>
                        <option value="this_year" {{ $selectedPeriod == 'this_year' ? 'selected' : '' }}> هذه السنة </option>
                    </select>
                </div>

                @if($selectedBranchId || ($selectedPeriod && $selectedPeriod != 'all'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm text-nowrap rounded-pill px-3">
                        <i class="bi bi-x-circle me-1"></i> إزالة الفلاتر
                    </a>
                @endif
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-gold btn-sm rounded-pill px-3">
                    <i class="bi bi-bag-check-fill me-1"></i> أوامر الشراء والمبيعات
                </a>
                <a href="{{ route('admin.quotes.index') }}" class="btn btn-navy btn-sm rounded-pill px-3">
                    <i class="bi bi-file-earmark-text me-1"></i> عروض الأسعار (RFQ)
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-navy btn-sm rounded-pill px-3">
                    <i class="bi bi-box-seam me-1"></i> كتالوج المنتجات
                </a>
            </div>

        </div>
    </form>
</div>

@php
    $periodLabels = [
        'all' => 'كل الأوقات',
        'today' => 'اليوم',
        'this_week' => 'هذا الأسبوع',
        'this_month' => 'هذا الشهر',
        'this_year' => 'هذه السنة',
    ];
    $currentPeriodLabel = $periodLabels[$selectedPeriod] ?? 'كل الأوقات';
@endphp

<!-- 2. Primary KPI Stat Cards (Luxury 2-Color Design) -->
<div class="row g-3 mb-4">
    
    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card-luxury p-3 h-100 position-relative overflow-hidden" style="border-right: 4px solid var(--gold-primary);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-8 fw-bold mb-1">إجمالي المبيعات المحققة</div>
                    <div class="h3 fw-extrabold text-navy m-0">{{ number_format($stats['total_revenue']) }} <small class="fs-8 text-muted">جـ.م</small></div>
                    <small class="text-muted fs-8">متوسط الفاتورة: <strong>{{ number_format($stats['avg_order_value']) }} جـ.م</strong></small>
                </div>
                <div class="rounded-4 bg-gold-soft d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-currency-exchange fs-3 text-gold"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Orders -->
    <div class="col-xl-3 col-md-6">
        <div class="card-luxury p-3 h-100 position-relative overflow-hidden" style="border-right: 4px solid var(--navy-primary);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-8 fw-bold mb-1">أوامر الشراء المؤكدة</div>
                    <div class="h3 fw-extrabold text-navy m-0">{{ $stats['total_orders'] }} <small class="fs-8 text-muted">أمر</small></div>
                    <small class="text-muted fs-8">الفترة: <strong>{{ $currentPeriodLabel }}</strong></small>
                </div>
                <div class="rounded-4 bg-navy d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-bag-check-fill fs-3 text-gold"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- RFQ Quotes -->
    <div class="col-xl-3 col-md-6">
        <div class="card-luxury p-3 h-100 position-relative overflow-hidden" style="border-right: 4px solid var(--gold-primary);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-8 fw-bold mb-1">عروض الأسعار (RFQ)</div>
                    <div class="h3 fw-extrabold text-navy m-0">
                        {{ $stats['total_quotes'] }}
                        @if($stats['pending_quotes'] > 0)
                            <span class="fs-8 badge badge-gold rounded-pill ms-1">{{ $stats['pending_quotes'] }} جديد</span>
                        @endif
                    </div>
                    <small class="text-muted fs-8">طلبات مسجلة واردة</small>
                </div>
                <div class="rounded-4 bg-gold-soft d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-file-earmark-text-fill fs-3 text-gold"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers & Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card-luxury p-3 h-100 position-relative overflow-hidden" style="border-right: 4px solid var(--navy-primary);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-8 fw-bold mb-1">العملاء والكتالوج</div>
                    <div class="h3 fw-extrabold text-navy m-0">
                        {{ $stats['total_customers'] }} <small class="fs-8 text-muted">عميل</small> / {{ $stats['total_products'] }} <small class="fs-8 text-muted">صنف</small>
                    </div>
                    <small class="text-muted fs-8">إجمالي قاعدة البيانات</small>
                </div>
                <div class="rounded-4 bg-navy d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-people-fill fs-3 text-gold"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 3. Interactive Charts & Visual Analytics Section -->
<div class="row g-4 mb-4">
    
    <!-- Chart 1: Revenue & Orders Monthly Trend -->
    <div class="col-lg-8">
        <div class="card-luxury p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-graph-up-arrow fs-4 text-gold"></i>
                    <div>
                        <h5 class="fw-extrabold text-navy m-0">حركة الإيرادات الشهرية وأوامر الشراء</h5>
                        <small class="text-muted">تحليل بياني لقيمة المبيعات بالجنيه المصري وعدد الطلبات</small>
                    </div>
                </div>
                <span class="badge badge-navy rounded-pill px-3 py-1.5">مخطط الأداء</span>
            </div>
            <div style="height: 290px; position: relative;">
                <canvas id="revenueOrdersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 2: RFQ Status Breakdown -->
    <div class="col-lg-4">
        <div class="card-luxury p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                <i class="bi bi-pie-chart-fill fs-4 text-gold"></i>
                <div>
                    <h5 class="fw-extrabold text-navy m-0">توزيع حالات طلبات الأسعار</h5>
                    <small class="text-muted">نسب الحالات المسجلة للطلبات</small>
                </div>
            </div>
            <div style="height: 250px; position: relative;" class="d-flex align-items-center justify-content-center">
                <canvas id="quoteStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 3: Branch Revenue Comparison Bar Chart -->
    <div class="col-12">
        <div class="card-luxury p-4">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-line-fill fs-4 text-gold"></i>
                    <div>
                        <h5 class="fw-extrabold text-navy m-0">مقارنة حجم المبيعات بين فروع وموانئ الشركة</h5>
                        <small class="text-muted">مقارنة بصرية شاملة لحجم التوريدات والمبيعات لكل فرع</small>
                    </div>
                </div>
            </div>
            <div style="height: 260px; position: relative;">
                <canvas id="branchRevenueChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- 4. Branch Performance Breakdown Cards -->
<div class="card-luxury p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-building-check fs-4 text-gold"></i>
            <div>
                <h5 class="fw-extrabold text-navy m-0">أداء وتفاصيل الفروع المعتمدة</h5>
                <small class="text-muted">نظرة شاملة على مبيعات وأوامر وطلبات كل فرع</small>
            </div>
        </div>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-sm btn-outline-navy rounded-pill">
            <i class="bi bi-gear-fill me-1"></i> إدارة الفروع
        </a>
    </div>

    <div class="row g-3">
        @foreach($branchComparison as $bc)
            <div class="col-md-6 col-lg-4">
                <div class="p-3 bg-light rounded-4 border h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge badge-navy px-2 py-1 fs-8 rounded-pill mb-1">{{ $bc->code }}</span>
                            <h6 class="fw-bold text-navy m-0">{{ $bc->name_ar }}</h6>
                        </div>
                        <div class="text-end">
                            <span class="fs-8 text-muted d-block">إجمالي المبيعات</span>
                            <span class="fw-extrabold text-navy fs-6">{{ number_format($bc->orders_sum_total_amount ?? 0) }} جـ.م</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top text-muted fs-7">
                        <div><i class="bi bi-bag-check me-1 text-gold"></i> <strong>{{ $bc->orders_count }}</strong> طلبات</div>
                        <div><i class="bi bi-journal-text me-1 text-gold"></i> <strong>{{ $bc->quote_requests_count }}</strong> RFQ</div>
                        <div><i class="bi bi-box-seam me-1 text-navy"></i> <strong>{{ $bc->products_count }}</strong> منتج</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- 5. Recent RFQs & Orders Split Tables with WhatsApp Quick Links -->
<div class="row g-4 mb-4">
    
    <!-- Recent RFQs -->
    <div class="col-lg-6">
        <div class="card-luxury overflow-hidden h-100">
            <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-text-fill text-gold fs-5"></i>
                    <h5 class="fw-bold text-navy m-0 fs-6">أحدث طلبات عروض الأسعار (RFQ)</h5>
                </div>
                <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-navy rounded-pill">عرض الكل</a>
            </div>
            <div class="table-responsive">
                <table class="table table-luxury align-middle m-0 fs-7">
                    <thead>
                        <tr>
                            <th>رقم RFQ</th>
                            <th>العميل / الشركة</th>
                            <th>واتساب</th>
                            <th>الحالة</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentQuotes as $q)
                            @php
                                $waMsg = "مرحباً " . ($q->customer_name ?: 'عزيزنا العميل') . "، بخصوص طلب عرض السعر رقم (" . $q->quote_number . ") لدى أليكس مارين.";
                                $waUrl = \App\Helpers\WhatsAppHelper::link($q->phone, $waMsg);
                            @endphp
                            <tr>
                                <td class="fw-bold text-navy">{{ $q->quote_number }}</td>
                                <td>
                                    <strong class="text-navy d-block">{{ $q->company_name ?: 'عميل مباشر' }}</strong>
                                    <small class="text-muted">{{ $q->customer_name }}</small>
                                </td>
                                <td>
                                    @if(!empty($q->phone))
                                        <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    @else
                                        <span class="text-muted fs-8">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $q->status == 'جديد' ? 'badge-gold' : 'badge-navy' }} rounded-pill">
                                        {{ $q->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.quotes.show', $q->id) }}" class="btn btn-sm btn-navy rounded-pill px-2 py-1 fs-8">
                                        تسعير
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">لا توجد طلبات أسعار جديدة.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Converted Orders -->
    <div class="col-lg-6">
        <div class="card-luxury overflow-hidden h-100">
            <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-bag-check-fill text-gold fs-5"></i>
                    <h5 class="fw-bold text-navy m-0 fs-6">أحدث أوامر الشراء والمبيعات</h5>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-navy rounded-pill">عرض الكل</a>
            </div>
            <div class="table-responsive">
                <table class="table table-luxury align-middle m-0 fs-7">
                    <thead>
                        <tr>
                            <th>رقم الأمر</th>
                            <th>العميل</th>
                            <th>واتساب</th>
                            <th>الإجمالي</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $o)
                            @php
                                $waMsg = "مرحباً " . ($o->customer_name ?: 'عزيزنا العميل') . "، بخصوص أمر الشراء رقم (" . $o->order_number . ") لدى أليكس مارين.";
                                $waUrl = \App\Helpers\WhatsAppHelper::link($o->phone, $waMsg);
                            @endphp
                            <tr>
                                <td class="fw-bold text-navy">{{ $o->order_number }}</td>
                                <td>
                                    <strong class="text-navy d-block">{{ $o->customer_name ?: 'عميل نقدي' }}</strong>
                                    <small class="text-muted">{{ $o->company_name ?: '' }}</small>
                                </td>
                                <td>
                                    @if(!empty($o->phone))
                                        <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    @else
                                        <span class="text-muted fs-8">—</span>
                                    @endif
                                </td>
                                <td class="fw-extrabold text-navy">{{ number_format($o->total_amount, 2) }} جـ.م</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-sm btn-navy rounded-pill px-2 py-1 fs-8">
                                        تفاصيل
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">لا توجد أوامر شراء حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js Scripts Initialization -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // 1. Revenue & Orders Monthly Trend Line Chart (Navy & Gold Theme)
    const ctxRevenue = document.getElementById('revenueOrdersChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: @json($chartMonths),
            datasets: [
                {
                    label: 'الإيرادات (جـ.م)',
                    data: @json($chartRevenue),
                    borderColor: '#D4AF37',
                    backgroundColor: 'rgba(212, 175, 55, 0.15)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#D4AF37',
                    yAxisID: 'y'
                },
                {
                    label: 'عدد الطلبات',
                    data: @json($chartOrdersCount),
                    borderColor: '#0A192F',
                    backgroundColor: 'rgba(10, 25, 47, 0.05)',
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#0A192F',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { family: 'Cairo', size: 12, weight: 'bold' } }
                }
            },
            scales: {
                x: {
                    ticks: { font: { family: 'Cairo', size: 11 } }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: { display: true, text: 'الإيراد (جـ.م)', font: { family: 'Cairo', size: 11 } },
                    ticks: { font: { family: 'Cairo', size: 11 } }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: 'عدد الطلبات', font: { family: 'Cairo', size: 11 } },
                    ticks: { font: { family: 'Cairo', size: 11 } }
                }
            }
        }
    });

    // 2. RFQ Quote Status Breakdown Doughnut Chart
    const ctxQuoteStatus = document.getElementById('quoteStatusChart').getContext('2d');
    const quoteStatusData = @json($quoteStatusStats);
    const quoteLabels = Object.keys(quoteStatusData);
    const quoteCounts = Object.values(quoteStatusData);

    new Chart(ctxQuoteStatus, {
        type: 'doughnut',
        data: {
            labels: quoteLabels.length ? quoteLabels : ['جديد', 'مقبول'],
            datasets: [{
                data: quoteCounts.length ? quoteCounts : [0, 0],
                backgroundColor: [
                    '#D4AF37',
                    '#0A192F',
                    '#162E4E',
                    '#64748B',
                    '#94A3B8'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { family: 'Cairo', size: 11, weight: 'bold' } }
                }
            }
        }
    });

    // 3. Branch Revenue Comparison Bar Chart
    const ctxBranch = document.getElementById('branchRevenueChart').getContext('2d');
    new Chart(ctxBranch, {
        type: 'bar',
        data: {
            labels: @json($chartBranchNames),
            datasets: [{
                label: 'إجمالي مبيعات الفرع (جـ.م)',
                data: @json($chartBranchRevenues),
                backgroundColor: [
                    '#0A192F',
                    '#D4AF37',
                    '#162E4E',
                    '#94A3B8',
                    '#0F2744'
                ],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: { font: { family: 'Cairo', size: 11, weight: 'bold' } }
                },
                y: {
                    ticks: { font: { family: 'Cairo', size: 11 } },
                    title: { display: true, text: 'الإيرادات بالجنية المصري', font: { family: 'Cairo', size: 11 } }
                }
            }
        }
    });

});
</script>

@endsection
