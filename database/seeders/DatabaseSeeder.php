<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\NewsArticle;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\QuoteItem;
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
        // ════════════════════════════════════════════
        // 0. BRANCHES & MARITIME FACILITIES
        // ════════════════════════════════════════════
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

        $branchDamietta = Branch::updateOrCreate(
            ['code' => 'DMT-LOG'],
            [
                'name_ar' => 'فرع ومستودعات ميناء دمياط',
                'name_en' => 'Damietta Port Supply Hub',
                'city' => 'دمياط',
                'phone' => '+20 120 000 5566',
                'email' => 'damietta@alexmarine.eg',
                'address' => 'ميناء دمياط البحري - مجمع المستودعات والخدمات اللوجستية',
                'manager_name' => 'م. حسام البحيري',
                'is_active' => true,
            ]
        );

        // ════════════════════════════════════════════
        // 1. USERS & ROLES
        // ════════════════════════════════════════════
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@alexmarine.com'],
            [
                'name' => 'مدير النظام - أليكس مارين',
                'role' => 'admin',
                'phone' => '+20 120 000 1122',
                'company_name' => 'ALEX MARINE SUPPLIES & LOGISTICS',
                'address' => 'المنطقة الجمركية - ميناء الإسكندرية - مصر',
                'password' => Hash::make('password'),
            ]
        );

        $clientUser1 = User::updateOrCreate(
            ['email' => 'client@nationalmarine.com'],
            [
                'name' => 'قبطان محمد الشناوي',
                'role' => 'customer',
                'phone' => '+20 100 123 4567',
                'company_name' => 'شركة الملاحة الوطنية (National Marine Shipping)',
                'address' => 'مبنى التوكيلات الملاحية - ميناء الإسكندرية',
                'password' => Hash::make('password'),
            ]
        );

        $clientUser2 = User::updateOrCreate(
            ['email' => 'procurement@redseashipping.com'],
            [
                'name' => 'م. طارق العوضي',
                'role' => 'customer',
                'phone' => '+20 100 555 6677',
                'company_name' => 'شركة البحر الأحمر للخدمات البترولية والبحرية',
                'address' => 'بورتوفيق - السويس - مصر',
                'password' => Hash::make('password'),
            ]
        );

        // ════════════════════════════════════════════
        // 2. SETTINGS & CMS CONFIGURATION
        // ════════════════════════════════════════════
        Setting::set('site_name_ar', 'أليكس مارين — التوريدات البحرية والأمن الصناعي');
        Setting::set('site_name_en', 'ALEX MARINE — Marine Supplies & Industrial Safety');
        Setting::set('contact_phone', '+20 120 000 1122');
        Setting::set('contact_whatsapp', '+201200001122');
        Setting::set('contact_email', 'info@alexmarine.eg');
        Setting::set('contact_address', 'المنطقة الجمركية - ميناء الإسكندرية، جمهورية مصر العربية');
        Setting::set('about_summary_ar', 'شركة أليكس مارين متخصصة في التوريدات البحرية، مهمات الأمن الصناعي والسلامة المهنية، وصيانة معدات الإطفاء وأجهزة التنفس بأعلى معايير الجودة المعتمدة دولياً.');
        Setting::set('about_summary_en', 'ALEX MARINE is a leading Egyptian enterprise delivering integrated marine supplies, industrial PPE, and certified firefighting & SCBA maintenance services.');

        // Brand Color Palette
        Setting::set('site_primary_color', '#0A192F');
        Setting::set('site_secondary_color', '#102A45');
        Setting::set('site_accent_color', '#D4AF37');
        Setting::set('site_marine_color', '#1E6FAE');

        // Social Channels
        Setting::set('contact_facebook', 'https://facebook.com/alexmarine.eg');
        Setting::set('contact_instagram', 'https://instagram.com/alexmarine.eg');
        Setting::set('contact_youtube', 'https://youtube.com/@alexmarine');
        Setting::set('contact_linkedin', 'https://linkedin.com/company/alexmarine-eg');

        // Hero & Home CMS
        Setting::set('hero_media_type', 'image');
        Setting::set('hero_bg_image', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80');
        Setting::set('hero_bg_video', 'https://assets.mixkit.co/videos/preview/mixkit-cargo-container-ship-in-the-sea-41584-large.mp4');
        Setting::set('hero_youtube_id', '5W_s42HhVLE');
        Setting::set('hero_tagline_ar', 'شريكك الاستراتيجي الأول للتوريدات والخدمات البحرية في الموانئ المصرية والبحر المتوسط');
        Setting::set('hero_tagline_en', 'Your premier certified marine supplies & technical safety logistics partner across Egyptian ports');
        Setting::set('hero_title_white_ar', 'مرحباً بكم في شركة');
        Setting::set('hero_title_white_en', 'Welcome to');
        Setting::set('hero_title_highlight_ar', 'أليكس مارين للتوريدات البحرية');
        Setting::set('hero_title_highlight_en', 'ALEX MARINE Supplies & Safety');
        Setting::set('hero_desc_ar', 'من توريدات مهمات السفن التجارية ومهمات الوقاية الشخصية إلى صيانة أنظمة الإطفاء المركزية وأجهزة التنفس المعتمدة، نلتزم بأعلى معايير الدقة والسرعة والتسليم الفوري.');
        Setting::set('hero_desc_en', 'From commercial vessel chandlery and PPE safety supplies to certified CO2 fire suppression and SCBA breathing apparatus overhauls — committed to precision, compliance, and swift delivery.');
        Setting::set('hero_cta_text_ar', 'تصفح دليل المنتجات والتوريدات');
        Setting::set('hero_cta_text_en', 'Explore Products & Supplies');

        // Hero Floating Stats
        Setting::set('hero_stat1_number', '120+');
        Setting::set('hero_stat1_label_ar', 'سفينة وميناء مخدوم سنوياً');
        Setting::set('hero_stat1_label_en', 'Vessels & Ports Served');
        Setting::set('hero_stat2_number', '2.5M+');
        Setting::set('hero_stat2_label_ar', 'معدة سلامة وتوريد بحري');
        Setting::set('hero_stat2_label_en', 'Safety & Marine Items Deployed');
        Setting::set('hero_stat3_number', '99.8%');
        Setting::set('hero_stat3_label_ar', 'دقة التوريد والامتثال لمعايير SOLAS');
        Setting::set('hero_stat3_label_en', 'On-Time SOLAS Compliance');

        // Section Active Toggles
        Setting::set('section_hero_active', '1');
        Setting::set('section_fleet_active', '1');
        Setting::set('section_feature_active', '1');
        Setting::set('section_stats_active', '1');
        Setting::set('section_gallery_active', '1');
        Setting::set('section_spotlight_active', '1');
        Setting::set('section_cta_active', '1');

        // ════════════════════════════════════════════
        // 3. PRODUCT CATEGORIES (6 CORE SECTORS)
        // ════════════════════════════════════════════
        $catMarine = Category::updateOrCreate(
            ['slug' => 'marine-supplies'],
            [
                'name_ar' => 'التوريدات البحرية',
                'name_en' => 'Marine Supplies',
                'description_ar' => 'معدات ومستلزمات السفن، حبال الربط، المحابس البحرية ومعدات السطح.',
                'icon' => 'bi-anchor',
                'sort_order' => 1,
                'is_active' => true,
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
                'is_active' => true,
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
                'is_active' => true,
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
                'is_active' => true,
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
                'is_active' => true,
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
                'is_active' => true,
            ]
        );

        // Feature category setting
        Setting::set('feature_category_ids', implode(',', [$catMarine->id, $catSafety->id, $catFire->id, $catRescue->id]));

        // ════════════════════════════════════════════
        // 4. REALISTIC PRODUCTS CATALOG WITH HIGH-RES IMAGES
        // ════════════════════════════════════════════

        // Category 1: Marine Supplies
        Product::updateOrCreate(
            ['slug' => 'compact-single-gas-detector'],
            [
                'category_id' => $catMarine->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'جهاز كاشف الغازات الفردي المدمج Compact Single Gas Detector',
                'name_en' => 'Compact Single Gas Detector (H2S, CO, O2, LEL)',
                'sku' => 'AM-MAR-001',
                'price' => 8500,
                'cost_price' => 5200,
                'short_desc_ar' => 'كاشف غازات رقمي محمول وعالي الدقة للمراقبة المستمرة في غرف المحركات والأماكن المغلقة بالسفن.',
                'full_desc_ar' => "احمِ طاقم سفينتك باستخدام جهاز كشف الغازات الفردي عالي الدقة المدمج. مصمم للعمل في أصعب البيئات البحرية ومقاوم للمياه والأتربة.\n\nيوفر إنذارات صوتية وضوئية واهتزازية فورية عند استشعار نسب خطرة من الغازات السامة كبريتيد الهيدروجين (H2S) أو أول أكسيد الكربون (CO) أو نقص الأكسجين (O2).",
                'specifications' => [
                    'Sensor Type' => 'Electrochemical / Catalytic Bead Sensor',
                    'Battery Life' => 'Up to 24 hours continuous runtime',
                    'Alarm Types' => 'Audible 95dB, Visual Flash LED, Vibration',
                    'Protection Class' => 'IP67 Waterproof & Dustproof',
                    'Certification' => 'ATEX / CE / IECEx / SOLAS Compliant',
                ],
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'solas-marine-life-jacket'],
            [
                'category_id' => $catMarine->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'سترة نجاة بحرية معتمدة دولياً SOLAS Marine Life Jacket',
                'name_en' => 'SOLAS Certified Marine Life Jacket 150N',
                'sku' => 'AM-MAR-002',
                'price' => 1850,
                'cost_price' => 1100,
                'short_desc_ar' => 'سترة نجاة عالية الطفو مزودة بصفارة إشارة وشريط عاكس 3M وكشاف طوارئ مائي تلقائي.',
                'full_desc_ar' => 'مصممة خصيصاً طبقاً لمعايير IMO / SOLAS لضمان إبقاء رأس مرتديها فوق الماء حتى في حالات فقدان الوعي. مصنعة من أقمشة بوليستر متينة مقاومة للملوحة والزيوت.',
                'specifications' => [
                    'Buoyancy' => '150N - 275N',
                    'Approval' => 'SOLAS / MED Wheelmark Approved',
                    'Accessories' => 'SOLAS Whistle + Automatic Strobe Light',
                    'Reflective Tape' => '3M SOLAS Grade Retro-reflective Strips',
                ],
                'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'high-tenacity-mooring-rope'],
            [
                'category_id' => $catMarine->id,
                'branch_id' => $branchSuez->id,
                'name_ar' => 'حبل ربط سفن فائق القوة 8 جدائل Mooring Rope',
                'name_en' => '8-Strand Polypropylene Mooring Rope (50mm)',
                'sku' => 'AM-MAR-003',
                'price' => 12500,
                'cost_price' => 8200,
                'short_desc_ar' => 'حبال رسو وربط للسفن التجارية وناقلات البضائع مصنعة من البولي بروبلين المقاوم للصدمات والشد العالي.',
                'full_desc_ar' => 'حبال رسو مخصصة للموانئ وأرصفة الشحن. تتميز بمرونة استثنائية، خفة وزن تطفو على الماء، ومقاومة فائقة للتآكل الكيميائي والاحتكاك بالأرصفة.',
                'specifications' => [
                    'Diameter' => '48mm - 64mm',
                    'Breaking Load' => 'Up to 550 kN (56 Tons)',
                    'Length' => '220 Meters Coil',
                    'Material' => '100% High Tenacity Polypropylene',
                ],
                'image' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر بالتوصيل الفوري',
                'is_featured' => false,
                'is_active' => true,
            ]
        );

        // Category 2: Industrial Safety & PPE
        Product::updateOrCreate(
            ['slug' => 'industrial-ventilated-safety-helmet'],
            [
                'category_id' => $catSafety->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'خوذة سلامة صناعية مقواة مع فتحات تهوية EN 397',
                'name_en' => 'Industrial Ventilated Safety Helmet (EN 397)',
                'sku' => 'AM-SAF-010',
                'price' => 380,
                'cost_price' => 210,
                'short_desc_ar' => 'خوذة حماية للرأس مقاومة للصدمات والكهرباء الاستاتيكية مع نظام تعليق داخلي سداسي النقاط.',
                'full_desc_ar' => 'خوذة أمان معتمدة أوروبياً لمواقع البناء، الترسانات البحرية، والمصانع البتروكيماوية. توفر أقصى راحة مع توزيع متساوي لقوة الصدمات.',
                'specifications' => [
                    'Standard' => 'EN 397:2012 / ANSI Z89.1',
                    'Material' => 'High Impact UV-Stabilized ABS',
                    'Harness' => '6-point textile suspension with ratchet wheel',
                    'Colors' => 'White, Yellow, Blue, Red, Hi-Vis Orange',
                ],
                'image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 's3-steel-toe-safety-boots'],
            [
                'category_id' => $catSafety->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'حذاء سلامة صناعي S3 SRC بمقدمة فولاذية عازلة',
                'name_en' => 'S3 SRC Steel Toe Leather Safety Boots',
                'sku' => 'AM-SAF-011',
                'price' => 1450,
                'cost_price' => 900,
                'short_desc_ar' => 'حذاء سلامة من الجلد الطبيعي المقاوم للماء والزيوت ومزود ببطانة صلب لمنع الثقب والانزلاق.',
                'full_desc_ar' => 'حذاء مهني للأمن الصناعي يوفر حماية متكاملة ضد الصدمات الحادة، المواد الكيميائية، والأسطح الزلقة في موانئ الشحن وورش الصيانة.',
                'specifications' => [
                    'Rating' => 'S3 SRC EN ISO 20345:2011',
                    'Toe Cap' => 'Impact Resistant Steel (200 Joules)',
                    'Midsole' => 'Puncture Resistant Steel Plate (1100N)',
                    'Sole' => 'Dual Density Polyurethane (Oil & Acid Resistant)',
                ],
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'chemical-resistant-heavy-duty-gloves'],
            [
                'category_id' => $catSafety->id,
                'branch_id' => $branchDamietta->id,
                'name_ar' => 'قفازات نيتريل كيميائية مقواة مقاومة للأحماض والزيوت',
                'name_en' => 'Heavy Duty Chemical & Acid Resistant Nitrile Gloves',
                'sku' => 'AM-SAF-012',
                'price' => 220,
                'cost_price' => 130,
                'short_desc_ar' => 'قفازات حماية اليدين من الكيماويات والمذيبات البترولية للعمل بالموانئ والمصانع.',
                'full_desc_ar' => 'قفازات بطول 38 سم توفر حماية ممتدة للساعد، مبطنة بقطن مريح ومصممة بنقش خشن على راحة اليد لثبات الإمساك في البيئات المبتلة والزيتية.',
                'specifications' => [
                    'Standards' => 'EN 388 (4101X) / EN ISO 374-1 Type A',
                    'Thickness' => '0.55 mm',
                    'Length' => '380 mm Gauntlet',
                ],
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => false,
                'is_active' => true,
            ]
        );

        // Category 3: Fire Fighting Equipment
        Product::updateOrCreate(
            ['slug' => '6kg-dry-powder-fire-extinguisher'],
            [
                'category_id' => $catFire->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'طفاية حريق بودرة كيميائية جافة 6 كجم ABC معتمدة',
                'name_en' => '6kg ABC Dry Chemical Powder Fire Extinguisher',
                'sku' => 'AM-FIR-020',
                'price' => 1650,
                'cost_price' => 980,
                'short_desc_ar' => 'طفاية حريق بودرة متعددة الأغراض لحرائق الفئات A و B و C ومزودة بمانومتر لقياس الضغط.',
                'full_desc_ar' => 'طفاية حريق معتمدة مطابقة للمواصفات القياسية المصرية والأوروبية EN3. مناسبة للاستخدام في السفن، الورش، المخازن، والمباني الإدارية.',
                'specifications' => [
                    'Capacity' => '6 kg ABC 50% Powder',
                    'Working Pressure' => '14 - 15 Bar',
                    'Discharge Time' => '14 - 18 Seconds',
                    'Approvals' => 'EN 3 / ISO 9001 / Civil Defense Approved',
                ],
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'heavy-duty-fire-hose'],
            [
                'category_id' => $catFire->id,
                'branch_id' => $branchSuez->id,
                'name_ar' => 'خرطوم إطفاء حرائق مطاطي 2.5 بوصة مع وصلات سريعة Storz',
                'name_en' => 'Heavy Duty 2.5" Marine Rubber Fire Hose (30m)',
                'sku' => 'AM-FIR-021',
                'price' => 3200,
                'cost_price' => 2100,
                'short_desc_ar' => 'خرطوم إطفاء نسيجي مغلف بالمطاط لتحمل الضغوط العالية والاحتكاك على أسطح السفن.',
                'full_desc_ar' => 'خرطوم إطفاء بحري معتمد يتحمل ضغط تشغيل 16 بار وضغط انفجار 48 بار، مقاوم للأشعة فوق البنفسجية ومياه البحر والحرارة العالية.',
                'specifications' => [
                    'Diameter' => '2.5 inch (65 mm)',
                    'Length' => '30 Meters',
                    'Working Pressure' => '16 Bar (Burst: 48 Bar)',
                    'Couplings' => 'Lightweight Aluminum Storz / BS 336',
                ],
                'image' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // Category 4: Rescue & Life Saving
        Product::updateOrCreate(
            ['slug' => 'solas-marine-lifebuoy-ring'],
            [
                'category_id' => $catRescue->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'طوق نجاة بحري صلب 4.3 كجم SOLAS Lifebuoy Ring',
                'name_en' => 'SOLAS 4.3kg Polyethylene Marine Lifebuoy Ring',
                'sku' => 'AM-RES-030',
                'price' => 1950,
                'cost_price' => 1200,
                'short_desc_ar' => 'طوق نجاة بحري برتقالي صلب مع شريط عاكس 3M وحبل إمساك محيطي معتمد من هيئة السلامة البحرية.',
                'full_desc_ar' => 'مصنوع من البولي إيثيلين المقاوم للصدمات ومحشو برغوة البولي يوريثان عالية الكثافة المقاومة للمياه والزيوت. يفي بكافة شروط IMO / SOLAS للسفن التجارية ومنصات الحفر.',
                'specifications' => [
                    'Weight' => '4.3 kg (Also available in 2.5 kg)',
                    'Outer Diameter' => '720 mm (Inner: 440 mm)',
                    'Buoyancy' => '> 145 N',
                    'Certifications' => 'SOLAS 74/96, MED Wheelmark, IMO LSA Code',
                ],
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // Category 5: Respiratory Protection
        Product::updateOrCreate(
            ['slug' => 'scba-self-contained-breathing-apparatus'],
            [
                'category_id' => $catResp->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'جهاز تنفس عازل ذاتي SCBA 6.8L كربون فايبر 300 بار',
                'name_en' => 'Self-Contained Breathing Apparatus (SCBA 6.8L / 300 Bar)',
                'sku' => 'AM-RSP-040',
                'price' => 38000,
                'cost_price' => 26000,
                'short_desc_ar' => 'جهاز تنفس عازل معتمد للأماكن المغلقة وحرائق السفن بأسطوانة كربون فايبر خفيفة الوزن وقناع كامل الرؤية.',
                'full_desc_ar' => 'الجهاز الأساسي لفرق الإطفاء والإنقاذ في الأماكن المغلقة وغرف المحركات بالسفن ومواقع تسرب الغازات السامة. يوفر هواء تنفس نقي لمدة 45-60 دقيقة.',
                'specifications' => [
                    'Cylinder' => '6.8 Liter Carbon-Composite (300 Bar)',
                    'Duration' => '45 - 60 Minutes',
                    'Face Mask' => 'Full-face silicone mask with anti-fog panoramic visor',
                    'Alarm Warning' => 'Pneumatic whistle > 90 dB at 55 Bar residual pressure',
                    'Approval' => 'EN 137 Type 2, SOLAS, MED Certified',
                ],
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // Category 6: Safety Signs
        Product::updateOrCreate(
            ['slug' => 'photoluminescent-imo-safety-signs'],
            [
                'category_id' => $catSigns->id,
                'branch_id' => $branchAlex->id,
                'name_ar' => 'لوحات إرشادية فوسفورية لطوارئ السفن SOLAS / IMO Signs',
                'name_en' => 'Photoluminescent Marine IMO Safety Signs (Set)',
                'sku' => 'AM-SGN-050',
                'price' => 450,
                'cost_price' => 220,
                'short_desc_ar' => 'علامات إرشادية وطوارئ مضيئة ذاتياً في الظلام التام لتعليم مسارات الهروب وطوافات النجاة.',
                'full_desc_ar' => 'مصنوعة من مادة PVC الفوسفورية المتطورة المقاومة للحرائق ومياه البحر. تضمن توجيه الطاقم والركاب لمسارات الإخلاء الآمنة أثناء انقطاع الكهرباء بالسفينة.',
                'specifications' => [
                    'Material' => 'Photoluminescent Rigid PVC / Aluminum',
                    'Luminance' => '> 140 mcd/m² after 10 mins (DIN 67510 Class C)',
                    'Compliance' => 'IMO Res A.1116(30) / ISO 15370 / SOLAS',
                ],
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                'availability_status' => 'متوفر في المخزن',
                'is_featured' => false,
                'is_active' => true,
            ]
        );

        // ════════════════════════════════════════════
        // 5. CORE TECHNICAL SERVICES (BILINGUAL)
        // ════════════════════════════════════════════
        $srvFire = Service::updateOrCreate(
            ['slug' => 'fire-equipment-maintenance'],
            [
                'name_ar' => 'صيانة واختبار منظومات ومعدات الإطفاء البحرية',
                'name_en' => 'Marine Fire Systems & Extinguishers Maintenance',
                'short_desc_ar' => 'فحص وإعادة تعبئة واختبار هيدروستاتيكي لمنظومات CO2 وخراطيم وطفايات الحريق بالسفن.',
                'full_desc_ar' => 'نقدم خدمات الصيانة الدورية والفحص السنوي الشامل لأنظمة الإطفاء التلقائية واليدوية على متن السفن والمنشآت الساحلية وفقاً لتعليمات المنظمة البحرية الدولية IMO وهيئات الإشراف المعتمدة.',
                'icon' => 'bi-fire',
                'features' => [
                    'فحص وإعادة تعبئة طفايات البودرة ورغوة الفوم وغاز CO2',
                    'اختبار هيدروستاتيكي حتى 250 بار للأسطوانات والخراطيم',
                    'إصدار شهادات صلاحية وتفتيش معتمدة لهيئات الإشراف الدولية',
                ],
                'is_active' => true,
            ]
        );

        $srvScba = Service::updateOrCreate(
            ['slug' => 'scba-service-maintenance'],
            [
                'name_ar' => 'فحص ومعايرة أجهزة التنفس SCBA ووحدات EEBD',
                'name_en' => 'SCBA & Breathing Apparatus Calibration & Recertification',
                'short_desc_ar' => 'معايرة ديناميكية واختبار تسريب ومراجعة صمامات مخفض الضغط لأسطوانات التنفس وأقنعة الطوارئ.',
                'full_desc_ar' => 'ورشة متخصصة ومجهزة بأحدث أجهزة الفحص الإلكتروني Posichek لاختبار أجهزة التنفس الذاتية بما يضمن سلامة المنقذين والعمال في البيئات الخطرة وغرف المحركات.',
                'icon' => 'bi-mask',
                'features' => [
                    'فحص الأسطوانات هيدروستاتيكياً واختبار نقاء الهواء المضغوط',
                    'معايرة إلكترونية بمحاكاة التنفس الفعلي Posichek',
                    'استبدال قطع الغيار والصمامات التالفة بقطع أصلية معتمدة',
                ],
                'is_active' => true,
            ]
        );

        $srvRescue = Service::updateOrCreate(
            ['slug' => 'marine-rescue-inspection'],
            [
                'name_ar' => 'معايرة وتجهيز معدات الإنقاذ وطوافات النجاة البحرية',
                'name_en' => 'SOLAS Life Raft & Marine Rescue Gear Inspection',
                'short_desc_ar' => 'تجهيز وفحص طوافات وقوارب وسترات النجاة وحقائب الإسعافات البحرية طبقاً لمعايير SOLAS.',
                'full_desc_ar' => 'مراجعة دورية لسترات وطوافات النجاة ومعدات الإشارة الضوئية للسفن والمراكب التجارية ومنصات البترول لضمان الجاهزية الفورية في حالات الطوارئ.',
                'icon' => 'bi-life-preserver',
                'features' => [
                    'فحص صمامات الإطلاق الهيدروستاتيكي HRU وكشافات الإشارة',
                    'اختبار كفاءة الطفو ومطابقة مواصفات التفتيش البحري الدولي',
                    'إصدار شهادات صلاحية معتمدة للسفن التجارية واليخوت',
                ],
                'is_active' => true,
            ]
        );

        $srvSigns = Service::updateOrCreate(
            ['slug' => 'safety-signage-customization'],
            [
                'name_ar' => 'تصميم وتوريد علامات السلامة والإرشاد الفوسفورية',
                'name_en' => 'Customized IMO Photoluminescent Signage & Markings',
                'short_desc_ar' => 'تصميم وطباعة لوحات السلامة والتحذيرات الفوسفورية حسب مسارات وطوابق منشأتك أو سفينتك.',
                'full_desc_ar' => 'تجهيز خرائط السيطرة على الحرائق (Fire Control Plans) وكافة لافتات الأمن الصناعي وطوارئ الإخلاء للمصانع والموانئ والمشاريع البحرية.',
                'icon' => 'bi-signpost-split',
                'features' => [
                    'طباعة عالية الدقة مقاومة للظروف الجوية وأشعة الشمس والملوحة',
                    'مواد فوسفورية ذاتية الإضاءة معتمدة تتجاوز 12 ساعة إشعاع',
                    'مطابقة تامة لكود السلامة العالمي IMO / OSHA / SOLAS',
                ],
                'is_active' => true,
            ]
        );

        // ════════════════════════════════════════════
        // 6. EXECUTED MAINTENANCE PROJECTS (CASE STUDIES)
        // ════════════════════════════════════════════
        $this->call(MaintenanceProjectSeeder::class);

        // ════════════════════════════════════════════
        // 7. CERTIFICATES & ACCREDITATIONS (BILINGUAL)
        // ════════════════════════════════════════════
        Certificate::updateOrCreate(
            ['certificate_number' => 'ISO-9001-2024-ALX'],
            [
                'title_ar' => 'شهادة الجودة العالمية ISO 9001:2015',
                'title_en' => 'ISO 9001:2015 Quality Management System',
                'issuing_authority' => 'TÜV NORD International',
                'description_ar' => 'اعتماد نظام إدارة الجودة لتوريد وصيانة السلامة البحرية والأمن الصناعي بمصر.',
                'is_active' => true,
            ]
        );

        Certificate::updateOrCreate(
            ['certificate_number' => 'EAMS-SOLAS-2026'],
            [
                'title_ar' => 'اعتماد التفتيش والتوريد البحري SOLAS / MED',
                'title_en' => 'SOLAS / MED Marine Safety Equipment Supplier License',
                'issuing_authority' => 'Egyptian Authority for Maritime Safety (EAMS)',
                'description_ar' => 'ترخيص رسمي لفحص وتوريد وصيانة معدات السلامة والإنقاذ للسفن التجارية بالموانئ المصرية.',
                'is_active' => true,
            ]
        );

        Certificate::updateOrCreate(
            ['certificate_number' => 'DNV-GL-SERV-882'],
            [
                'title_ar' => 'اعتماد هيئة الإشراف الدولية DNV GL',
                'title_en' => 'DNV GL Approved Service Supplier',
                'issuing_authority' => 'DNV Maritime Classification Society',
                'description_ar' => 'اعتماد ورش أليكس مارين لصيانة واختبار منظومات الإطفاء وأجهزة التنفس البحرية.',
                'is_active' => true,
            ]
        );

        // ════════════════════════════════════════════
        // 8. NEWS & MARITIME INDUSTRY UPDATES
        // ════════════════════════════════════════════
        NewsArticle::updateOrCreate(
            ['slug' => 'alex-marine-expands-alexandria-port-facility'],
            [
                'title_ar' => 'أليكس مارين تُدشن مركزاً هندسياً متطوراً لصيانة منظومات الإطفاء بميناء الإسكندرية',
                'summary_ar' => 'افتتاح المركز الجديد لتعزيز سرعة الاستجابة لخدمات التوريد والصيانة الفورية للسفن العابرة لميناء الإسكندرية والدخيلة.',
                'content_ar' => 'أعلنت شركة أليكس مارين عن تشغيل مركزها الفني المتكامل داخل المنطقة الجمركية بميناء الإسكندرية، والمجهز بأحدث أجهزة الفحص الهيدروستاتيكي ومعايرة أجهزة التنفس SCBA، دعماً لحركة الملاحة وسفن البضائع والناقلات.',
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ]
        );

        NewsArticle::updateOrCreate(
            ['slug' => 'new-solas-regulations-compliance-guide'],
            [
                'title_ar' => 'دليل أليكس مارين لامتثال السفن للتحديثات الأخيرة لمعايير SOLAS وIMO',
                'summary_ar' => 'نظرة شاملة على التعديلات الإلزامية الخاصة بطوافات النجاة وأجهزة استشعار الغازات داخل غرف المحركات.',
                'content_ar' => 'يقدم الفريق الاستشاري لشركة أليكس مارين دليلاً عملياً لشركات التوكيلات الملاحية وملاك السفن حول كيفية إجراء الفحص الدوري والتأكد من مطابقة معدات السلامة لأحدث الاشتراطات الدولية.',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ]
        );

        // ════════════════════════════════════════════
        // 9. SAMPLE RFQ QUOTATION REQUESTS & LIVE SALES ORDERS
        // ════════════════════════════════════════════
        $q1 = QuoteRequest::updateOrCreate(
            ['quote_number' => 'RFQ-2026-0101'],
            [
                'branch_id' => $branchAlex->id,
                'customer_name' => 'قبطان محمد الشناوي',
                'company_name' => 'شركة الملاحة الوطنية (National Marine Shipping)',
                'email' => 'client@nationalmarine.com',
                'phone' => '+20 100 123 4567',
                'status' => 'جديد',
                'total_estimated' => 45500,
                'notes' => 'توريد عاجل لرصيف 45 بميناء الإسكندرية قبل موعد إبحار السفينة.',
            ]
        );

        QuoteItem::updateOrCreate(
            ['quote_request_id' => $q1->id, 'sku' => 'AM-MAR-002'],
            [
                'product_name' => 'سترة نجاة بحرية معتمدة دولياً SOLAS Marine Life Jacket',
                'quantity' => 20,
                'unit_price' => 1850,
                'notes' => 'شامل كشاف الإشارة المائي والصفارة',
            ]
        );

        QuoteItem::updateOrCreate(
            ['quote_request_id' => $q1->id, 'sku' => 'AM-FIR-020'],
            [
                'product_name' => 'طفاية حريق بودرة كيميائية جافة 6 كجم ABC معتمدة',
                'quantity' => 5,
                'unit_price' => 1650,
                'notes' => 'مع حامل حائطي وشريط معايرة',
            ]
        );

        $q2 = QuoteRequest::updateOrCreate(
            ['quote_number' => 'RFQ-2026-0102'],
            [
                'branch_id' => $branchSuez->id,
                'customer_name' => 'م. طارق العوضي',
                'company_name' => 'شركة البحر الأحمر للخدمات البترولية والبحرية',
                'email' => 'procurement@redseashipping.com',
                'phone' => '+20 100 555 6677',
                'status' => 'تم التسعير',
                'total_estimated' => 88500,
                'notes' => 'تفتيش ومعايرة أجهزة التنفس والسترات بالفرع البحري بالسويس.',
            ]
        );

        QuoteItem::updateOrCreate(
            ['quote_request_id' => $q2->id, 'sku' => 'AM-RSP-040'],
            [
                'product_name' => 'جهاز تنفس عازل ذاتي SCBA 6.8L كربون فايبر 300 بار',
                'quantity' => 2,
                'unit_price' => 38000,
                'notes' => 'مع شهادة فحص Posichek',
            ]
        );

        QuoteItem::updateOrCreate(
            ['quote_request_id' => $q2->id, 'sku' => 'AM-RES-030'],
            [
                'product_name' => 'طوق نجاة بحري صلب 4.3 كجم SOLAS Lifebuoy Ring',
                'quantity' => 6,
                'unit_price' => 1950,
                'notes' => 'برتقالي مع حبل إمساك',
            ]
        );

        // Completed Live Order
        $order1 = Order::updateOrCreate(
            ['order_number' => 'ORD-2026-0001'],
            [
                'quote_request_id' => $q2->id,
                'branch_id' => $branchSuez->id,
                'customer_name' => 'م. طارق العوضي',
                'company_name' => 'شركة البحر الأحمر للخدمات البترولية والبحرية',
                'email' => 'procurement@redseashipping.com',
                'phone' => '+20 100 555 6677',
                'status' => 'مكتمل',
                'total_amount' => 88500,
                'payment_status' => 'تم الدفع',
                'notes' => 'تم التوريد والتسليم الفوري من فرع السويس وبورسعيد بنجاح.',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'sku' => 'AM-RSP-040'],
            [
                'product_name' => 'جهاز تنفس عازل ذاتي SCBA 6.8L كربون فايبر 300 بار',
                'quantity' => 2,
                'unit_price' => 38000,
                'total_price' => 76000,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'sku' => 'AM-RES-030'],
            [
                'product_name' => 'طوق نجاة بحري صلب 4.3 كجم SOLAS Lifebuoy Ring',
                'quantity' => 6,
                'unit_price' => 1950,
                'total_price' => 11700,
            ]
        );

        // Pending Live Order
        $order2 = Order::updateOrCreate(
            ['order_number' => 'ORD-2026-0002'],
            [
                'branch_id' => $branchAlex->id,
                'customer_name' => 'شركة النيل للشحن والموانئ',
                'company_name' => 'شركة النيل الملاحية والتوريدات',
                'email' => 'procurement@nileshipping.com',
                'phone' => '+20 120 777 8899',
                'status' => 'قيد التجهيز',
                'total_amount' => 52800,
                'payment_status' => 'آجل / حسب الاتفاق',
                'notes' => 'أمر توريد صادر من فرع الإسكندرية الرئيسي جاري التحميل للرصيف.',
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'sku' => 'AM-MAR-003'],
            [
                'product_name' => 'حبل ربط سفن فائق القوة 8 جدائل Mooring Rope',
                'quantity' => 4,
                'unit_price' => 12500,
                'total_price' => 50000,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'sku' => 'AM-SAF-010'],
            [
                'product_name' => 'خوذة سلامة صناعية مقواة مع فتحات تهوية EN 397',
                'quantity' => 7,
                'unit_price' => 400,
                'total_price' => 2800,
            ]
        );
    }
}
