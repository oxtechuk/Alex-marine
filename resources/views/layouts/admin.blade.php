<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة الإدارة والمبيعات — أليكس مارين')</title>
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
            /* Luxury 2-Color Palette */
            --navy-primary: #0A192F;
            --navy-secondary: #0F2744;
            --navy-surface: #162E4E;
            --navy-border: #233554;
            --gold-primary: #D4AF37;
            --gold-hover: #E5C058;
            --gold-soft: rgba(212, 175, 55, 0.12);
            --gold-border: rgba(212, 175, 55, 0.35);
            
            --bg-page: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-dark: #0A192F;
            --text-muted: #64748B;
            --border-light: #E2E8F0;
            --font-primary: 'Tajawal', 'Cairo', sans-serif !important;
        }

        body, button, input, select, textarea, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-primary) !important;
        }

        body {
            background-color: var(--bg-page) !important;
            color: var(--text-dark);
            letter-spacing: -0.2px;
        }

        /* Luxury Color Helpers */
        .bg-navy { background-color: var(--navy-primary) !important; color: #ffffff !important; }
        .bg-navy-secondary { background-color: var(--navy-secondary) !important; }
        .text-navy { color: var(--navy-primary) !important; }
        .text-gold { color: var(--gold-primary) !important; }
        .bg-gold { background-color: var(--gold-primary) !important; color: var(--navy-primary) !important; }
        .bg-gold-soft { background-color: var(--gold-soft) !important; color: #9A7B1C !important; }

        /* Luxury Buttons */
        .btn-gold {
            background: linear-gradient(135deg, #E5C058 0%, #D4AF37 50%, #B89025 100%) !important;
            color: #0A192F !important;
            border: 1px solid var(--gold-primary) !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.25);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #F3D270 0%, #E5C058 50%, #C99E2F 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
            color: #000000 !important;
        }

        .btn-navy {
            background-color: var(--navy-primary) !important;
            color: #ffffff !important;
            border: 1px solid var(--navy-primary) !important;
            font-weight: 700;
            transition: all 0.25s ease;
        }
        .btn-navy:hover {
            background-color: var(--navy-secondary) !important;
            border-color: var(--gold-primary) !important;
            color: var(--gold-primary) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(10, 25, 47, 0.25);
        }

        .btn-outline-navy {
            border: 1.5px solid var(--navy-primary) !important;
            color: var(--navy-primary) !important;
            font-weight: 700;
            background: transparent;
            transition: all 0.2s ease;
        }
        .btn-outline-navy:hover {
            background-color: var(--navy-primary) !important;
            color: #ffffff !important;
        }

        .btn-whatsapp {
            background-color: #25D366 !important;
            color: #ffffff !important;
            border: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-weight: 700;
            border-radius: 50px;
            padding: 0.35rem 0.75rem;
            box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3);
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .btn-whatsapp:hover {
            background-color: #1EBE5D !important;
            color: #ffffff !important;
            transform: translateY(-1px) scale(1.03);
            box-shadow: 0 5px 16px rgba(37, 211, 102, 0.45);
        }

        .btn-whatsapp-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #25D366;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
            text-decoration: none;
        }
        .btn-whatsapp-icon:hover {
            background-color: #1EBE5D;
            color: white;
            transform: scale(1.12);
        }

        /* Luxury Cards */
        .card-custom, .card-luxury {
            border: 1px solid var(--border-light);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(10, 25, 47, 0.03);
            background-color: #ffffff;
            transition: all 0.25s ease;
        }

        /* Luxury Badges */
        .badge-gold {
            background-color: rgba(212, 175, 55, 0.15) !important;
            color: #9A7B1C !important;
            border: 1px solid rgba(212, 175, 55, 0.35);
            font-weight: 700;
        }
        .badge-navy {
            background-color: rgba(10, 25, 47, 0.08) !important;
            color: var(--navy-primary) !important;
            border: 1px solid rgba(10, 25, 47, 0.15);
            font-weight: 700;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #0A192F 0%, #081426 100%);
            color: #ffffff;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: -4px 0 25px rgba(0, 0, 0, 0.25);
            z-index: 100;
        }
        .admin-sidebar .nav-link {
            color: #94A3B8;
            padding: 0.65rem 0.95rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.92rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            border: 1px solid transparent;
        }
        .admin-sidebar .nav-link i {
            font-size: 1.15rem;
            width: 24px;
            color: #94A3B8;
            transition: color 0.2s ease;
        }
        .admin-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }
        .admin-sidebar .nav-link:hover i {
            color: var(--gold-primary);
        }
        .admin-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.04) 100%);
            color: #ffffff !important;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-right: 4px solid var(--gold-primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-weight: 700;
        }
        .admin-sidebar .nav-link.active i {
            color: var(--gold-primary) !important;
        }

        .admin-sidebar-section {
            font-size: 0.68rem;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #64748B;
            font-weight: 800;
            padding: 0.9rem 0.85rem 0.3rem 0.85rem;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }

        /* Top Bar Styling */
        .admin-topbar {
            background-color: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(10, 25, 47, 0.03);
            padding: 0.85rem 1.25rem;
        }

        /* Tables refinement */
        .table-luxury thead th {
            background-color: #F8FAFC !important;
            color: #475569 !important;
            font-weight: 700 !important;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 2px solid var(--border-light) !important;
            padding: 0.9rem 1rem !important;
        }
        .table-luxury tbody td {
            padding: 0.9rem 1rem !important;
            border-bottom: 1px solid var(--border-light);
            font-size: 0.92rem;
            vertical-align: middle;
        }
        .table-luxury tbody tr:hover {
            background-color: #F9FAFB !important;
        }
    </style>
