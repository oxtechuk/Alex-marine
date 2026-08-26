@extends('layouts.admin')

@section('title', 'لوحة الإدارة والإحصائيات الشاملة ERP — أليكس مارين')
@section('page_title', 'لوحة التحكم والتحليلات والتقارير الشاملة')

@section('content')

<!-- 1. Interactive Filter Toolbar (Time Period + Branch Filter) -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form action="{{ route('admin.dashboard') }}" method="GET" id="dashboardFilterForm">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            
            <div class="d-flex align-items-center gap-3 flex-wrap flex-grow-1">
                <!-- Branch Selector -->
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-bold text-navy text-nowrap fs-7"><i class="bi bi-building text-warning me-1"></i> تصفية الإحصائيات بالفرع:</label>
                    <select name="branch_id" class="form-select form-select-sm fw-semibold border-2 border-primary" style="min-width: 220px;" onchange="document.getElementById('dashboardFilterForm').submit()">
                        <option value=""> جميع الفروع </option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ $selectedBranchId == $b->id ? 'selected' : '' }}>
                                 {{ $b->name_ar }} ({{ $b->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Time Period Selector -->
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-bold text-navy text-nowrap fs-7"><i class="bi bi-calendar-event text-primary me-1"></i> الفترة الزمنية:</label>
                    <select name="period" class="form-select form-select-sm fw-semibold border-2 border-info" style="min-width: 170px;" onchange="document.getElementById('dashboardFilterForm').submit()">
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
                <a href="{{ route('admin.sales.create') }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark" style="background-color: #D4A017; border: none;">
                    <i class="bi bi-cart-plus-fill me-1"></i> بيع جديد (POS)
                </a>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-navy btn-sm rounded-pill px-3 fw-bold text-white" style="background-color: #0A1D37;">
                    <i class="bi bi-building me-1"></i> الفروع
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                    <i class="bi bi-box-seam me-1"></i> إضافة منتج
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

<!-- 2. Primary KPI Stat Cards -->
<div class="row g-3 mb-4">
    
    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-5 border-success h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-7 fw-bold mb-1">إجمالي المبيعات والتحصيل</div>
                    <div class="h3 fw-extrabold text-navy m-0" style="color: #0A1D37 !important;">{{ number_format($stats['total_revenue']) }} <small class="fs-7 text-muted">جـ.م</small></div>
                    <small class="text-muted fs-8">الفترة: <strong>{{ $currentPeriodLabel }}</strong> | متوسط الطلب: <strong>{{ number_format($stats['avg_order_value']) }} جـ.م</strong></small>
                </div>
                <div class="bg-success-subtle text-success rounded-4 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-cash-stack fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Orders -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-5 border-primary h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-7 fw-bold mb-1">أوامر الشراء (Orders)</div>
                    <div class="h3 fw-extrabold text-primary m-0">{{ $stats['total_orders'] }}</div>
                    <small class="text-muted fs-8">أوامر مؤكدة ومكتملة ({{ $currentPeriodLabel }})</small>
                </div>
                <div class="bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-bag-check-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- RFQ Quotes -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-5 border-warning h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-7 fw-bold mb-1">طلبات الأسعار (RFQ)</div>
                    <div class="h3 fw-extrabold text-warning m-0" style="color: #D4A017 !important;">
                        {{ $stats['total_quotes'] }}
                        @if($stats['pending_quotes'] > 0)
                            <span class="fs-7 badge bg-danger text-white rounded-pill ms-1">{{ $stats['pending_quotes'] }} جديد</span>
                        @endif
                    </div>
                    <small class="text-muted fs-8">عروض أسعار واردة ({{ $currentPeriodLabel }})</small>
                </div>
                <div class="bg-warning-subtle text-warning rounded-4 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-journal-text fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers & Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-5 border-info h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted fs-7 fw-bold mb-1">العملاء والمنتجات المتاحة</div>
                    <div class="h3 fw-extrabold text-info m-0">
                        {{ $stats['total_customers'] }} <small class="fs-7 text-dark fw-normal">عميل</small>
                        / {{ $stats['total_products'] }} <small class="fs-7 text-dark fw-normal">منتج</small>
                    </div>
                    <small class="text-muted fs-8">إجمالي العملاء: <strong>{{ $stats['total_all_customers'] ?? $stats['total_customers'] }}</strong> ({{ $stats['total_customers'] }} {{ $currentPeriodLabel }})</small>
                </div>
                <div class="bg-info-subtle text-info rounded-4 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 3. Interactive Charts & Visual Analytics Section (Chart.js) -->
<div class="row g-4 mb-4">
    
    <!-- Chart 1: Revenue & Orders Monthly Trend -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div>
                    <h5 class="fw-extrabold text-navy m-0"><i class="bi bi-graph-up-arrow text-success me-2"></i> حركة الإيرادات وأوامر الشراء الشهري</h5>
                    <small class="text-muted">تحليل خطي للإيرادات بالجنيه المصري وعدد الطلبات</small>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">تحليلات المبيعات</span>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="revenueOrdersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 2: RFQ Status Breakdown -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div>
                    <h5 class="fw-extrabold text-navy m-0"><i class="bi bi-pie-chart-fill text-warning me-2"></i> توزيع حالات طلبات الأسعار</h5>
                    <small class="text-muted">نسب الحالات المسجلة لعروض الأسعار</small>
                </div>
            </div>
            <div style="height: 260px; position: relative;" class="d-flex align-items-center justify-content-center">
                <canvas id="quoteStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 3: Branch Revenue Comparison Bar Chart -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                <div>
                    <h5 class="fw-extrabold text-navy m-0"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i> مقارنة حجم المبيعات بين جميع فروع الشركة</h5>
                    <small class="text-muted">مقارنة بصرية شاملة بين الموانئ والفروع البحرية</small>
                </div>
            </div>
            <div style="height: 280px; position: relative;">
                <canvas id="branchRevenueChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- 4. Branch Performance Breakdown Cards -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
        <div>
            <h5 class="fw-extrabold text-navy m-0"><i class="bi bi-diagram-3-fill text-warning me-2"></i> أداء ومقارنة مبيعات الفروع المعتمدة</h5>
            <small class="text-muted">نظرة تفصيلية على الإيرادات وطلبات كل فرع منفصل</small>
        </div>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-sm btn-outline-dark rounded-pill fw-semibold">
            <i class="bi bi-gear-fill me-1"></i> إعدادات الفروع
        </a>
    </div>

    <div class="row g-3">
        @foreach($branchComparison as $bc)
            <div class="col-md-6 col-lg-4">
                <div class="p-3 bg-light rounded-4 border h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge bg-navy text-white px-2 py-1 fs-8 rounded-pill mb-1" style="background-color: #0A1D37;">{{ $bc->code }}</span>
                            <h6 class="fw-bold text-navy m-0">{{ $bc->name_ar }}</h6>
                        </div>
                        <div class="text-end">
                            <span class="fs-8 text-muted d-block">إجمالي المبيعات</span>
                            <span class="fw-extrabold text-success fs-6">{{ number_format($bc->orders_sum_total_amount ?? 0) }} جـ.م</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top text-muted fs-7">
                        <div><i class="bi bi-bag-check me-1 text-primary"></i> <strong>{{ $bc->orders_count }}</strong> طلبات</div>
                        <div><i class="bi bi-journal-text me-1 text-warning"></i> <strong>{{ $bc->quote_requests_count }}</strong> RFQ</div>
                        <div><i class="bi bi-box-seam me-1 text-info"></i> <strong>{{ $bc->products_count }}</strong> منتج</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- 5. Recent RFQs & Orders Split Tables -->
<div class="row g-4 mb-4">
    
    <!-- Recent RFQs -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-navy m-0 fs-6"><i class="bi bi-file-earmark-text text-warning me-2"></i> أحدث طلبات الأسعار (RFQ)</h5>
                <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle m-0 fs-7">
                        <thead class="table-light">
                            <tr>
                                <th>رقم RFQ</th>
                                <th>العميل / الشركة</th>
                                <th>الفرع</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentQuotes as $q)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $q->quote_number }}</td>
                                    <td>
                                        <div class="fw-bold text-navy">{{ $q->company_name }}</div>
                                        <small class="text-muted">{{ $q->customer_name }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-dark border px-2 py-1 fs-8">
                                            {{ $q->branch ? $q->branch->name_ar : 'الفرع الرئيسي' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $q->status == 'جديد' ? 'bg-warning text-dark' : 'bg-success' }} rounded-pill">
                                            {{ $q->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.quotes.show', $q->id) }}" class="btn btn-xs btn-primary rounded-pill px-2 py-1 fs-8">
                                            معاينة
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">لا توجد طلبات أسعار جديدة.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Converted Orders -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-navy m-0 fs-6"><i class="bi bi-bag-check-fill text-success me-2"></i> أحدث أوامر الشراء (Orders)</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-success rounded-pill">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle m-0 fs-7">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الأمر</th>
                                <th>العميل / الشركة</th>
                                <th>الفرع</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $o)
                                <tr>
                                    <td class="fw-bold text-success">{{ $o->order_number }}</td>
                                    <td>
                                        <div class="fw-bold text-navy">{{ $o->company_name }}</div>
                                        <small class="text-muted">{{ $o->customer_name }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-dark border px-2 py-1 fs-8">
                                            {{ $o->branch ? $o->branch->name_ar : 'الفرع الرئيسي' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-navy">{{ number_format($o->total_amount) }} جـ.م</td>
                                    <td>
                                        <span class="badge bg-success rounded-pill">
                                            {{ $o->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">لا توجد أوامر شراء حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js Scripts Initialization -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // 1. Revenue & Orders Monthly Trend Line Chart
    const ctxRevenue = document.getElementById('revenueOrdersChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: @json($chartMonths),
            datasets: [
                {
                    label: 'الإيرادات (جـ.م)',
                    data: @json($chartRevenue),
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.15)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#0d9488',
                    yAxisID: 'y'
                },
                {
                    label: 'عدد الطلبات',
                    data: @json($chartOrdersCount),
                    borderColor: '#0A1D37',
                    backgroundColor: 'rgba(10, 29, 55, 0.05)',
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#0A1D37',
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
                    '#f59e0b',
                    '#10b981',
                    '#06b6d4',
                    '#ef4444',
                    '#6b7280'
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
                    '#0A1D37',
                    '#1E6FAE',
                    '#D4A017',
                    '#0d9488',
                    '#6366f1'
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
