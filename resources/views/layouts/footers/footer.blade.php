        <div class="modal fade" id="modalUbahSemester" tabindex="-1" aria-labelledby="labelModalUbahSemester" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Th Ajar & Semester Aktif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmUbahSemester">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tahunajar">Tahun Ajar</label>
                                        <select name="tahunajar" id="tahunajar" class="form-control">
                                            @php
                                                $array = \App\Models\AcademicYear::orderBy('name')->get()->toArray();
                                                foreach($array as $k=>$v)
                                                {
                                                    $selected = ($v['id']==config('id_active_academic_year')) ? 'selected="selected"' : '';
                                                    echo '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="semester">Semester</label>
                                        <select name="semester" id="semester" class="form-control">
                                            @php
                                                $array = ['1'=>'Semester 1','2'=>'Semester 2'];
                                                foreach($array as $k=>$v)
                                                {
                                                    $selected = ($k==config('id_active_term')) ? 'selected="selected"' : '';
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <a href="javascript:void(0)" class="btn btn-warning" onclick="resetSemesterAktif()"><i class="fa fa-undo"></i> Reset</a>
                                </div>
                                <div class="col-md-8 text-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                    <button type="button" class="btn btn-primary" onclick="updateSemesterAktif()"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/5c10d44513.js" crossorigin="anonymous"></script>
        @stack('js')
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function msgSukses(msg) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: msg,
                    showConfirmButton: false,
                    timer: 1500,
                })
            }
            function msgError(msg){
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: "<div style='font-size:12px;'>Jika diperlukan, bisa discreenshot, kirimkan ke admin!</div><br>"+msg,
                    showConfirmButton: true
                })
            }
            function ubahSemesterAktif()
            {
                $('#modalUbahSemester').modal('show');
            }
            function updateSemesterAktif()
            {
                frm = $('#frmUbahSemester').serialize();
                $.post('{{ url('home/gantisemester') }}',{"_token": "{{ csrf_token() }}",data:frm},function(data){
                    if(data=='Berhasil')
                    {
                        msgSukses('Berhasil ganti sesi Semester yang aktif');
                        location.reload();
                    }
                })
            }
            function resetSemesterAktif()
            {
                $.post('{{ url('home/gantisemester') }}',{"_token": "{{ csrf_token() }}",data:'tahunajar=reset'},function(data){
                    if(data=='Berhasil')
                    {
                        msgSukses('Berhasil ganti sesi Semester yang aktif');
                        location.reload();
                    }
                })
            }
            function msgConfirm(title,text)
            {
                var ret = false;
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yakin'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ret = true;
                    }
                })
                return ret;
            }
        </script>
        @if(session('success'))
            msgSukses("{{ session('success') }}");
        @endif
        @if(session('warning'))
            msgError("{{ session('warning') }}");
        @endif
        @if(session('error'))
            msgError("{{ session('error') }}");
        @endif
        @stack('footer')
