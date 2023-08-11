@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-7">
        <div class="header">
            <div class="header-body">
                <div class="row">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Raport Halaman 2</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('tambah-siswa') }}" class="btn btn-sm btn-neutral"><i class="fa fa-print"></i> Print</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="row" style="background-image:url('/assets/img/adn/logo-msh-emas.png') no-repeat;">
            <div class="col-md-12 arabic text-center">
                بيانات إضافية لمعايير النجاح
            </div>
            <div class="col-md-12 arabic text-center">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div class="col-md-12 arabic text-center">
                المستوى الثاني /  الفصل الدراسي الأول لعام ١٤٤٢هـ /٢٠٢١ م
            </div>
            <div class="col-md-12 arabic text-center">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونسيا
            </div>
            <br>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 arabic text-right">
                        رقم القيد :١٢٠٠١٠٩
                    </div>
                    <div class="col-md-4 arabic text-right">
                        الصف :الأول/ الإمام الشافعي
                    </div>
                    <div class="col-md-4 arabic text-right">
                        اسم الطالب : زِيْدَان سَاتْيَا أَدِيْلُوهُونْع
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive mt-3">
                    <div>
                        <table class="table arabic table-bordered" style="text-align:right;" dir="rtl">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-items-center" style="font-size:20px;">الرقم</th>
                                    <th class="align-items-center" style="font-size:20px;" colspan="2">معايير النجاح</th>
                                    <th class="align-items-center" style="font-size:25px;">النتيجة</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td class="arabic">١</td>
                                    <td class="arabic" colspan="2">نتيجة كشف الدرجات</td>
                                    <td class="arabic">ناجح</td>
                                </tr>
                                <tr>
                                    <td class="arabic" rowspan="4">٢</td>
                                    <td class="arabic" rowspan="4">نتيجة مواد الأساس</td>
                                    <td class="arabic">الثقافة الإسلامية</td>
                                    <td class="arabic">٩٦</td>
                                </tr>
                                <tr>
                                    <td class="arabic">اللغة العربية</td>
                                    <td class="arabic">٩١</td>
                                </tr>
                                <tr>
                                    <td class="arabic">العلوم</td>
                                    <td class="arabic">٨٨</td>
                                </tr>
                                <tr>
                                    <td class="arabic">الرياضيات</td>
                                    <td class="arabic">٨٧</td>
                                </tr>
                                <tr>
                                    <td class="arabic">٣</td>
                                    <td class="arabic" colspan="2">تسميع مقرر القرآن</td>
                                    <td class="arabic">تم</td>
                                </tr>
                                <tr>
                                    <td class="arabic">٤</td>
                                    <td class="arabic" colspan="2">ملاحظة قسم شؤون الطلاب</td>
                                    <td class="arabic">مؤهّل</td>
                                </tr>
                                <tr>
                                    <td class="arabic">٥</td>
                                    <td class="arabic" colspan="2">فعاليات ولي الأمر</td>
                                    <td class="arabic">فعّال</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table class="table arabic table-bordered" style="text-align:right;" dir="rtl">
                            <thead class="thead-light">
                                <tr>
                                    <td class="align-items-center arabic">النتيجة النهائية</td>
                                    <td class="align-items-center arabic">ناجح</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">رتبة النتيجة في الدفعة</td>
                                    <td class="align-items-center arabic">٢٥</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">رتبة النتيجة في الصف</td>
                                    <td class="align-items-center arabic">٧</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المعدل الفصلي للمستوى الأول</td>
                                    <td class="align-items-center arabic">٨٩</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المعدل التراكمي</td>
                                    <td class="align-items-center arabic">٨٩,١</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 arabic text-center">
                تحريرا بمعهد شرف الحرمين:
            </div>
            <div class="col-md-12 arabic text-center">
                بوغور، ٨ يوليو ٢٠٢١ م   / ٢٧  ذو القعدة ١٤٤٢ ه
            </div>
            <div class="col-md-12 arabic text-center">
                <div class="row">
                    <div class="col-md-4">
                        مدير المدرسة
                        <br>
                        <br>
                        <br>
                        الأستاذ أحمد جيلاني
                    </div>
                    <div class="col-md-4">
                        رئيس قسم شؤون الطلاب
                        <br>
                        <br>
                        <br>
                        الأستاذ زمراني أحمد
                    </div>
                    <div class="col-md-4">
                        رئيسة قسم التعليم
                        <br>
                        <br>
                        <br>
                        الأستاذة عافية محفوظة
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            'setDate': new Date(),
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            zIndexOffset: 999
        });

        $('#hapus').on('click',function(){
            Swal.fire({
                title: 'Betul akan dihapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Siswa sudah dihapus',
                    'success'
                    )
                }
            })
        })
    </script>
@endpush
