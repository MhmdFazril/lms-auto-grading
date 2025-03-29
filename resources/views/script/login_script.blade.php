<script>
    $(document).on('click', '#togglePassword', function() {
        if ($(this).hasClass('fa-eye')) {
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            $('input[name="password"]').attr('type', 'text')
        } else {
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            $('input[name="password"]').attr('type', 'password')
        }
    })
</script>
