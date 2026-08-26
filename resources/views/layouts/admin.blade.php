<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم والمبيعات — أليكس مارين')</title>
    <!-- Google Fonts: Tajawal & Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            --navy-primary: #0A1D37;
            --navy-secondary: #0D3B66;
            --marine-blue: #1E6FAE;
            --gold-accent: #E5A919;
            --gold-gradient: linear-gradient(135deg, #FAD961 0%, #F7B731 35%, #D49B23 70%, #B37D14 100%);
            --gold-gradient-hover: linear-gradient(135deg, #FFF0B3 0%, #FCD04B 40%, #E5A315 75%, #C48712 100%);
            --gold-text-gradient: linear-gradient(135deg, #FFF3C4 0%, #FAD961 25%, #E5A919 65%, #C28B15 100%);
            --bg-light: #F2F4F7;
            --text-dark: #333333;
            --font-primary: 'Tajawal', 'Cairo', sans-serif !important;
            --font-main: 'Tajawal', 'Cairo', sans-serif !important;
        }

        body, button, input, select, textarea, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-primary) !important;
        }

        body {
            background-color: var(--bg-light) !important;
            color: var(--text-dark);
        }

        .bg-navy {
            background-color: var(--navy-primary) !important;
        }

        .bg-marine {
            background-color: var(--marine-blue) !important;
        }

        .bg-gold {
            background: var(--gold-gradient) !important;
            color: #061325 !important;
        }

        .btn-gold {
            background: var(--gold-gradient) !important;
            color: #061325 !important;
            border: 1px solid rgba(250, 217, 97, 0.4) !important;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-gold:hover {
            background: var(--gold-gradient-hover) !important;
            color: #000000 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(229, 169, 25, 0.4);
        }

        .text-navy {
            color: var(--navy-primary) !important;
        }

        .text-marine {
            color: var(--marine-blue) !important;
        }

        .text-gold {
            color: var(--gold-accent) !important;
        }

        .text-gold-gradient {
            background: var(--gold-text-gradient) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            font-weight: 800;
        }

        .btn-navy {
            background-color: var(--navy-primary) !important;
            color: #ffffff !important;
            border: 1px solid var(--navy-primary) !important;
            transition: all 0.2s ease;
        }
        .btn-navy:hover {
            background-color: var(--navy-secondary) !important;
            border-color: var(--gold-accent) !important;
            color: #ffffff !important;
        }

        .btn-marine {
            background-color: var(--marine-blue) !important;
            color: #ffffff !important;
            border: 1px solid var(--marine-blue) !important;
            transition: all 0.2s ease;
        }
        .btn-marine:hover {
            background-color: var(--navy-secondary) !important;
            color: #ffffff !important;
        }

        .btn-gold-accent {
            background-color: var(--navy-primary) !important;
            color: #ffffff !important;
            border: 1px solid var(--gold-accent) !important;
            box-shadow: 0 2px 8px rgba(10, 29, 55, 0.15);
        }
        .btn-gold-accent:hover {
            background-color: var(--navy-secondary) !important;
            border-color: var(--gold-accent) !important;
            color: #ffffff !important;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(10, 29, 55, 0.04);
            background-color: #ffffff;
        }

        .admin-sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--navy-primary);
            color: #ffffff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        .admin-sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.65rem 0.95rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.92rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #ffffff;
        }
        .admin-sidebar .nav-link.active {
            background-color: #1E6FAE;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(30, 111, 174, 0.3);
        }
        .admin-sidebar-section {
            font-size: 0.68rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 800;
            padding: 0.8rem 0.85rem 0.25rem 0.85rem;
        }
    </style>
</head>
<body class="bg-light overflow-hidden">

