<script>
    $(document).ready(function() {

        $("form").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault(); // Mencegah submit form saat menekan Enter
            }
        });

        let defaultImage = "{{ asset('img/user-default.png') }}";

        // Ketika tombol upload diklik
        $("#uploadButton").on("click", function(e) {
            $("#gambar").click();
        });

        // Ketika user memilih gambar
        $("#gambar").on("change", function(event) {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $("#profileImage").attr("src", e.target.result);
                    $("#removeImage").removeClass("hidden"); // Tampilkan tombol hapus
                };
                reader.readAsDataURL(file);
            }
        });

        // Hapus gambar dan kembali ke default
        $("#removeImage").on("click", function(e) {
            $("#profileImage").attr("src", defaultImage);
            $("#gambar").val(""); // Reset input file
            $(this).addClass("hidden"); // Sembunyikan tombol hapus
        });
    })


    $(document).on('click', '#expand', function() {
        if ($(this).text() == 'expand all') {
            $(this).text('collapse all')

            $('.dropdownAcc').each(function() {
                $(this).prop('checked', true)
            })
        } else {
            $(this).text('expand all')

            $('.dropdownAcc').each(function() {
                $(this).prop('checked', false)
            })
        }

    })
</script>
