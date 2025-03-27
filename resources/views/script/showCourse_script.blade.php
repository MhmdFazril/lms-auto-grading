<script>
    $(document).on('click', '.showHide-btn', function() {
        const sectId = $(this).data('sect-id')
        const btnText = $(this).text().trim()

        let formData = new FormData();

        show = btnText == "Hide" ? '0' : '1'

        formData.append('section_id', sectId);
        formData.append('show', show);

        sendAjax("{{ route('course.section.visibility') }}", formData)
            .then(response => {
                if (response) {
                    toastr.success('berhasil ubah visibility')

                    if (show === '1') {
                        $(this).html('<i class="fa-solid fa-eye-slash"></i> Hide');
                        $(this).closest('.bg-slate-200').find('.badge').addClass('hidden');
                    } else {
                        $(this).html('<i class="fa-solid fa-eye"></i> Show');
                        $(this).closest('.bg-slate-200').find('.badge').removeClass('hidden');
                    }

                }
            })
            .catch(error => {
                toastr.error("Terjadi kesalahan sistem");
            });
    })


    $(document).on('click', '.section-pencil', function() {
        let section = $(this).closest('section');
        let h2 = section.find('h2');
        let currentText = h2.text();

        h2.replaceWith('<input type="text" class="edit-input w-40 input inline-block" data-current-value="' +
            currentText + '" value="' + currentText +
            '" />');

        $(this).closest('span').find('.section-pencil').hide()
        $(this).closest('span').find('.section-cancel, .section-save').show();

        $('.section-pencil').hide();
    })


    $(document).on('click', '.section-cancel', function() {
        let section = $(this).closest('section');
        let input = section.find('.edit-input');
        let currValue = input.data('current-value');


        input.replaceWith('<h2 class="text-xl inline-block text-green-700">' + currValue + '</h2>');

        $('.section-pencil').show();
        $(this).closest('span').find('.section-cancel, .section-save').hide();

    });

    $(document).on('click', '.section-save', function() {
        let section = $(this).closest('section');
        let input = section.find('.edit-input');
        let newText = input.val();

        let formData = new FormData();
        formData.append('section_id', $(this).data('sect-id'))
        formData.append('new_text', newText)

        sendAjax("{{ route('course.section.update-section') }}", formData)
            .then(response => {
                if (response) {
                    input.replaceWith('<h2 class="text-xl inline-block text-green-700">' + newText +
                        '</h2>');
                    $('.section-pencil').show();
                    $(this).closest('span').find('.section-cancel, .section-save').hide();
                }
            })
            .catch(error => {
                toastr.error("Terjadi kesalahan sistem");
            });
    });


    $(document).on('click', '.add-content', function() {

        $('#sect_id').text($(this).data('sect-id'))
        $('#course_id').text($(this).data('course-id'))

        $('#modal-activity')[0].showModal();
    })


    $(document).on('click', '.content', function() {
        let sect_id = $('#sect_id').text();
        let course_id = $('#course_id').text();
        let tipe = $(this).data('tipe');

        window.location.href =
            "{{ route('course.section.add-content', ['course' => '__course_id__', 'courseSection' => '__sect_id__', 'tipe' => '__tipe__']) }}"
            .replace('__course_id__', course_id)
            .replace('__sect_id__', sect_id)
            .replace('__tipe__', tipe);
    });
</script>
