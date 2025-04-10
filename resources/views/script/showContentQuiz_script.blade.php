<script>
    $(document).on('click', '.question_type', function() {
        let sectionText = $(this).val()
        let sectiondeskripsi = $(this).closest('#section-question').next('#section-deskripsi')

        sectiondeskripsi.children().hide();
        sectiondeskripsi.find('#' + sectionText).show()
    })

    $(document).on('click', '.btn-add-question', function() {
        let course_id = $('#course_id').val()
        let content_id = $('#content_id').val()
        let tipe = $('.question_type:checked').val();

        window.location.href =
            "{{ route('course.content.create-question', ['course' => '__course_id__', 'courseContents' => '__content_id__', 'question_type' => '__tipe__']) }}"
            .replace('__course_id__', course_id)
            .replace('__content_id__', content_id)
            .replace('__tipe__', tipe);
    })

    $(document).on('click', '.btn-import', function(e) {
        e.preventDefault()
        $('#import_modal')[0].close();

        loading()
        $('#formImport').submit()
    })

    $(document).on('click', '.close-import', function(e) {
        e.preventDefault()
        $('#import_modal')[0].close();
    })


    function modalDelete(elem, id) { // untuk student attempt
        event.preventDefault();
        let form = $('#deleteForm');

        form.attr("action", `/admin/major/${id}`);
        $("#deleteModal")[0].showModal();

        $('#deleteConfirm').on('click', function() {
            form.submit()
        })
    }
</script>
