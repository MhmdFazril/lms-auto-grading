<script>
    $(document).ready(function() {

        $("#uploadButton").on("click", function(e) {
            $("#gambar").click();
        });


        $("#gambar").on("change", function(event) {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $("#profileImage").show().attr("src", e.target.result);
                    $('#text-profileImage').hide()
                    $("#removeImage").removeClass("hidden");
                };
                reader.readAsDataURL(file);
            }
        });

        $("#removeImage").on("click", function(e) {
            $("#profileImage").hide();
            $('#text-profileImage').show()
            $("#gambar").val("");
            $(this).addClass("hidden");
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
