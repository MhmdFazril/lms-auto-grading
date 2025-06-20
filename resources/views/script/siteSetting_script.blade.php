<script>
    function modalDelete(elem, id) {
        event.preventDefault();
        let form = $('#deleteForm');

        form.attr("action", `/admin/site-setting/destroy/${id}`);
        $("#deleteModal")[0].showModal();

        $('#deleteConfirm').on('click', function() {
            form.submit()
        })
    }
</script>
