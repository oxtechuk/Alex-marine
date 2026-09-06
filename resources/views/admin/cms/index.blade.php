@extends('layouts.admin')

@section('title', 'لوحة تحكم وإدارة الصفحة الرئيسية CMS — أليكس مارين')
@section('page_title', 'إدارة محتوى وعناصر الصفحة الرئيسية (CMS)')

@section('content')

<form action="{{ route('admin.cms.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        
        <!-- Main Settings Form Column -->
        <div class="col-lg-8">
            
            <!-- Card 1: Hero Section & Media Controls -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-play-btn-fill fs-3 text-warning"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">1. إعدادات الهيرو سكشن الفول سكرين (Media Hero)</h4>
                        <small class="text-muted">التحكم في الخلفية (رفع صورة / رفع فيديو MP4 / يوتيوب) والنصوص البارزة</small>
                    </div>
                </div>

                <!-- Media Type Selection -->
                <div class="mb-4 p-3 bg-light rounded-3 border">
                    <label class="form-label fw-bold text-navy">نوع خلفية الميديا للهيرو سكشن <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4 flex-wrap mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hero_media_type" id="mediaImage" value="image" {{ ($settings['hero_media_type'] ?? 'image') == 'image' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="mediaImage">
                                <i class="bi bi-image me-1 text-primary"></i> صورة عالي الوضوح (Image)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hero_media_type" id="mediaVideo" value="video" {{ ($settings['hero_media_type'] ?? '') == 'video' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="mediaVideo">
                                <i class="bi bi-film me-1 text-success"></i> فيديو MP4 مباشر (Video)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hero_media_type" id="mediaYoutube" value="youtube" {{ ($settings['hero_media_type'] ?? '') == 'youtube' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="mediaYoutube">
                                <i class="bi bi-youtube me-1 text-danger"></i> فيديو يوتيوب Embed (YouTube)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Header Logo Upload -->
                <div class="p-3 bg-light rounded-3 border mb-4">
                    <label class="form-label fw-bold text-navy">
                        <i class="bi bi-shield-shaded text-warning me-1"></i> شعار الهيدر للموقع (Header Logo)
                    </label>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            @php
                                $curHdrLogo = $settings['site_logo_header'] ?? '';
                            @endphp
                            @if(!empty($curHdrLogo))
                                <div class="p-2 bg-dark rounded border text-center">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($curHdrLogo, ['http://', 'https://']) ? $curHdrLogo : asset($curHdrLogo) }}"
                                         alt="Header Logo Preview"
                                         style="max-height: 48px; max-width: 100%; object-fit: contain;">
                                </div>
                            @else
                                <div class="p-2 bg-white rounded border text-center text-muted fs-8">
                                    لا يوجد لوجو مخصص — سيتم استخدام النص الافتراضي
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-8 text-muted fw-semibold">رفع لوجو جديد من جهازك (SVG, PNG, JPG, WebP):</label>
                            <input type="file" name="site_logo_header_file" class="form-control form-control-sm" accept="image/*,.svg">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-8 text-muted">أو مسار / رابط اللوجو المباشر:</label>
                            <input type="text" name="site_logo_header" class="form-control form-control-sm" value="{{ $settings['site_logo_header'] ?? '' }}" placeholder="/uploads/Alex-marin.svg">
                        </div>
                    </div>
                </div>

                <!-- Media Uploads & URLs -->
                <div class="row g-3 mb-4">
                    <!-- Hero Background Image Upload -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="form-label fw-bold text-navy"><i class="bi bi-image text-primary me-1"></i> صورة الخلفية للهيرو</label>
                            @if(!empty($settings['hero_bg_image']))
                                <div class="mb-2 p-1 bg-white rounded border text-center">
                                    @php
                                        $imgPrev = \Illuminate\Support\Str::startsWith($settings['hero_bg_image'], ['http://', 'https://']) ? $settings['hero_bg_image'] : asset($settings['hero_bg_image']);
                                    @endphp
                                    <img src="{{ $imgPrev }}" alt="Hero Preview" style="max-height: 70px; width: 100%; object-fit: cover;" class="rounded">
                                </div>
                            @endif
                            <div class="mb-2">
                                <label class="form-label fs-7 text-muted fw-semibold">رفع صورة جديدة من جهازك مباشرة:</label>
                                <input type="file" name="hero_bg_image_file" class="form-control form-control-sm" accept="image/*">
                            </div>
                            <div>
                                <label class="form-label fs-7 text-muted">أو وضع رابط صورة مباشر (URL):</label>
                                <input type="text" name="hero_bg_image" class="form-control form-control-sm" value="{{ $settings['hero_bg_image'] ?? '' }}" placeholder="https://images.unsplash.com/...">
                            </div>
                        </div>
                    </div>

                    <!-- Hero Background Video MP4 Upload -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <label class="form-label fw-bold text-navy"><i class="bi bi-film text-success me-1"></i> فيديو MP4 الخلفية المباشر</label>
                            @if(!empty($settings['hero_bg_video']))
                                <div class="mb-2 p-1 bg-white rounded border text-center fs-8 text-truncate">
                                    <i class="bi bi-file-earmark-play-fill text-success me-1"></i> {{ $settings['hero_bg_video'] }}
                                </div>
                            @endif
                            <div class="mb-2">
                                <label class="form-label fs-7 text-muted fw-semibold">رفع ملف فيديو MP4 من جهازك:</label>
                                <input type="file" name="hero_bg_video_file" class="form-control form-control-sm" accept="video/mp4,video/*">
                            </div>
                            <div>
                                <label class="form-label fs-7 text-muted">أو رابط فيديو مباشر (URL):</label>
                                <input type="text" name="hero_bg_video" class="form-control form-control-sm" value="{{ $settings['hero_bg_video'] ?? '' }}" placeholder="https://domain.com/video.mp4">
                            </div>
                        </div>
                    </div>

                    <!-- YouTube Video ID -->
                    <div class="col-md-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <label class="form-label fw-bold text-navy"><i class="bi bi-youtube text-danger me-1"></i> معرف فيديو يوتيوب (YouTube Video ID)</label>
                            <input type="text" name="hero_youtube_id" class="form-control form-control-sm" value="{{ $settings['hero_youtube_id'] ?? '' }}" placeholder="مثال: 5W_s42HhVLE (الحروف والقطع الأخيرة بعد v= في رابط يوتيوب)">
                        </div>
                    </div>
                </div>

                <!-- Titles & Subtitles -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">التاغ الفرعي العلوي (عربي)</label>
                        <input type="text" name="hero_tagline_ar" class="form-control" value="{{ $settings['hero_tagline_ar'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Top Tagline (English)</label>
                        <input type="text" name="hero_tagline_en" class="form-control" value="{{ $settings['hero_tagline_en'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان الأبيض (عربي)</label>
                        <input type="text" name="hero_title_white_ar" class="form-control" value="{{ $settings['hero_title_white_ar'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Title White Part (English)</label>
                        <input type="text" name="hero_title_white_en" class="form-control" value="{{ $settings['hero_title_white_en'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-warning">الكلمة المظللة بالذهبي (عربي)</label>
                        <input type="text" name="hero_title_highlight_ar" class="form-control border-warning" value="{{ $settings['hero_title_highlight_ar'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-warning">Gold Highlight Keyword (English)</label>
                        <input type="text" name="hero_title_highlight_en" class="form-control border-warning" value="{{ $settings['hero_title_highlight_en'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">الوصف العربي</label>
                        <textarea name="hero_desc_ar" class="form-control" rows="3">{{ $settings['hero_desc_ar'] ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Description (English)</label>
                        <textarea name="hero_desc_en" class="form-control" rows="3">{{ $settings['hero_desc_en'] ?? '' }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">نص زر الدعوة للإجراء (عربي)</label>
                        <input type="text" name="hero_cta_text_ar" class="form-control" value="{{ $settings['hero_cta_text_ar'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">CTA Button Text (English)</label>
                        <input type="text" name="hero_cta_text_en" class="form-control" value="{{ $settings['hero_cta_text_en'] ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Card 2: Floating Stats Bar Controls -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-bar-chart-line-fill fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">2. إحصائيات الشريط السفلي المثبت (Floating Bottom Stats)</h4>
                        <small class="text-muted">التحكم في القيم العريضة والتسميات المصاحبة</small>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Stat 1 -->
                    <div class="col-md-4 p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold">القيمة 1 (مثل 50+)</label>
                        <input type="text" name="hero_stat1_number" class="form-control fw-bold text-navy mb-2" value="{{ $settings['hero_stat1_number'] ?? '50+' }}">
                        <input type="text" name="hero_stat1_label_ar" class="form-control form-control-sm mb-1" placeholder="الوصف بالعربي" value="{{ $settings['hero_stat1_label_ar'] ?? '' }}">
                        <input type="text" name="hero_stat1_label_en" class="form-control form-control-sm" placeholder="EN Label" value="{{ $settings['hero_stat1_label_en'] ?? '' }}">
                    </div>

                    <!-- Stat 2 -->
                    <div class="col-md-4 p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold">القيمة 2 (مثل 2M+)</label>
                        <input type="text" name="hero_stat2_number" class="form-control fw-bold text-navy mb-2" value="{{ $settings['hero_stat2_number'] ?? '2M+' }}">
                        <input type="text" name="hero_stat2_label_ar" class="form-control form-control-sm mb-1" placeholder="الوصف بالعربي" value="{{ $settings['hero_stat2_label_ar'] ?? '' }}">
                        <input type="text" name="hero_stat2_label_en" class="form-control form-control-sm" placeholder="EN Label" value="{{ $settings['hero_stat2_label_en'] ?? '' }}">
                    </div>

                    <!-- Stat 3 -->
                    <div class="col-md-4 p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold">القيمة 3 (مثل 99%)</label>
                        <input type="text" name="hero_stat3_number" class="form-control fw-bold text-navy mb-2" value="{{ $settings['hero_stat3_number'] ?? '99%' }}">
                        <input type="text" name="hero_stat3_label_ar" class="form-control form-control-sm mb-1" placeholder="الوصف بالعربي" value="{{ $settings['hero_stat3_label_ar'] ?? '' }}">
                        <input type="text" name="hero_stat3_label_en" class="form-control form-control-sm" placeholder="EN Label" value="{{ $settings['hero_stat3_label_en'] ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Card 3: About Us & Featured Departments Section -->
            <div class="alex-card p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-building fs-3 text-warning"></i>
                    <div>
                        <h4 class="fw-bold text-navy m-0">3. سكشن (من نحن وأقسامنا - About & Departments)</h4>
                        <small class="text-muted">التحكم في لوجو وصورة السكشن، العناوين، واختيار كروت الأقسام وصور الكافر الخاصة بها</small>
                    </div>
                </div>

                {{-- Section Logo / Image Upload --}}
                <div class="p-3 bg-light rounded-3 border mb-4">
                    <label class="form-label fw-bold text-navy">
                        <i class="bi bi-image text-primary me-1"></i> صورة اللوجو أو الصورة الخاصة بهذا السكشن
                    </label>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            @php
                                $curAboutLogo = $settings['about_section_image'] ?? ($settings['site_logo_header'] ?? '');
                            @endphp
                            @if(!empty($curAboutLogo))
                                <div class="p-2 bg-white rounded border text-center">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($curAboutLogo, ['http://', 'https://']) ? $curAboutLogo : asset($curAboutLogo) }}"
                                         alt="About Logo Preview"
                                         style="max-height: 50px; max-width: 100%; object-fit: contain;">
                                </div>
                            @else
                                <div class="p-2 bg-white rounded border text-center text-muted fs-8">
                                    سيتم استخدام اللوجو الافتراضي للموقع
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-8 text-muted fw-semibold">رفع صورة من جهازك:</label>
                            <input type="file" name="about_section_image_file" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-8 text-muted">أو رابط صورة مباشر (URL):</label>
                            <input type="text" name="about_section_image" class="form-control form-control-sm" value="{{ $settings['about_section_image'] ?? '' }}" placeholder="https://...">
                        </div>
                    </div>
                </div>

                {{-- About Texts --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold fs-7">التاغ الفرعي (عربي)</label>
                        <input type="text" name="about_tagline_ar" class="form-control form-control-sm" value="{{ $settings['about_tagline_ar'] ?? 'من نحن وأقسامنا' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold fs-7">Tagline (English)</label>
                        <input type="text" name="about_tagline_en" class="form-control form-control-sm" value="{{ $settings['about_tagline_en'] ?? 'About Us & Expertise' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold fs-7">العنوان الرئيسي (عربي)</label>
                        <input type="text" name="about_title_ar" class="form-control form-control-sm" value="{{ $settings['about_title_ar'] ?? 'شركة أليكس مارين للتوريدات البحرية والأمن الصناعي' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold fs-7">Main Title (English)</label>
                        <input type="text" name="about_title_en" class="form-control form-control-sm" value="{{ $settings['about_title_en'] ?? 'ALEX MARINE — Leading Marine & Safety Supplies' }}">
                    </div>

                
                </div>

                {{-- Category Cover Images & Selection --}}
                <div class="border-top pt-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="fw-bold text-navy m-0">اختيار كروت الأقسام المعروضة وتعيين صور الكافر</h5>
                            <small class="text-muted">اختر الأقسام التي تود ظهورها في هذا السكشن (يُفضل اختيار 4 أقسام) مع تحديد صورة الكافر لكل قسم</small>
                        </div>
                    </div>

                    @php
                        $selectedFeatCatIds = !empty($settings['feature_category_ids']) ? explode(',', $settings['feature_category_ids']) : [1,2,3,4];
                    @endphp

                    <div class="row g-3">
                        @foreach($categories as $cat)
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 {{ in_array($cat->id, $selectedFeatCatIds) ? 'border-primary' : '' }}">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="feature_category_ids[]"
                                               value="{{ $cat->id }}"
                                               id="feat_cat_{{ $cat->id }}"
                                               {{ in_array($cat->id, $selectedFeatCatIds) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold text-dark" for="feat_cat_{{ $cat->id }}">
                                            {{ $cat->name_ar }} ({{ $cat->name_en }})
                                        </label>
                                    </div>
                                    <span class="badge bg-secondary fs-8">{{ $cat->slug }}</span>
                                </div>

                                {{-- Cover Image preview and inputs --}}
                                <div class="d-flex gap-2 align-items-center mt-2">
                                    @if(!empty($cat->image))
                                        <img src="{{ \Illuminate\Support\Str::startsWith($cat->image, ['http://', 'https://']) ? $cat->image : asset($cat->image) }}"
                                             alt="{{ $cat->name_ar }}"
                                             style="width: 48px; height: 48px; object-fit: cover;"
                                             class="rounded border flex-shrink-0">
                                    @else
                                        <div class="rounded border bg-white d-flex align-items-center justify-content-center flex-shrink-0 text-muted"
                                             style="width: 48px; height: 48px; font-size: 0.75rem;">
                                            افتراضي
                                        </div>
                                    @endif

                                    <div class="flex-grow-1">
                                        <input type="file"
                                               name="category_image_files[{{ $cat->id }}]"
                                               class="form-control form-control-sm mb-1"
                                               accept="image/*">
                                        <input type="text"
                                               name="category_images[{{ $cat->id }}]"
                                               class="form-control form-control-sm"
                                               placeholder="أو رابط صورة URL"
                                               value="{{ $cat->image }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar: Section Visibility Toggles & Actions -->
        <div class="col-lg-4">
            
            <!-- Save Settings Floating Sticky Button -->
            <div class="alex-card p-4 mb-4 bg-navy text-white text-center shadow-lg sticky-top" style="top: 20px; background-color: #0A1D37 !important;">
                <i class="bi bi-cloud-arrow-up-fill display-4 text-warning mb-2 d-block"></i>
                <h4 class="fw-bold mb-2">حفظ تغييرات CMS</h4>
                <p class="text-white-50 fs-7 mb-3">سيتم تطبيق جميع التعديلات فوراً على الصفحة الرئيسية لجميع الزوار.</p>
                <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-3 text-dark" style="background-color: #D4A017; border: none;">
                    <i class="bi bi-check-circle-fill me-2"></i> حفظ الإعدادات الآن
                </button>
            </div>

            <!-- Card 3: Section Active Toggles (Show/Hide) -->
            <div class="alex-card p-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-3">
                    <i class="bi bi-toggle-on fs-3 text-success"></i>
                    <div>
                        <h5 class="fw-bold text-navy m-0">إظهار / إخفاء الأقسام (Section Toggles)</h5>
                        <small class="text-muted">التحكم في ظهور أي سكشن بالهوم بيج</small>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    
                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_hero_active" value="1" id="secHero" {{ ($settings['section_hero_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secHero">
                            <i class="bi bi-display me-1 text-primary"></i> 1. الهيرو سكشن الفول سكرين
                        </label>
                    </div>

                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_fleet_active" value="1" id="secFleet" {{ ($settings['section_fleet_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secFleet">
                            <i class="bi bi-grid-3x3-gap me-1 text-info"></i> 2. كتالوج وسكينات أسطول المعدات
                        </label>
                    </div>

                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_feature_active" value="1" id="secFeature" {{ ($settings['section_feature_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secFeature">
                            <i class="bi bi-shield-check me-1 text-success"></i> 3. سكشن كيف نعمل والقيم المضافة
                        </label>
                    </div>

                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_stats_active" value="1" id="secStats" {{ ($settings['section_stats_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secStats">
                            <i class="bi bi-speedometer2 me-1 text-warning"></i> 4. شريط الأرقام والإحصائيات
                        </label>
                    </div>

                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_gallery_active" value="1" id="secGallery" {{ ($settings['section_gallery_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secGallery">
                            <i class="bi bi-images me-1 text-secondary"></i> 5. معرض التجهيزات والتفتيش البحري
                        </label>
                    </div>

                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_spotlight_active" value="1" id="secSpotlight" {{ ($settings['section_spotlight_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secSpotlight">
                            <i class="bi bi-star me-1 text-danger"></i> 6. المنتجات المعتمدة المختارة
                        </label>
                    </div>

                    <div class="form-check form-switch p-3 bg-light rounded-3">
                        <input class="form-check-input me-0 ms-2" type="checkbox" name="section_cta_active" value="1" id="secCta" {{ ($settings['section_cta_active'] ?? '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="secCta">
                            <i class="bi bi-chat-square-text me-1 text-dark"></i> 7. بنر LETS TALK للتواصل
                        </label>
                    </div>

                </div>
            </div>

        </div>

    </div>
</form>

@endsection
