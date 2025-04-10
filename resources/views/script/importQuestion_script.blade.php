<script>
    let errorInfo = @json($errorsInfo)

    console.log(errorInfo);
    for (let i = 0; i < errorInfo.length; i++) {
        toastr.error(errorInfo[i]);
    }
</script>