<div class="d-flex vh-100 overflow-hidden">
    @php
        $adminHeaderLogo = \App\Models\Setting::get('site_logo_admin', \App\Models\Setting::get('site_logo_header', ''));
    @endphp

    <!-- Compact Grouped Sidebar -->
    <aside class="admin-sidebar p-3 d-flex flex-column h-100 flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-white text-decoration-none mb-2 pb-2 border-bottom border-secondary border-opacity-25">
            @if(!empty($adminHeaderLogo))
                @php
                    $adminLogoSrc = \Illuminate\Support\Str::startsWith($adminHeaderLogo, ['http://', 'https://']) ? $adminHeaderLogo : asset($adminHeaderLogo);
                @endphp
                <img src="{{ $adminLogoSrc }}" alt="ALEX MARINE" style="max-height: 40px; max-width: 100%; object-fit: contain;" onerror="this.style.display='none'; if(this.nextElementSibling) { this.nextElementSibling.classList.remove('d-none'); this.nextElementSibling.classList.add('d-flex'); }">
                <div class="d-none align-items-center gap-2">
                    <div class="bg-warning text-dark rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #D4A017 !important;">
                        <i class="bi bi-anchor fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6 leading-none">أليكس مارين</div>
                        <small class="text-warning fw-semibold fs-8" style="color: #D4A017 !important;">ERP لوحة الإدارة</small>
                    </div>
                </div>
            @else
                <div class="bg-warning text-dark rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #D4A017 !important;">
                    <i class="bi bi-anchor fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-6 leading-none">أليكس مارين</div>
                    <small class="text-warning fw-semibold fs-8" style="color: #D4A017 !important;">ERP لوحة الإدارة</small>
                </div>
            @endif
        </a>

        <ul class="nav nav-pills flex-column mb-auto overflow-auto pe-1">
            
            <div class="admin-sidebar-section">العمليات والمبيعات</div>
            
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill me-2"></i> الرئيسية
                </a>
            </li>

            <li>
                <a href="{{ route('admin.sales.create') }}" class="nav-link {{ request()->routeIs('admin.sales.create') ? 'active' : '' }}">
                    <i class="bi bi-cart-plus-fill me-2 text-warning"></i> بيع جديد (POS)
                </a>
            </li>

            <li>
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i> العملاء
                </a>
            </li>

            <li>
                <a href="{{ route('admin.quotes.index') }}" class="nav-link {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text me-2"></i> العروض (RFQ)
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check-fill me-2"></i> المبيعات
                </a>
            </li>

            <li>
                <a href="{{ route('admin.branches.index') }}" class="nav-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i> الفروع
                </a>
            </li>

            <div class="admin-sidebar-section">المنتجات والمظهر</div>

            <li>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-2-fill me-2"></i> التصنيفات
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill me-2"></i> المنتجات
                </a>
            </li>

            <li>
                <a href="{{ route('admin.cms.index') }}" class="nav-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders me-2"></i> الهوم بيج
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-palette-fill me-2"></i> الهوية
                </a>
            </li>

            <div class="admin-sidebar-section">عام</div>
            <li>
                <a href="{{ route('home') }}" target="_blank" class="nav-link text-white-50">
                    <i class="bi bi-box-arrow-up-right me-2"></i> الموقع العام
                </a>
            </li>
        </ul>

        <div class="pt-2 border-top border-secondary border-opacity-25 mt-auto">
            <div class="d-flex align-items-center justify-content-between text-white-50">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle fs-6 text-warning"></i>
                    <div>
                        <div class="fw-bold text-white fs-8">{{ Auth::user()->name }}</div>
                        <small class="fs-8 text-muted">الأدمن</small>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-link text-white-50 hover-text-danger p-0 me-1" title="تسجيل الخروج"><i class="bi bi-power fs-6"></i></button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Admin Content Area -->
    <div class="flex-grow-1 p-4 overflow-auto h-100">
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 border shadow-sm">
            <h4 class="m-0 fw-extrabold text-navy">@yield('page_title', 'لوحة التحكم')</h4>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.sales.create') }}" class="btn btn-sm btn-warning rounded-pill fw-bold text-dark px-3" style="background-color: #D4A017; border: none;">
                    <i class="bi bi-cart-plus me-1"></i> بيع جديد POS
                </a>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-sm btn-outline-dark rounded-pill fw-semibold">
                    <i class="bi bi-building me-1"></i> الفروع
                </a>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill fw-bold" target="_blank">
                    <i class="bi bi-globe me-1"></i> الموقع
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>
