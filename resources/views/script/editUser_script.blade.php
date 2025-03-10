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
    });

    function saveValidate(elem) {
        let isValid = true;

        @if ($role == 'Teacher')
            let nip = $('#nip')
            let nama = $('#nama')
            let tempat_tgl_lahir = $('#tempat_tgl_lahir')
            let tgl_lahir = $('#tgl_lahir')
            let telp = $('#telp')
            let wa = $('#wa')
            let email = $('#email')


            if (nip.val().trim() === "") {
                toastr.warning("NIP tidak boleh kosong");
                isValid = false;
            }
            if (nama.val().trim() === "") {
                toastr.warning("Nama Lengkap tidak boleh kosong");
                isValid = false;
            }
            if (tempat_tgl_lahir.val().trim() === "") {
                toastr.warning("Tempat Lahir tidak boleh kosong");
                isValid = false;
            }
            if (tgl_lahir.val().trim() === "") {
                toastr.warning("Tanggal Lahir tidak boleh kosong");
                isValid = false;
            }
            if (telp.val().trim() === "") {
                toastr.warning("Nomor Telepon tidak boleh kosong");
                isValid = false;
            }
            if (wa.val().trim() === "") {
                toastr.warning("Nomor WhatsApp tidak boleh kosong");
                isValid = false;
            }
            if (email.val().trim() === "") {
                toastr.warning("Email tidak boleh kosong");
                isValid = false;
            }
        @else
            let nisn = $('#nisn')
            let nama = $('#nama')
            let tempat_tgl_lahir = $('#tempat_tgl_lahir')
            let tgl_lahir = $('#tgl_lahir')
            let telp = $('#telp')
            let wa = $('#wa')
            let email = $('#email')
            let wali = $('#wali')
            let alamat_wali = $('#alamat_wali')
            let telp_wali = $('#telp_wali')


            if (nisn.val().trim() === "") {
                toastr.warning("nisn tidak boleh kosong");
                isValid = false;
            }
            if (nama.val().trim() === "") {
                toastr.warning("Nama Lengkap tidak boleh kosong");
                isValid = false;
            }
            if (tempat_tgl_lahir.val().trim() === "") {
                toastr.warning("Tempat Lahir tidak boleh kosong");
                isValid = false;
            }
            if (tgl_lahir.val().trim() === "") {
                toastr.warning("Tanggal Lahir tidak boleh kosong");
                isValid = false;
            }
            if (telp.val().trim() === "") {
                toastr.warning("Nomor Telepon tidak boleh kosong");
                isValid = false;
            }
            if (wa.val().trim() === "") {
                toastr.warning("Nomor WhatsApp tidak boleh kosong");
                isValid = false;
            }
            if (email.val().trim() === "") {
                toastr.warning("Email tidak boleh kosong");
                isValid = false;
            }

            if (wali.val().trim() === "") {
                toastr.warning("Nama Wali tidak boleh kosong");
                isValid = false;
            }

            if (alamat_wali.val().trim() === "") {
                toastr.warning("Alamat Wali tidak boleh kosong");
                isValid = false;
            }

            if (telp_wali.val().trim() === "") {
                toastr.warning("Telp Wali tidak boleh kosong");
                isValid = false;
            }
        @endif

        if (isValid) {
            $('#editform').submit()
        }
    }
</script>
