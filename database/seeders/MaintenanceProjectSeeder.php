<?php

namespace Database\Seeders;

use App\Models\MaintenanceProject;
use App\Models\Service;
use Illuminate\Database\Seeder;

class MaintenanceProjectSeeder extends Seeder
{
    public function run(): void
    {
        $fireService = Service::where('slug', 'fire-fighting-maintenance')->first();
        $scbaService = Service::where('slug', 'scba-service-maintenance')->first();
        $rescueService = Service::where('slug', 'marine-rescue-inspection')->first();

        // 1. Project Case 1: Major Cargo Vessel CO2 Fire System Overhaul
        MaintenanceProject::updateOrCreate(
            ['slug' => 'cargo-vessel-co2-fire-suppression-overhaul'],
            [
                'service_id' => $fireService?->id,
                'title_ar' => 'صيانة وتجديد منظومة الإطفاء المركزية CO2 لسفينة الشحن MV Alexandria Star',
                'title_en' => 'CO2 High-Pressure Fire Suppression System Overhaul on MV Alexandria Star',
                'client_name' => 'شركة الملاحة الوطنية — MV Alexandria Star',
                'vessel_type' => 'ناقلة بضائع صب (Bulk Carrier — 35,000 DWT)',
                'location_ar' => 'ميناء الإسكندرية — حوض الترسانة البحرية',
                'location_en' => 'Port of Alexandria, Marine Shipyard Basin',
                'duration' => '5 أيام عمل متواصلة',
                'short_desc_ar' => 'إعادة تأهيل واختبار هيدروستاتيكي متكامل لـ 64 أسطوانة CO2 مع استبدال صمامات الإطلاق وخراطيم الضغط العالي والحصول على شهادة DNV المعتمدة.',
                'short_desc_en' => 'Complete overhaul and hydrostatic testing of 64 high-pressure CO2 cylinders with manifold replacement and DNV class certification.',
                'description_ar' => "تم تنفيذ مشروع الصيانة الشاملة لمنظومة الإطفاء بغاز ثاني أكسيد الكربون (CO2 System) لغرفة محركات السفينة التجارية MV Alexandria Star وفقاً لأعلى معايير المنظمة البحرية الدولية (IMO/SOLAS).\n\nشمل نطاق العمل:\n• تفريغ وفك 64 أسطوانة ضغط عالي ونقلها لمركز الصيانة المعتمد لشركة أليكس مارين.\n• إجراء الاختبار الهيدروستاتيكي لضغط 250 بار وفحص السُمك بالموجات فوق الصوتية.\n• صيانة واستبدال صمامات الأمان، الصمامات الاتجاهية (Pneumatic Directional Valves)، وخراطيم التوزيع المرنة.\n• إعادة تعبئة الغاز بدقة ميزان رقمي، وإجراء اختبار تسريب لخطوط التوزيع داخل غرفة المحركات.\n• إصدار شهادة مطابقة وتفتيش معتمدة من هيئة السلامة البحرية وهيئة الإشراف الدولية.",
                'description_en' => "Comprehensive overhaul of the engine room CO2 fixed fire suppression system on MV Alexandria Star conducted in accordance with IMO/SOLAS maritime standards.\n\nScope of Work:\n• Decommissioning and transport of 64 high-pressure cylinders to Alex Marine certified maintenance facility.\n• 250-bar hydrostatic pressure testing and ultrasonic wall thickness gauge inspections.\n• Overhaul of pneumatic release valves, master discharge manifolds, and flexible loop connections.\n• Precise digital weighing and gas refilling with nitrogen pressurization test.\n• Official inspection certification issued and endorsed by classification society surveyors.",
                'specifications' => [
                    'عدد الأسطوانات' => '64 أسطوانة (45 كجم CO2)',
                    'ضغط الاختبار' => '250 Bar هيدروستاتيكي',
                    'المعايير والاعتماد' => 'SOLAS II-2, IMO MSC.1/Circ.1318, DNV',
                    'زمن الإنجاز' => '5 أيام قياسية دون تعطيل رحلة السفينة',
                    'الضمان الفني' => 'ضمان لمدة 24 شهراً مع تفتيش دوري',
                ],
                'main_image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=1200&q=80',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // 2. Project Case 2: Offshore SCBA & Breathing Apparatus Recertification
        MaintenanceProject::updateOrCreate(
            ['slug' => 'offshore-scba-breathing-apparatus-inspection'],
            [
                'service_id' => $scbaService?->id,
                'title_ar' => 'فحص ومعايرة أجهزة التنفس SCBA وأقنعة الطوارئ لمنصة بترول بحرية',
                'title_en' => 'Offshore Rig SCBA & EEBD Breathing Apparatus Comprehensive Recertification',
                'client_name' => 'شركة بترول بلاعيم (Petrobel) — منصة أبو رديس',
                'vessel_type' => 'منصة حفر بحرية (Offshore Jack-up Rig)',
                'location_ar' => 'خليج السويس — المياه الإقليمية المصرية',
                'location_en' => 'Gulf of Suez Offshore Concession',
                'duration' => '3 أيام عمل',
                'short_desc_ar' => 'إجراء فحص كامل واختبار كمبيوتر ديناميكي لـ 40 جهاز تنفس ذاتي SCBA وأجهزة الهروب السريع EEBD مع اختبار جودة الهواء المضغوط.',
                'short_desc_en' => 'Dynamic Posichek computerized test & recertification for 40 SCBA sets and EEBD units on an offshore drilling platform.',
                'description_ar' => "قامت الفرق الفنية المتخصصة لشركة أليكس مارين بالانتقال الميداني لمنصة الحفر البحرية لإجراء الفحص السنوي الشامل لمنظومات التنفس وأجهزة الإنقاذ في الأماكن المغلقة ومناطق غاز H2S.\n\nشملت الأعمال:\n• اختبار الأداء الديناميكي لأقنعة الوجه الكامل ومخفضات الضغط باستخدام جهاز المعايرة الإلكتروني Posichek 3.\n• الفحص الهيدروستاتيكي لأسطوانات الكربون فايبر 300 بار.\n• تحليل نقاء هواء التنفس والتأكد من مطابقة نسب الزيت والرطوبة لمعايير EN 12021.\n• استبدال صمامات الطلب المجهدة (Demand Valves) وتركيب موانع تسريب معتمدة جديدة.",
                'description_en' => "Alex Marine certified technical team was deployed offshore to execute annual recertification and dynamic flow testing for life-support breathing apparatus sets.\n\nWork Performed:\n• Computerized Posichek-3 dynamic testing of positive-pressure lung demand valves and facepieces.\n• 300-bar carbon-composite cylinder hydrostatic re-testing.\n• Breathing air purity analysis verified against EN 12021 standards.\n• Replaced diaphragms, O-rings, and pressure gauges with genuine OEM kits.",
                'specifications' => [
                    'عدد الأجهزة المفحوصة' => '40 جهاز SCBA + 25 وحدة EEBD',
                    'ضغط التشغيل' => '300 Bar (Carbon Composite)',
                    'أجهزة الفحص المستخدمة' => 'Posichek 3 Dynamic Flow Tester',
                    'الاعتمادات' => 'EN 137 / SOLAS / MED Certified',
                    'مكان التنفيذ' => 'Offshore Onsite & Alex Marine Lab',
                ],
                'main_image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=1200&q=80',
                'video_url' => null,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        // 3. Project Case 3: Passenger Cruise Life Rafts & Rescue Boats Refurbishment
        MaintenanceProject::updateOrCreate(
            ['slug' => 'cruise-vessel-life-rafts-rescue-equipment-service'],
            [
                'service_id' => $rescueService?->id,
                'title_ar' => 'صيانة واختبار طوافات النجاة وقوارب الإنقاذ السريع لليخت السياحي الملكي',
                'title_en' => 'Inflatable Life Rafts & Fast Rescue Boats Refurbishment for Luxury Mega Yacht',
                'client_name' => 'إدارة اليخوت السياحية — ميناء مارينا الجونة',
                'vessel_type' => 'يخت سياحي فخم (Mega Yacht — 65m)',
                'location_ar' => 'ميناء الغردقة ومارينا الجونة — البحر الأحمر',
                'location_en' => 'El Gouna Marina & Hurghada Port, Red Sea',
                'duration' => '4 أيام عمل',
                'short_desc_ar' => 'خدمة صيانة وتجهيز متكاملة لطوافات النجاة المطاطية الذاتية النفخ مع استبدال عبوات الطوارئ والمعدات البحرية وفقاً للائحة SOLAS.',
                'short_desc_en' => 'Complete annual inspection and gas inflation load test of SOLAS inflatable life rafts, emergency rations and hydrostatic release units.',
                'description_ar' => "تم تنفيذ الصيانة الدورية الإلزامية لطوافات النجاة الذاتية الانتفاخ (Inflatable Life Rafts) من سعة 25 و 50 فرداً، بالإضافة إلى قارب الإنقاذ السريع (Fast Rescue Boat).\n\nالمراحل المنفذة:\n• تفريغ الطوافات واختبار الانتفاخ بالغاز المضغوط ومراقبة الضغط الداخلي لمدة 12 ساعة متواصلة (NAP Test).\n• استبدال وحدات الإطلاق الهيدروستاتيكي (Hydrostatic Release Units - HRU).\n• تجديد مؤن وحقائب الطوارئ (Emergency Rations, Pyrotechnics & First Aid Kits).\n• تشحيم وفحص رافعات القوارب (Davit Launching Systems) وإجراء اختبار التحميل بالأوزان.",
                'description_en' => "Mandatory annual servicing and gas inflation load testing for SOLAS-A pack inflatable life rafts (25 and 50 person capacity) and onboard Fast Rescue Craft.\n\nKey Milestones:\n• Full canister deployment, gas charge verification, and 12-hour Necessary Additional Pressure (NAP) testing.\n• Renewal of Hammar Hydrostatic Release Units (HRU) and life-support emergency packs.\n• Re-certification of pyrotechnic distress flares, rocket parachute flares, and EPIRB beacons.\n• Davit crane static and dynamic overload proof testing.",
                'specifications' => [
                    'السعة الاستيعابية' => 'طوافات نجاة 25 و 50 راكب SOLAS A-Pack',
                    'نوع الاختبار' => 'NAP Test & 100% Overpressure Proof Test',
                    'الاعتماد الدولي' => 'Bureau Veritas & EAMS Marine Authority',
                    'وحدات الإطلاق' => 'Hydrostatic Release Units (HRU) New OEM',
                    'شهادة الصلاحية' => 'شهادة فحص وتفتيش دولية صالحة لمدة عام',
                ],
                'main_image' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=1200&q=80',
                'video_url' => null,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                ],
                'before_image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ]
        );
    }
}
