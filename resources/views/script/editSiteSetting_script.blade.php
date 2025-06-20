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
                    $("#image").show().attr("src", e.target.result);
                    $('#text-image').hide()
                    $("#removeImage").removeClass("hidden");
                };
                $('#remove_image').val(0);
                reader.readAsDataURL(file);
            }
        });

        $("#removeImage").on("click", function(e) {
            $("#image").hide();
            $('#text-image').show()
            $("#gambar").val("");
            $('#remove_image').val(1);
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
