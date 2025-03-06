<script>
    toastr.options = {
        closeButton: false, // Menampilkan tombol close (X)
        progressBar: true, // Menampilkan progress bar
        positionClass: "toast-bottom-right", // Posisi notifikasi
        timeOut: "4000", // Durasi tampil (dalam ms, 3000 = 3 detik)
        extendedTimeOut: "1000", // Durasi tambahan jika di-hover
        showEasing: "swing", // Efek saat muncul
        hideEasing: "linear", // Efek saat menghilang
        showMethod: "fadeIn", // Efek animasi saat muncul
        hideMethod: "fadeOut", // Efek animasi saat menghilang
    };

    @if (session('successToast'))
        toastr.success("{{ session('successToast') }}");
    @endif

    @if (session('errorToast'))
        toastr.error("{{ session('errorToast') }}");
    @endif

    @if (session('infoToast'))
        toastr.info("{{ session('infoToast') }}");
    @endif

    @if (session('warningToast'))
        toastr.warning("{{ session('warningToast') }}");
    @endif
</script>
