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
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Raport Halaman 1</a></li>
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
                كشف الدرجات
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
                        <table class="table arabic" style="text-align:right;" dir="rtl">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-items-center" style="font-size:20px;">الرقم</th>
                                    <th class="align-items-center" style="font-size:20px;">المواد</th>
                                    <th class="align-items-center" style="font-size:25px;">Subjects</th>
                                    <th class="align-items-center" style="font-size:15px;">المتابعة<br>والحضور</th>
                                    <th class="align-items-center" style="font-size:15px;">الاختبار<br>النصفي</th>
                                    <th class="align-items-center" style="font-size:15px;">الاختبار<br>النهائي</th>
                                    <th class="align-items-center" style="font-size:15px;">مجموعة<br>النتيجة</th>
                                    <th class="align-items-center" style="font-size:15px;">عدد<br>الحصة<br>في الأسبوع</th>
                                    <th class="align-items-center" style="font-size:15px;">النتيجة x <br>عدد<br>الحصة</th>
                                    <th class="align-items-center" style="font-size:15px;">المعدل<br>الصفي</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $list = [
                                        [
                                            'no' => '١',
                                            'mp1' => 'القرآن الكريم',
                                            'mp2' => 'The Holy Quran',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٢',
                                            'mp1' => 'المبادئ الإسلامية',
                                            'mp2' => 'Islamic Principles',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٣',
                                            'mp1' => 'أصول الدين',
                                            'mp2' => 'Religion Basics',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٤',
                                            'mp1' => 'الفقه',
                                            'mp2' => 'Jurisprudence',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٥',
                                            'mp1' => 'التاريخ',
                                            'mp2' => 'History',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٦',
                                            'mp1' => 'اللغة العربية',
                                            'mp2' => 'Arabic Language',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٧',
                                            'mp1' => 'الرياضيات',
                                            'mp2' => 'Mathematics',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٨',
                                            'mp1' => 'العلوم الاجتماعية',
                                            'mp2' => 'Social Sciences',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '٩',
                                            'mp1' => 'العلوم الطبيعية',
                                            'mp2' => 'Natural Sciences',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٠',
                                            'mp1' => 'التربية الوطنية',
                                            'mp2' => 'Civics Education',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١١',
                                            'mp1' => 'اللغة الإندونيسية',
                                            'mp2' => 'Indonesian Language',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٢',
                                            'mp1' => 'اللغة الإنجليزية',
                                            'mp2' => 'English Language',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٣',
                                            'mp1' => 'المكتبة',
                                            'mp2' => 'Library',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٤',
                                            'mp1' => 'الخط العربي',
                                            'mp2' => 'Calligraphy',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٥',
                                            'mp1' => 'الكمبيوتر',
                                            'mp2' => 'Computer',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٦',
                                            'mp1' => 'الصناعة والزراعة',
                                            'mp2' => 'Industry & Agriculture',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                        [
                                            'no' => '١٧',
                                            'mp1' => 'الرياضة',
                                            'mp2' => 'Sports/ Physical Education',
                                            'nl1' => '٩١',
                                            'nl2' => '٩٦',
                                            'nl3' => '٩٩',
                                            'nl4' => '٩٦',
                                            'nl5' => '٥',
                                            'nl6' => '٤٧٩',
                                            'nl7' => '٨١'
                                        ],
                                    ];
                                @endphp
                                @foreach ($list as $key => $val)
                                    <tr>
                                        <td class="arabic">{{ $val['no'] }}</td>
                                        <td class="arabic">{{ $val['mp1'] }}</td>
                                        <td class="arabic text-left">{{ $val['mp2'] }}</td>
                                        <td class="arabic">{{ $val['nl1'] }}</td>
                                        <td class="arabic">{{ $val['nl2'] }}</td>
                                        <td class="arabic">{{ $val['nl3'] }}</td>
                                        <td class="arabic">{{ $val['nl4'] }}</td>
                                        <td class="arabic">{{ $val['nl5'] }}</td>
                                        <td class="arabic">{{ $val['nl6'] }}</td>
                                        <td class="arabic">{{ $val['nl7'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table class="table arabic" style="text-align:right;" dir="rtl">
                            <thead class="thead-light">
                                <tr>
                                    <td class="align-items-center arabic">إجمالي النتيجة للفصل</td>
                                    <td class="align-items-center arabic">٣٣٨١</td>
                                    <td class="align-items-center arabic" rowspan="2">النتيجة</td>
                                    <td class="align-items-center arabic" rowspan="2">:</td>
                                    <td class="align-items-center arabic" rowspan="2">ناجح</td>
                                    <td class="align-items-center arabic" colspan="2">الملاحظة:</td>
                                    <td class="align-items-center arabic" colspan="2">أيام الغياب:</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">ساعات الفصل</td>
                                    <td class="align-items-center arabic">٣٨</td>
                                    <td class="align-items-center arabic">السلوك</td>
                                    <td class="align-items-center arabic">A</td>
                                    <td class="align-items-center arabic">لمرض</td>
                                    <td class="align-items-center arabic">٣</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المعدل الفصلي للمستوى الثاني</td>
                                    <td class="align-items-center arabic">٨٩</td>
                                    <td class="align-items-center arabic" rowspan="2">التقدير</td>
                                    <td class="align-items-center arabic" rowspan="2">:</td>
                                    <td class="align-items-center arabic" rowspan="2">جيد جدا</td>
                                    <td class="align-items-center arabic">النظافة</td>
                                    <td class="align-items-center arabic">A</td>
                                    <td class="align-items-center arabic">لاستئذان</td>
                                    <td class="align-items-center arabic">-</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المعدل الفصلي للمستوى الأول</td>
                                    <td class="align-items-center arabic">٨٩</td>
                                    <td class="align-items-center arabic">المواظبة</td>
                                    <td class="align-items-center arabic">A</td>
                                    <td class="align-items-center arabic">لـآخر</td>
                                    <td class="align-items-center arabic">-</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المعدل التراكمي</td>
                                    <td class="align-items-center arabic">٨٩,١</td>
                                    <td class="align-items-center arabic" colspan="3">المواد المحمولة :</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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
                        مشرف الفصل
                        <br>
                        <br>
                        <br>
                        الأستاذ عبد الرحمن حميم
                    </div>
                    <div class="col-md-4">
                        ولي الأمر
                        <br>
                        <br>
                        <br>
                        ____________________
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
