<!-- Modal -->
{{-- <div class="modal fade" id="uploadProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div> --}}
<!-- Required jquery and libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('mobile') }}/js/popper.min.js"></script>
<script src="{{ asset('mobile') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('mobile') }}/js/jquery.cookie.js"></script>
<script src="{{ asset('mobile') }}/vendor/swiper/js/swiper.min.js"></script>
<script src="{{ asset('mobile') }}/js/main.js"></script>
<script src="{{ asset('mobile') }}/js/color-scheme-demo.js"></script>
<script src="{{ asset('mobile') }}/js/pwa-services.js"></script>
<script src="{{ asset('mobile') }}/js/app.js"></script>
<script src="https://kit.fontawesome.com/5c10d44513.js" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#fotoprofil').on('click',function(){
        $('#uploadProfil').modal('show');
    });
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
            title: "Jika diperlukan, bisa discreenshot, kirimkan ke admin!<br>"+msg,
            showConfirmButton: true,
        })
    }
    function ganti()
    {
        // $('#exampleModal').modal('show');
    }
    function bukanotif()
    {

    }
</script>
