<script>
    $(document).ready(function() {
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
</script>