</head>
<body class="bg-light overflow-hidden">

<div class="d-flex vh-100 overflow-hidden">
    @php
        $adminHeaderLogo = \App\Models\Setting::get('site_logo_admin', \App\Models\Setting::get('site_logo_header', ''));
    @endphp

    <!-- Luxury Marine Admin Sidebar -->
    <aside class="admin-sidebar p-3 d-flex flex-column h-100 flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-white text-decoration-none mb-3 pb-3 border-bottom border-secondary border-opacity-25">
            @if(!empty($adminHeaderLogo))
                @php
                    $adminLogoSrc = \Illuminate\Support\Str::startsWith($adminHeaderLogo, ['http://', 'https://']) ? $adminHeaderLogo : asset($adminHeaderLogo);
                @endphp
                <img src="{{ $adminLogoSrc }}" alt="ALEX MARINE" style="max-height: 42px; max-width: 100%; object-fit: contain;" onerror="this.style.display='none'; if(this.nextElementSibling) { this.nextElementSibling.classList.remove('d-none'); this.nextElementSibling.classList.add('d-flex'); }">
                <div class="d-none align-items-center gap-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-gold text-dark" style="width: 38px; height: 38px;">
                        <i class="bi bi-anchor fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6 leading-none">أليكس مارين</div>
                        <small class="text-gold fw-bold fs-8">لوحة الإدارة الفاخرة</small>
                    </div>
                </div>
            @else
                <div class="rounded-3 d-flex align-items-center justify-content-center bg-gold text-dark shadow-sm" style="width: 38px; height: 38px;">
                    <i class="bi bi-anchor fs-5"></i>
                </div>
                <div>
                    <div class="fw-extrabold fs-6 leading-none text-white">أليكس مارين</div>
                    <small class="text-gold fw-bold fs-8">ERP لوحة الإدارة</small>
                </div>
            @endif
        </a>

        <ul class="nav nav-pills flex-column mb-auto overflow-auto pe-1 custom-scrollbar">
            
            <div class="admin-sidebar-section">العمليات والمبيعات</div>
            
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill me-2"></i> الرئيسية
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check-fill me-2"></i> أوامر الشراء والمبيعات
                </a>
            </li>

            <li>
                <a href="{{ route('admin.quotes.index') }}" class="nav-link {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill me-2"></i> عروض الأسعار (RFQ)
                </a>
            </li>

            <li>
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i> دليل العملاء
                </a>
            </li>

            <li>
                <a href="{{ route('admin.branches.index') }}" class="nav-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                    <i class="bi bi-building-fill me-2"></i> الفروع والمخازن
                </a>
            </li>

            <div class="admin-sidebar-section">المنتجات والكتالوج</div>

            <li>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill me-2"></i> المنتجات والمخزون
                </a>
            </li>

            <li>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-2-fill me-2"></i> تصنيفات المنتجات
                </a>
            </li>

            <li>
                <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class="bi bi-tools me-2 text-gold"></i> مشاريع الصيانة
                </a>
            </li>

            <div class="admin-sidebar-section">المظهر والإعدادات</div>

            <li>
                <a href="{{ route('admin.cms.index') }}" class="nav-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders2 me-2"></i> محتوى الهوم بيج
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-palette-fill me-2"></i> الهوية والإعدادات
                </a>
            </li>

            <div class="admin-sidebar-section">عام</div>
            <li>
                <a href="{{ route('home') }}" target="_blank" class="nav-link text-white-50">
                    <i class="bi bi-box-arrow-up-right me-2"></i> زيارة الموقع العام
                </a>
            </li>
        </ul>

        <!-- Sidebar Bottom User Profile -->
        <div class="pt-3 border-top border-secondary border-opacity-25 mt-auto">
            <div class="d-flex align-items-center justify-content-between p-2 rounded-3" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center gap-2 text-truncate">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(212, 175, 55, 0.18); border: 1px solid rgba(212, 175, 55, 0.35);">
                        <i class="bi bi-person-fill fs-5 text-gold"></i>
                    </div>
                    <div class="text-truncate">
                        <div class="fw-bold text-white fs-7 text-truncate" style="line-height: 1.2;">{{ Auth::user()->name }}</div>
                        <small class="text-gold fs-8 fw-semibold d-block">مدير النظام</small>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0 flex-shrink-0">
                    @csrf
                    <button class="btn btn-sm p-1 text-white-50 border-0" style="transition: color 0.2s ease;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='rgba(255,255,255,0.5)'" title="تسجيل الخروج">
                        <i class="bi bi-power fs-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Admin Content Area -->
    <div class="flex-grow-1 p-4 overflow-auto h-100">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-gold-soft p-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-grid-fill text-gold fs-5"></i>
                </div>
                <h4 class="m-0 fw-extrabold text-navy">@yield('page_title', 'لوحة التحكم')</h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-gold rounded-pill px-3">
                    <i class="bi bi-bag-check-fill me-1"></i> أوامر الشراء والمبيعات
                </a>
                <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-navy rounded-pill px-3">
                    <i class="bi bi-file-earmark-text me-1"></i> طلبات RFQ
                </a>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" target="_blank">
                    <i class="bi bi-globe me-1"></i> الموقع
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-2 p-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="fw-bold">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-2 p-3 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div class="fw-bold">{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>
