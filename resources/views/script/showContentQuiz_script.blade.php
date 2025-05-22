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

    $(document).on('click', '#review', function() {
        let $this = $(this); // simpan referensi tombol yang diklik
        let text = $this.find('.badge').text().trim();

        const formData = new FormData();
        formData.append("content_id", $this.data('content'));
        formData.append("attempt_id", $this.data('attempt'));
        formData.append("text", text);

        if (text === 'No') {
            $('#review_modal')[0].showModal();
            $('#review_modal .btn-success').off('click').on('click', function() {

                $('#review_modal')[0].close();

                sendAjax("{{ route('quiz.attempt.update-review') }}", formData)
                    .then(response => {
                        if (response.success) {
                            toastr.success(response.message);
                            $this.find('.badge').text(response.review);
                            if (response.review === 'No') {
                                $this.find('.badge').removeClass('badge-success').addClass(
                                    'badge-error');
                            } else {
                                $this.find('.badge').removeClass('badge-error').addClass(
                                    'badge-success');
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    })
                    .catch(error => {
                        toastr.error("Terjadi kesalahan sistem");
                    });
            });

        } else {
            sendAjax("{{ route('quiz.attempt.update-review') }}", formData)
                .then(response => {
                    if (response.success) {
                        toastr.success(response.message);
                        $this.find('.badge').text(response.review);
                        if (response.review === 'No') {
                            $this.find('.badge').removeClass('badge-success').addClass('badge-error');
                        } else {
                            $this.find('.badge').removeClass('badge-error').addClass('badge-success');
                        }
                    } else {
                        toastr.error(response.message);
                    }
                })
                .catch(error => {
                    toastr.error("Terjadi kesalahan sistem");
                });
        }
    });


    function finishAll(buttonElement, content) {
        let $btn = $(buttonElement); // pastikan jadi jQuery object
        let color = $btn.hasClass('btn-accent');

        let all = color; // jika btn-accent berarti true, sebaliknya false

        const formData = new FormData();
        formData.append("content_id", content);
        formData.append("all", all);

        if (color) {
            $('#review_modal')[0].showModal();

            $('#review_modal .btn-success').off('click').on('click', function() {
                sendAjax("{{ route('quiz.attempt.update-review-all') }}", formData)
                    .then(response => {
                        if (response.success) {
                            toastr.success(response.message);

                            $('#table-attempt tbody tr').each(function() {
                                const reviewTd = $(this).find('td#review');
                                const badgeDiv = reviewTd.find(
                                    'div.badge-error');

                                if (badgeDiv.length > 0) {
                                    badgeDiv
                                        .removeClass('badge-error')
                                        .addClass('badge-success')
                                        .text('Yes');
                                }
                            });

                        } else {
                            toastr.error(response.message);
                        }
                    })
                    .catch(error => {
                        toastr.error("Terjadi kesalahan sistem");
                    });
            });

        } else {
            sendAjax("{{ route('quiz.attempt.update-review-all') }}", formData)
                .then(response => {
                    if (response.success) {
                        toastr.success(response.message);
                        $btn.removeClass('btn-info').addClass('btn-accent');
                    } else {
                        toastr.error(response.message);
                    }
                })
                .catch(error => {
                    toastr.error("Terjadi kesalahan sistem");
                });
        }
    }


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
