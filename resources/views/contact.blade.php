@extends('layouts.app')

@section('title', 'تواصل معنا — أليكس مارين')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark fs-1 mb-2">تواصل معنا</h1>
            <p class="text-muted fs-5">فريق المبيعات والدعم الفني في خدمتكم على مدار الساعة</p>
        </div>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="alex-card p-4 h-100" style="background-color: #0A1D37; color: #ffffff;">
                    <h3 class="fw-bold text-warning mb-4">معلومات الاتصال</h3>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">العنوان والمقر الرئيسي</div>
                            <div class="text-white-50">المنطقة الجمركية - ميناء الإسكندرية، جمهورية مصر العربية</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">الهاتف المباشر</div>
                            <div class="text-white-50" dir="ltr">+20 120 000 1122</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-whatsapp fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">خدمة العملاء عبر الواتساب</div>
                            <div class="text-white-50" dir="ltr">+20 120 000 1122</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-envelope-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">البريد الإلكتروني</div>
                            <div class="text-white-50">info@alexmarine.eg</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="alex-card p-4">
                    <h3 class="fw-bold text-dark mb-4">أرسل استفسارك</h3>
                    <form action="#" method="POST" onsubmit="alert('تم استلام رسالتك وسيتم التواصل معك قريباً'); return false;">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">الاسم بالكامل <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required placeholder="محمد أحمد">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">اسم الشركة / الجهة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required placeholder="شركة الملاحة">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" required placeholder="name@company.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">رقم الهاتف / الواتساب <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required placeholder="+20 100 000 0000">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">نص الرسالة أو الاستفسار <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" required placeholder="اكتب الاستفسار أو المنتجات المطلوبة هنا..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-alex-primary btn-lg w-100">
                                    إرسال الرسالة <i class="bi bi-send-fill ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
