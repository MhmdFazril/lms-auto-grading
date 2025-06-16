<script>
    $(document).ready(function() {
        $("form").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault(); // Mencegah submit form saat menekan Enter
            }
        });

        $("#togglePassword").on("click", function() {
            let passwordField = $("#password");
            let isPasswordHidden = passwordField.attr("type") === "password";

            // Ganti tipe input
            passwordField.attr("type", isPasswordHidden ? "text" : "password");

            // Ubah ikon
            $(this).html(
                isPasswordHidden ?
                '<i class="fa-solid fa-eye-slash"></i>' :
                '<i class="fa-solid fa-eye"></i>'
            );
        });

        // $("#password").on("input", function() {
        //     let password = $(this).val();
        //     let errorMessage = $("#passwordError");

        //     if (!validatePassword(password)) {
        //         errorMessage.text(
        //             "Password harus minimal 8 karakter, termasuk huruf besar, kecil, angka, dan simbol."
        //         );
        //     } else {
        //         errorMessage.text(""); // Hapus pesan jika valid
        //     }
        // });

        function validatePassword(password) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(
                password
            );
        }


        // ===================================
        let defaultImage = "{{ asset('img/school-default.png') }}";

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

                $('#remove_image').val(0); // Tandai bahwa gambar diisi ulang
                reader.readAsDataURL(file);
            }
        });

        // Hapus gambar dan kembali ke default
        $("#removeImage").on("click", function(e) {
            $("#profileImage").attr("src", defaultImage);
            $("#gambar").val(""); // Reset input file
            $(this).addClass("hidden"); // Sembunyikan tombol hapus

            $('#remove_image').val(1); // Tandai bahwa gambar dihapus
        });
    });

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
