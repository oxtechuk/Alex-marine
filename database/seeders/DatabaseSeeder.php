<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\NewsArticle;
use App\Models\Order;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Branches
        $branchAlex = Branch::updateOrCreate(
            ['code' => 'ALX-MAIN'],
            [
                'name_ar' => 'فرع ميناء الإسكندرية الرئيسي',
                'name_en' => 'Alexandria Port Main Branch',
                'city' => 'الإسكندرية',
                'phone' => '+20 120 000 1122',
                'email' => 'alex-main@alexmarine.eg',
                'address' => 'المنطقة الجمركية - ميناء الإسكندرية - رصيف 45',
                'manager_name' => 'م. أحمد فاروق (مدير الفرع الرئيسي)',
                'is_active' => true,
            ]
        );

        $branchSuez = Branch::updateOrCreate(
            ['code' => 'SUZ-PORT'],
            [
                'name_ar' => 'فرع السويس وميناء بورسعيد',
                'name_en' => 'Suez & Port Said Branch',
                'city' => 'السويس / بورسعيد',
                'phone' => '+20 120 000 3344',
                'email' => 'suez-port@alexmarine.eg',
                'address' => 'الميناء الشمالي - منطقة القناة والجمرك',
                'manager_name' => 'قبطان محمود السيد (مدير الفرع البحري)',
                'is_active' => true,
            ]
        );

        // 1. Users
        User::firstOrCreate(
            ['email' => 'admin@alexmarine.com'],
            [
                'name' => 'مدير النظام - أليكس مارين',
                'role' => 'admin',
                'phone' => '+20 120 000 1122',
                'company_name' => 'ALEX MARINE SUPPLIES',
                'address' => 'الإسكندرية - منطقة الميناء البحرية - مصر',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'client@company.com'],
            [
                'name' => 'شركة الملاحة الوطنية',
                'role' => 'customer',
                'phone' => '+20 100 123 4567',
                'company_name' => 'شركة الملاحة والشحن',
                'address' => 'ميناء الإسكندرية - الرصيف 45',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Settings
        Setting::set('site_name_ar', 'أليكس مارين — التوريدات البحرية والأمن الصناعي');
        Setting::set('site_name_en', 'ALEX MARINE — Marine Supplies & Industrial Safety');
        Setting::set('contact_phone', '+20 120 000 1122');
        Setting::set('contact_whatsapp', '+201200001122');
        Setting::set('contact_email', 'info@alexmarine.eg');
        Setting::set('contact_address', 'المنطقة الجمركية - ميناء الإسكندرية، جمهورية مصر العربية');
        Setting::set('about_summary_ar', 'شركة أليكس مارين متخصصة في التوريدات البحرية، معدات السلامة والأمن الصناعي، وصيانة معدات الإطفاء وأجهزة التنفس بأعلى معايير الجودة المعتمدة دولياً.');

        // Brand Logo & Favicon Settings
        Setting::set('site_logo_header', '');
        Setting::set('site_logo_footer', '');
        Setting::set('site_favicon', '');

        // Brand Color Palette Settings
        Setting::set('site_primary_color', '#0A1D37');
        Setting::set('site_secondary_color', '#0D3B66');
        Setting::set('site_accent_color', '#D4A017');
        Setting::set('site_marine_color', '#1E6FAE');

        // Social Media Links Settings
        Setting::set('contact_facebook', 'https://facebook.com');
        Setting::set('contact_instagram', 'https://instagram.com');
        Setting::set('contact_youtube', 'https://youtube.com');
        Setting::set('contact_linkedin', 'https://linkedin.com');

        // Hero & Home CMS Settings (Econ Logistics Style)
        Setting::set('hero_media_type', 'image'); // image, video, youtube
        Setting::set('hero_bg_image', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80');
        Setting::set('hero_bg_video', 'https://assets.mixkit.co/videos/preview/mixkit-cargo-container-ship-in-the-sea-41584-large.mp4');
        Setting::set('hero_youtube_id', '5W_s42HhVLE');
        Setting::set('hero_tagline_en', 'Your trusted premium marine & safety logistics partner with over 20 years of experience');
        Setting::set('hero_title_white_ar', 'مرحباً بكم في شركة');
        Setting::set('hero_title_white_en', 'Welcome to');
        Setting::set('hero_title_highlight_ar', 'أليكس مارين للتوريدات');
        Setting::set('hero_title_highlight_en', 'ALEX MARINE Logistics');
        Setting::set('hero_desc_ar', 'من توريدات مهمات السفن والموانئ إلى صيانة أجهزة التنفس ومعدات الإطفاء، مكرسون للسلامة والدقة والسرعة لأعلى درجات الاعتمادية لكل شركائنا.');
        Setting::set('hero_desc_en', 'From commercial vessel shipping to safety PPE and SCBA maintenance, we are devoted to safety, attentiveness, effectiveness, and speed.');
        Setting::set('hero_cta_text_ar', 'تصفح خدماتنا ومنتجاتنا');
        Setting::set('hero_cta_text_en', 'Discover Our Services');

        // Hero Floating Stats Settings
        Setting::set('hero_stat1_number', '50+');
        Setting::set('hero_stat1_label_ar', 'موانئ وسفن مخدومة');
        Setting::set('hero_stat1_label_en', 'Ports & Vessels Served');
        Setting::set('hero_stat2_number', '2M+');
        Setting::set('hero_stat2_label_ar', 'معدات سلامة موردة');
        Setting::set('hero_stat2_label_en', 'Safety Items Deployed');
        Setting::set('hero_stat3_number', '99%');
        Setting::set('hero_stat3_label_ar', 'نسبة دقة التوريد الفوري');
        Setting::set('hero_stat3_label_en', 'On-Time Port Delivery Rate');

        // Section Active Toggles
        Setting::set('section_hero_active', '1');
        Setting::set('section_fleet_active', '1');
        Setting::set('section_feature_active', '1');
        Setting::set('section_stats_active', '1');
        Setting::set('section_gallery_active', '1');
        Setting::set('section_spotlight_active', '1');
        Setting::set('section_cta_active', '1');

        // 3. Categories
        $catMarine = Category::updateOrCreate(
            ['slug' => 'marine-supplies'],
            [
                'name_ar' => 'التوريدات البحرية',
                'name_en' => 'Marine Supplies',
                'description_ar' => 'معدات ومستلزمات السفن، حبال الربط، المحابس البحرية ومعدات السطح.',
                'icon' => 'bi-anchor',
                'sort_order' => 1,
            ]
        );

        $catSafety = Category::updateOrCreate(
            ['slug' => 'industrial-safety'],
            [
                'name_ar' => 'الأمن الصناعي',
                'name_en' => 'Industrial Safety & PPE',
                'description_ar' => 'مهمات الوقاية الشخصية، الخوذ الأمنية، أحذية السلامة، والقفازات المعتمدة.',
                'icon' => 'bi-shield-check',
                'sort_order' => 2,
            ]
        );

        $catFire = Category::updateOrCreate(
            ['slug' => 'fire-fighting'],
            [
                'name_ar' => 'معدات الإطفاء',
                'name_en' => 'Fire Fighting Equipment',
                'description_ar' => 'طفايات الحريق بمختلف أنواعها، خراطيم الإطفاء، وصناديق الحريق لموقع العمل والسفن.',
                'icon' => 'bi-fire',
                'sort_order' => 3,
            ]
        );

        $catRescue = Category::updateOrCreate(
            ['slug' => 'rescue-life-saving'],
            [
                'name_ar' => 'معدات الإنقاذ والسلامة',
                'name_en' => 'Rescue & Life Saving',
                'description_ar' => 'سترات النجاة البحرية SOLAS، طوق النجاة، ومعدات الطوارئ للمنشآت والمراكب.',
                'icon' => 'bi-life-preserver',
                'sort_order' => 4,
            ]
        );

        $catResp = Category::updateOrCreate(
            ['slug' => 'respiratory-protection'],
            [
                'name_ar' => 'أجهزة التنفس',
                'name_en' => 'Respiratory Protection',
                'description_ar' => 'أجهزة التنفس العازلة الذاتية SCBA، الأقنعة الواقية والفلاتر المخصصة للبيئات الخطرة.',
                'icon' => 'bi-mask',
                'sort_order' => 5,
            ]
        );

        $catSigns = Category::updateOrCreate(
            ['slug' => 'safety-signs'],
            [
                'name_ar' => 'العلامات واللافتات',
                'name_en' => 'Safety Signs & Markings',
                'description_ar' => 'لافتات الإرشاد والتحذير الفوسفورية والمعتمدة لطوارئ السفن والمصانع.',
                'icon' => 'bi-signpost-split',
                'sort_order' => 6,
            ]
        );

        // 4. Products
        // Category 1: Marine Supplies
        Product::updateOrCreate(
            ['slug' => 'compact-single-gas-detector'],
            [
                'category_id' => $catMarine->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'جهاز كاشف الغازات الفردي المدمج - Compact Single Gas Detector',
                'name_en' => 'Compact Single Gas Detector',
                'sku' => 'AM-MAR-000',
                'short_desc_ar' => 'احمِ نفسك وطاقمك باستخدام جهاز كشف الغاز الفردي عالي الدقة — جهاز مدمج ومحمول مصمم للمراقبة المستمرة للغازات الخطرة في البيئات الصناعية والبحرية.',
                'full_desc_ar' => "احمِ نفسك وطاقمك باستخدام جهاز كشف الغاز الفردي عالي الدقة — جهاز مدمج ومحمول مصمم للمراقبة المستمرة للغازات الخطرة في البيئات الصناعية والبحرية. سواء كنت تعمل في الأماكن المغلقة، أو على متن السفن، أو في مواقع البناء، يوفر هذا الكاشف تنبيهات فورية في الوقت الفعلي لمستويات الغازات السامة أو القابلة للاشتعال.\n\nاختر من بين أنواع متعددة من الغازات بما في ذلك كبريتيد الهيدروجين (H2S)، وأول أكسيد الكربون (CO)، والأكسجين (O2)، والغازات القابلة للاشتعال (LEL)، وكل منها معاير لدقة موثوقة واستجابة سريعة.",
                'specifications' => [
                    'نوع المستشعر' => 'Electrochemical / Catalytic Bead (حسب الاختيار)',
                    'عمر البطارية' => 'حتى 18 ساعة تشغيل مستمر',
                    'أنواع الإنذار' => 'إنذار صوتي > 90 dB، تنبيه بصري LED، واهتزاز',
                    'الشاشة' => 'شاشة LCD رقمية خلفية الإضاءة',
                    'درجة الحماية' => 'IP65 / IP67 مقاوم للغبار والماء',
                    'الشهادات والمعايير' => 'ATEX / CE / UL / IECEx',
                    'مجالات الاستخدام' => 'البحرية، النفط والغاز، السلامة الصناعية، الأماكن المغلقة',
                ],
                'gallery' => [
                    'المميزات' => [
                        'أنواع الغازات المتاحة: H2S, CO, O2, LEL (اختر التكوين المناسب)',
                        'مراقبة فورية للغازات باستخدام مستشعرات عالية الحساسية',
                        'إنذار صوتي قوي، تنبيه بالاهتزاز، وتنبيه بصري واميض',
                        'تعديل مدمج وخفيف الوزن لسهولة الحمل الشخصي',
                        'بطارية قابلة للشحن مع تشغيل طويل الأمد',
                        'غلاف متين ومقاوم للماء والغبار معتمد بدرجة حماية IP',
                        'شاشة LCD لقراءة مستويات الغاز وقراءات حالة الإنذار',
                    ],
                ],
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'solas-marine-life-jacket'],
            [
                'category_id' => $catMarine->id,
                'name_ar' => 'سترة نجاة بحرية معتمدة SOLAS Marine Life Jacket',
                'name_en' => 'SOLAS Approved Marine Life Jacket',
                'sku' => 'AM-MAR-001',
                'short_desc_ar' => 'سترة نجاة عالية الاعتمادية مزودة بصفارة إشارة وشريط عاكس وضوء طوارئ تلقائي معتمد دولياً.',
                'full_desc_ar' => "تم تصميم سترة النجاة البحرية طبقاً لمعايير SOLAS الدولية لضمان أقصى درجات طفو الجسم في البحر المفتوح. مصنعة من مواد قماشية مقاومة للمياه المالحة والأشعة فوق البنفسجية.\n\nتتميز السترة بتصميم مريح يضمن طفو الرأس والجسم للأعلى تلقائياً عند حالات الطوارئ في البيئات البحرية القاسية.",
                'specifications' => [
                    'الاعتماد والدعم' => 'SOLAS / MED / CE Approved',
                    'قوة الطفو' => '150-275 نيوتن',
                    'المادة الخارجي' => 'بوليستر عالي الكثافة مقاوم للتآكل والزيوت',
                    'الملحقات المرفقة' => 'صفارة إنقاذ SOLAS + كشاف إشارة ضوئي تلقائي',
                    'الرؤية والسلامة' => 'أشرطة عاكسة للضوء عالية الكثافة 3M',
                    'الاستخدام' => 'السفن التجارية، منصات البترول، قوارب القطر',
                ],
                'gallery' => [
                    'المميزات' => [
                        'تصميم معتمد طبقاً للمتطلبات الدولية IMO / SOLAS',
                        'طفو تلقائي وتعديل سريع لقياس الجسم',
                        'مزودة بكشاف ضوئي يعمل تلقائياً عند ملامسة المياه',
                        'قماش مقاوم للحريق والزيوت والأشعة فوق البنفسجية',
                        'صفارة إنقاذ عالية الصوت متوافقة مع معايير السلامة',
                    ],
                ],
                'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'high-tenacity-mooring-rope'],
            [
                'category_id' => $catMarine->id,
                'name_ar' => 'حبل ربط سفن فائق القوة Mooring Rope',
                'name_en' => 'High Tenacity Marine Mooring Rope',
                'sku' => 'AM-MAR-002',
                'short_desc_ar' => 'حبل ربط ورسو السفن مصنع من البولي بروبلين والبوليستر المقاوم للأحمال الثقيلة.',
                'full_desc_ar' => 'حبال الرسو البحرية المخصصة للموانئ والسفن التجارية والمقطورات. تتميز بمرونة عالية وقدرة ممتازة على امتصاص صدمات الأمواج والرصيف.',
                'specifications' => [
                    'القطر' => '40 مم - 80 مم',
                    'مقاومة القطع' => 'حتى 65 طن',
                    'المادة' => 'Polypropylene / Polyester Composite',
                ],
                'availability_status' => 'متوفر بالتوصيل السريع',
                'is_featured' => true,
            ]
        );

        // Category 2: Industrial Safety
        Product::updateOrCreate(
            ['slug' => 'industrial-ventilated-safety-helmet'],
            [
                'category_id' => $catSafety->id,
                'name_ar' => 'خوذة سلامة صناعية مقواة مع فتحات تهوية',
                'name_en' => 'Industrial Ventilated Safety Helmet',
                'sku' => 'AM-SAF-010',
                'short_desc_ar' => 'خوذة حماية للرأس مقاومة للصدمات العالية ومزودة بحزام تعديل سريع.',
                'full_desc_ar' => 'خوذة سلامة معتمدة طبقاً لمواصفات EN 397 مصممة للعمل في مواقع البناء، المصانع، والموانئ. توفر حماية فائقة ضد الأجسام الساقطة وتوزيع الصدمات.',
                'specifications' => [
                    'المعيار' => 'EN 397:2012',
                    'المادة' => 'ABS High Impact Plastics',
                    'الألوان المتوفرة' => 'أبيض / أصفر / أزرق / أحمر',
                ],
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 's3-steel-toe-safety-boots'],
            [
                'category_id' => $catSafety->id,
                'name_ar' => 'حذاء سلامة صناعي S3 بمقدمة فولاذية',
                'name_en' => 'S3 Steel Toe Safety Boots',
                'sku' => 'AM-SAF-011',
                'short_desc_ar' => 'حذاء سلامة مقاوم للانزلاق والزيوت والثقوب مع حماية متكاملة لأصابع القدم.',
                'full_desc_ar' => 'مصنوع من الجلد الطبيعي المعالج ضد المياه، مزود بنعل مضاد للكهرباء الاستاتيكية ومقاوم للثقب بصلب داخلي.',
                'specifications' => [
                    'درجة الحماية' => 'S3 SRC EN ISO 20345',
                    'المقدمة' => 'فولاذ مقوى يتحمل صدمة 200 جول',
                    'النعل' => 'بولي يوريثان مزدوج الكثافة Dual Density PU',
                ],
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
            ]
        );

        // Category 3: Fire Fighting
        Product::updateOrCreate(
            ['slug' => '6kg-dry-powder-fire-extinguisher'],
            [
                'category_id' => $catFire->id,
                'name_ar' => 'طفاية حريق بودرة كيميائية جافة 6 كجم',
                'name_en' => '6kg Dry Powder Fire Extinguisher',
                'sku' => 'AM-FIR-020',
                'short_desc_ar' => 'طفاية حريق متعددة الأغراض للحرائق من الفئات A, B, C ومزودة بمؤشر ضغط.',
                'full_desc_ar' => 'طفاية حريق معتمدة من هيئة السلامة والصحة المهنية، مناسبة للمصانع، المكاتب، والمرافق البحرية. سهلة الاستخدام ومزودة بصمام أمان نحاسي.',
                'specifications' => [
                    'السعة' => '6 كجم',
                    'نوع المادة' => 'ABC Dry Chemical Powder 50%',
                    'ضغط التشغيل' => '14 بار',
                    'الاعتماد' => 'EN3 / ISO 9001',
                ],
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'heavy-duty-fire-hose'],
            [
                'category_id' => $catFire->id,
                'name_ar' => 'خرطوم إطفاء حرائق مطاطي مع وصلات سريعة',
                'name_en' => 'Heavy Duty Fire Hose with Couplings',
                'sku' => 'AM-FIR-021',
                'short_desc_ar' => 'خرطوم إطفاء نسيجي مغلف بالمطاط لتحمل الضغوط العالية والاحتكاك.',
                'full_desc_ar' => 'خرطوم إطفاء معتمد للسفن والمباني الصناعية، يستوعب ضغط عمل يصل إلى 16 بار وضغط انفجار يصل إلى 48 بار.',
                'specifications' => [
                    'القطر' => '2.5 بوصة (65 مم)',
                    'الطول' => '30 متر',
                    'الوصلات' => 'ألومنيوم Storz / BS Instantaneous',
                ],
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => false,
            ]
        );

        // Category 4: Rescue & Life Saving
        Product::updateOrCreate(
            ['slug' => 'solas-marine-lifebuoy-ring'],
            [
                'category_id' => $catRescue->id,
                'name_ar' => 'طوق نجاة بحري صلب Lifebuoy Ring',
                'name_en' => 'Solas Approved Marine Lifebuoy Ring',
                'sku' => 'AM-RES-030',
                'short_desc_ar' => 'طوق نجاة 2.5 كجم مع شريط عاكس عالي الكثافة وحبل إمساك محيطي.',
                'full_desc_ar' => 'مصنع من البولي إيثيلين المقاوم للصدمات ومحشو برغوة البولي يوريثان المقاومة للمياه والزيوت. يفي بجميع متطلبات المنظمة البحرية الدولية IMO / SOLAS.',
                'specifications' => [
                    'الوزن' => '2.5 كجم / 4.3 كجم',
                    'القطر الخارجي' => '720 مم',
                    'الشهادات' => 'MED / SOLAS',
                ],
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
            ]
        );

        // Category 5: Respiratory Protection
        Product::updateOrCreate(
            ['slug' => 'scba-self-contained-breathing-apparatus'],
            [
                'category_id' => $catResp->id,
                'name_ar' => 'جهاز تنفس عازل للغرق والدخان SCBA 6L',
                'name_en' => 'Self-Contained Breathing Apparatus (SCBA)',
                'sku' => 'AM-RSP-040',
                'short_desc_ar' => 'جهاز تنفس ذاتي مزود بأسطوانة صلب أو كربون وقناع وجه كامل شفاف.',
                'full_desc_ar' => 'جهاز SCBA مخصص لفرق الإطفاء والإنقاذ في الأماكن المغلقة والموانئ والمناطق ذات التركيز العالي للغازات السامة.',
                'specifications' => [
                    'سعة الأسطوانة' => '6 ليتر / 300 بار',
                    'مدة التنفس' => '45 - 60 دقيقة',
                    'القناع' => 'سيليكون كامل مع جلبة ضد التضبب',
                ],
                'availability_status' => 'طلب خاص والتوريد خلال 48 ساعة',
                'is_featured' => true,
            ]
        );

        // Category 6: Safety Signs
        Product::updateOrCreate(
            ['slug' => 'photoluminescent-imo-safety-signs'],
            [
                'category_id' => $catSigns->id,
                'name_ar' => 'لوحات إرشادية فوسفورية لطوارئ السفن SOLAS Signs',
                'name_en' => 'Photoluminescent Safety & IMO Signs',
                'sku' => 'AM-SGN-050',
                'short_desc_ar' => 'علامات سلامة ذاتية الإضاءة في الظلام مقاومة للمياه والعوامل الجوية.',
                'full_desc_ar' => 'مجموعة كاملة من ملصقات ولوحات السلامة المعتمدة IMO لتعليم ممرات الهروب، طوافات النجاة، ومعدات الحريق داخل السفن والمصانع.',
                'specifications' => [
                    'المادة' => 'PVC فوسفوري / ألومنيوم',
                    'زمن الإضاءة' => 'يتجاوز 10 ساعات في الظلام التام',
                    'الطباعة' => 'مقاومة للأشعة فوق البنفسجية والكيماويات',
                ],
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => false,
            ]
        );

        // 5. Services
        Service::updateOrCreate(
            ['slug' => 'fire-equipment-maintenance'],
            [
                'name_ar' => 'صيانة واختبار معدات الإطفاء',
                'name_en' => 'Fire Fighting Equipment Maintenance',
                'short_desc_ar' => 'فحص، إعادة تعبئة، واختبار هيدروستاتيكي لكافة أنواع أجهزة خراطيم وطفايات الحريق.',
                'full_desc_ar' => 'نقدم خدمات الصيانة الدورية والفحص الشامل لأنظمة الإطفاء التلقائية واليدوية في المنشآت والسفن وفقاً لتعليمات الدفاع المدني والمنظمات البحرية.',
                'icon' => 'bi-wrench-adjustable',
                'features' => [
                    'فحص وإعادة تعبئة طفايات البودرة والغاز',
                    'اختبار ضغط الخراطيم والصمامات',
                    'إصدار شهادات صلاحية معتمدة',
                ],
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'scba-service-maintenance'],
            [
                'name_ar' => 'فحص وصيانة أجهزة التنفس SCBA',
                'name_en' => 'SCBA & Breathing Apparatus Service',
                'short_desc_ar' => 'معايرة واختبار تسريب ومراجعة صمامات مخفض الضغط لأسطوانات التنفس.',
                'full_desc_ar' => 'خدمة صيانة متخصصة لأجهزة التنفس الذاتية بما يضمن سلامة المنقذين والعمال في البيئات الخطرة والغازية.',
                'icon' => 'bi-shield-check',
                'features' => [
                    'فحص الأسطوانات هيدروستاتيكياً',
                    'اختبار نظافة الهواء المضغوط',
                    'استبدال الفلاتر والأجزاء التالفة',
                ],
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'marine-rescue-inspection'],
            [
                'name_ar' => 'معايرة وتجهيز معدات الإنقاذ والسلامة البحرية',
                'name_en' => 'Marine Rescue Equipment Inspection',
                'short_desc_ar' => 'تجهيز قوارب وسترات النجاة وحقائب الإسعافات البحرية طبقاً لمعايير SOLAS.',
                'full_desc_ar' => 'مراجعة دورية لسترات وطوافات النجاة ومعدات الإشارة الضوئية للسفن والمراكب التجارية.',
                'icon' => 'bi-life-preserver',
                'features' => [
                    'فحص أجهزة الإشارة الضوئية والصفارات',
                    'اختبار طفو سترات وطوافات النجاة',
                    'شهادة اعتماد للتفتيش البحري',
                ],
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'safety-signage-customization'],
            [
                'name_ar' => 'تصميم وتوريد علامات السلامة والإرشاد',
                'name_en' => 'Safety Signage Customization',
                'short_desc_ar' => 'تصميم وطباعة لوحات السلامة والتحذيرات الفوسفورية حسب مسارات منشأتك.',
                'full_desc_ar' => 'تجهيز كافة لافتات الأمن الصناعي وطوارئ الإخلاء للمصانع والموانئ والمشاريع البحرية.',
                'icon' => 'bi-signpost-split',
                'features' => [
                    'طباعة عالية الدقة مقاومة للظروف الجوية',
                    'مواد فوسفورية ذاتية الإضاءة',
                    'مطابقة لكود السلامة العالمي IMO / OSHA',
                ],
            ]
        );

        // 6. Certificates
        Certificate::firstOrCreate(
            ['certificate_number' => 'EG-9001-2024-AM'],
            [
                'title_ar' => 'شهادة الجودة العالمية ISO 9001:2015',
                'title_en' => 'ISO 9001:2015 Quality Management System',
                'issuing_authority' => 'TÜV NORD',
                'description_ar' => 'اعتماد نظام إدارة الجودة لتوريد وصيانة السلامة البحرية والأمن الصناعي.',
            ]
        );

        Certificate::firstOrCreate(
            ['certificate_number' => 'EAMS-LIC-8894'],
            [
                'title_ar' => 'اعتماد التفتيش البحري للمعدات SOLAS/MED',
                'title_en' => 'SOLAS / MED Marine Inspection License',
                'issuing_authority' => 'Egyptian Authority for Maritime Safety (EAMS)',
                'description_ar' => 'ترخيص رسمي لفحص وتوريد معدات السلامة والإنقاذ للسفن التجارية.',
            ]
        );

        // 7. News Articles
        NewsArticle::firstOrCreate(
            ['slug' => 'new-port-safety-certification'],
            [
                'title_ar' => 'أليكس مارين تحصل على اعتماد جديد لتوريد مهمات السلامة للموانئ',
                'summary_ar' => 'توسيع نطاق خدمات الشركة لتشمل التوريدات البحرية المتكاملة لمشروعات التوسعة بميناء الإسكندرية.',
                'content_ar' => 'أعلنت شركة أليكس مارين عن حصولها على واعتماد جديد من هيئة السلامة البحرية لتوريد وصيانة مهمات السلامة والأمن الصناعي للشركات العاملة بالمنطقة الجمركية.',
                'published_at' => now(),
            ]
        );

        // 8. Demo Quotes & Orders assigned to branches
        $q1 = QuoteRequest::updateOrCreate(
            ['quote_number' => 'RFQ-2026-0101'],
            [
                'branch_id' => $branchAlex->id,
                'customer_name' => 'ربان خالد محمود',
                'company_name' => 'شركة أوراسكوم للشحن البحري',
                'email' => 'k.mahmoud@orascom-marine.com',
                'phone' => '+20 122 333 4455',
                'status' => 'جديد',
                'total_estimated' => 85000,
                'notes' => 'توريد عاجل رصيف 5 ميناء الإسكندرية',
            ]
        );

        $q2 = QuoteRequest::updateOrCreate(
            ['quote_number' => 'RFQ-2026-0102'],
            [
                'branch_id' => $branchSuez->id,
                'customer_name' => 'مهندس طارق العوضي',
                'company_name' => 'شركة السويس لخدمات البترول والغاز',
                'email' => 't.elawady@suez-petroleum.com',
                'phone' => '+20 100 555 6677',
                'status' => 'مقبول',
                'total_estimated' => 142000,
                'notes' => 'تفتيش أجهزة التنفس والسترات بالفرع البحري بالسويس',
            ]
        );

        Order::updateOrCreate(
            ['order_number' => 'ORD-2026-0001'],
            [
                'quote_request_id' => $q2->id,
                'branch_id' => $branchSuez->id,
                'customer_name' => 'مهندس طارق العوضي',
                'company_name' => 'شركة السويس لخدمات البترول والغاز',
                'email' => 't.elawady@suez-petroleum.com',
                'phone' => '+20 100 555 6677',
                'status' => 'مكتمل',
                'total_amount' => 142000,
                'payment_status' => 'تم الدفع',
                'notes' => 'تم التسليم من فرع السويس وبورسعيد',
            ]
        );

        Order::updateOrCreate(
            ['order_number' => 'ORD-2026-0002'],
            [
                'branch_id' => $branchAlex->id,
                'customer_name' => 'شركة النيل الملاحية',
                'company_name' => 'شركة النيل للشحن والموانئ',
                'email' => 'procurement@nileshipping.com',
                'phone' => '+20 120 777 8899',
                'status' => 'قيد التجهيز',
                'total_amount' => 96500,
                'payment_status' => 'آجل / حسب الاتفاق',
                'notes' => 'أمر شراء صادر من فرع الإسكندرية الرئيسي',
            ]
        );
    }
}
