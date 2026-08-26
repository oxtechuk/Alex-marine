@extends('layouts.admin')

@section('title', 'إعدادات الهُوية والشعار للأدمن — أليكس مارين')
@section('page_title', 'إعدادات الهُوية، الشعار، الألوان وشبكات التواصل')

@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        
        <div class="col-lg-8">
            
            <!-- Card 1: Brand Logo & Favicon Upload -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-image-fill fs-3 text-warning"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">1. رفع شعار الموقع وأيقونة المتصفح (Logo & Favicon)</h4>
                        <small class="text-muted">قم برفع صورة اللوجو مباشرة من جهازك أو ضع رابط الصورة المباشر</small>
                    </div>
                </div>

                <div class="row g-4">
                    
                    <!-- Header Logo -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="form-label fw-bold text-navy">لوجو الهيدر للموقع (Header Logo)</label>
                            
                            @if(!empty($settings['site_logo_header']))
                                <div class="mb-2 p-2 bg-white rounded border text-center">
                                    @php
                                        $hdrImg = \Illuminate\Support\Str::startsWith($settings['site_logo_header'], ['http://', 'https://']) ? $settings['site_logo_header'] : asset($settings['site_logo_header']);
                                    @endphp
                                    <img src="{{ $hdrImg }}" alt="Header Logo Preview" style="max-height: 50px; object-fit: contain;">
                                </div>
                            @endif

                            <div class="mb-2">
                                <label class="form-label fs-7 text-muted fw-semibold">رفع ملف صورة جديدة من الجهاز:</label>
                                <input type="file" name="site_logo_header_file" class="form-control form-control-sm" accept="image/*">
                            </div>

                            <div>
                                <label class="form-label fs-7 text-muted">أو رابط الصورة المباشر (URL):</label>
                                <input type="text" name="site_logo_header" class="form-control form-control-sm" value="{{ $settings['site_logo_header'] ?? '' }}" placeholder="https://domain.com/logo.png">
                            </div>
                        </div>
                    </div>

                    <!-- Admin Panel Logo -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="form-label fw-bold text-warning"><i class="bi bi-shield-lock-fill me-1"></i> لوجو لوحة التحكم الأدمن (Admin Panel Logo)</label>

                            @if(!empty($settings['site_logo_admin']))
                                <div class="mb-2 p-2 bg-dark rounded border text-center">
                                    @php
                                        $admImg = \Illuminate\Support\Str::startsWith($settings['site_logo_admin'], ['http://', 'https://']) ? $settings['site_logo_admin'] : asset($settings['site_logo_admin']);
                                    @endphp
                                    <img src="{{ $admImg }}" alt="Admin Logo Preview" style="max-height: 50px; object-fit: contain;">
                                </div>
                            @endif

                            <div class="mb-2">
                                <label class="form-label fs-7 text-muted fw-semibold">رفع ملف صورة خاصة للأدمن من الجهاز:</label>
                                <input type="file" name="site_logo_admin_file" class="form-control form-control-sm" accept="image/*">
                            </div>

                            <div>
                                <label class="form-label fs-7 text-muted">أو رابط الصورة المباشر (URL):</label>
                                <input type="text" name="site_logo_admin" class="form-control form-control-sm" value="{{ $settings['site_logo_admin'] ?? '' }}" placeholder="https://domain.com/admin-logo.png">
                            </div>
                        </div>
                    </div>

                    <!-- Footer Logo -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="form-label fw-bold text-navy">لوجو الفوتر (Footer Logo)</label>

                            @if(!empty($settings['site_logo_footer']))
                                <div class="mb-2 p-2 bg-dark rounded border text-center">
                                    @php
                                        $ftrImg = \Illuminate\Support\Str::startsWith($settings['site_logo_footer'], ['http://', 'https://']) ? $settings['site_logo_footer'] : asset($settings['site_logo_footer']);
                                    @endphp
                                    <img src="{{ $ftrImg }}" alt="Footer Logo Preview" style="max-height: 50px; object-fit: contain;">
                                </div>
                            @endif

                            <div class="mb-2">
                                <label class="form-label fs-7 text-muted">رفع ملف صورة جديدة من الجهاز:</label>
                                <input type="file" name="site_logo_footer_file" class="form-control form-control-sm" accept="image/*">
                            </div>

                            <div>
                                <label class="form-label fs-7 text-muted">أو رابط الصورة المباشر (URL):</label>
                                <input type="text" name="site_logo_footer" class="form-control form-control-sm" value="{{ $settings['site_logo_footer'] ?? '' }}" placeholder="https://domain.com/footer-logo.png">
                            </div>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="form-label fw-bold text-navy">أيقونة المتصفح (Favicon)</label>

                            @if(!empty($settings['site_favicon']))
                                <div class="mb-2 p-2 bg-white rounded border text-center">
                                    @php
                                        $favImg = \Illuminate\Support\Str::startsWith($settings['site_favicon'], ['http://', 'https://']) ? $settings['site_favicon'] : asset($settings['site_favicon']);
                                    @endphp
                                    <img src="{{ $favImg }}" alt="Favicon Preview" style="max-height: 32px; object-fit: contain;">
                                </div>
                            @endif

                            <div class="mb-2">
                                <label class="form-label fs-7 text-muted">رفع ملف Favicon من الجهاز:</label>
                                <input type="file" name="site_favicon_file" class="form-control form-control-sm" accept="image/*,.ico">
                            </div>

                            <div>
                                <label class="form-label fs-7 text-muted">أو رابط الأيقونة (URL):</label>
                                <input type="text" name="site_favicon" class="form-control form-control-sm" value="{{ $settings['site_favicon'] ?? '' }}" placeholder="https://domain.com/favicon.ico">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Card 2: Brand Color Palette (Color Pickers) -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-paint-bucket fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">2. لوحة ألوان الهُوية (Brand Color Palette)</h4>
                        <small class="text-muted">تغير الألوان الرئيسية والفرعية ومحيط الموقع فورياً</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">اللون الكحلي الرئيسي (Primary Navy)</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ $settings['site_primary_color'] ?? '#0A1D37' }}" id="colorPrim" onchange="document.getElementById('textPrim').value = this.value">
                            <input type="text" name="site_primary_color" id="textPrim" class="form-control" value="{{ $settings['site_primary_color'] ?? '#0A1D37' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">اللون الكحلي الثانوي (Secondary Navy)</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ $settings['site_secondary_color'] ?? '#0D3B66' }}" id="colorSec" onchange="document.getElementById('textSec').value = this.value">
                            <input type="text" name="site_secondary_color" id="textSec" class="form-control" value="{{ $settings['site_secondary_color'] ?? '#0D3B66' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-warning">اللون الذهبي المميز (Accent Gold)</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ $settings['site_accent_color'] ?? '#D4A017' }}" id="colorGold" onchange="document.getElementById('textGold').value = this.value">
                            <input type="text" name="site_accent_color" id="textGold" class="form-control border-warning" value="{{ $settings['site_accent_color'] ?? '#D4A017' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-info">اللون الأزرق البحري (Marine Blue)</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ $settings['site_marine_color'] ?? '#1E6FAE' }}" id="colorMarine" onchange="document.getElementById('textMarine').value = this.value">
                            <input type="text" name="site_marine_color" id="textMarine" class="form-control border-info" value="{{ $settings['site_marine_color'] ?? '#1E6FAE' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Social Media Links -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-share-fill fs-3 text-info"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">3. روابط شبكات التواصل الاجتماعي (Social Media Links)</h4>
                        <small class="text-muted">يتم تحديث جميع الأيقونات في أعلى الهيدر والفوتر تلقائياً</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-facebook text-primary me-1"></i> رابط فيسبوك (Facebook URL)</label>
                        <input type="text" name="contact_facebook" class="form-control" value="{{ $settings['contact_facebook'] ?? 'https://facebook.com' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-instagram text-danger me-1"></i> رابط انستجرام (Instagram URL)</label>
                        <input type="text" name="contact_instagram" class="form-control" value="{{ $settings['contact_instagram'] ?? 'https://instagram.com' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-whatsapp text-success me-1"></i> رقم الواتساب (WhatsApp Number / Link)</label>
                        <input type="text" name="contact_whatsapp" class="form-control" value="{{ $settings['contact_whatsapp'] ?? '+201200001122' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-youtube text-danger me-1"></i> رابط قناة اليوتيوب (YouTube Channel)</label>
                        <input type="text" name="contact_youtube" class="form-control" value="{{ $settings['contact_youtube'] ?? 'https://youtube.com' }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold"><i class="bi bi-linkedin text-primary me-1"></i> رابط لينكد إن (LinkedIn URL)</label>
                        <input type="text" name="contact_linkedin" class="form-control" value="{{ $settings['contact_linkedin'] ?? 'https://linkedin.com' }}">
                    </div>
                </div>
            </div>

            <!-- Card 4: Contact Info -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-telephone-inbound-fill fs-3 text-success"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">4. بيانات الاتصال والعناوين الرسمية</h4>
                        <small class="text-muted">تظهر في أعلى الشريط ورأس الهيدر والفوتر</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم الهاتف الرسمي</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '+20 120 000 1122' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">البريد الإلكتروني الرسمي</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'info@alexmarine.eg' }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">العنوان التفصيلي (المنطقة والميناء)</label>
                        <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? '' }}">
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar Save Action Card -->
        <div class="col-lg-4">
            <div class="alex-card p-4 bg-navy text-white text-center shadow-lg sticky-top" style="top: 20px; background-color: #0A1D37 !important;">
                <i class="bi bi-palette2 display-4 text-warning mb-2 d-block"></i>
                <h4 class="fw-bold mb-2">حفظ إعدادات الهُوية</h4>
                <p class="text-white-50 fs-7 mb-3">سيتم تطبيق الشعار، الألوان، وروابط التواصل الاجتماعي فوراً على الهيدر والفوتر والموقع بالكامل.</p>
                <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-3 text-dark" style="background-color: #D4A017; border: none;">
                    <i class="bi bi-check-circle-fill me-2"></i> حفظ الإعدادات الآن
                </button>
            </div>
        </div>

    </div>
</form>

@endsection
