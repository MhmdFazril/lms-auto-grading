<script>
    let studentItem = [];

    function modalDelete(elem, id) {
        event.preventDefault();
        let form = $('#deleteForm');

        form.attr("action", `/course/${id}`);
        $("#deleteModal")[0].showModal();

        $('#deleteConfirm').on('click', function() {
            form.submit()
        })
    }

    function getParticipant(courseId = '', filter = 'all') {
        if (courseId != '') {
            $('#course_id').text(courseId);
        }

        let formData = new FormData();
        formData.append('filter', filter);
        formData.append('course_id', $('#course_id').text());

        loading()
        sendAjax("{{ route('course.getParticipant') }}", formData)
            .then(response => {
                $('#table-participant tbody').empty()
                unloading()
                if (response) {
                    response.students.forEach(item => {
                        const isChecked = response.selectedItem.includes(item.id);
                        studentItem = response.selectedItem
                        $('#table-participant tbody').append(`
                            <tr>
                                <td><input type="checkbox" class="checkbox student-checkbox" data-student-id="${item.id}" ${isChecked ? 'checked' : ''}></td>
                                <td>${item.nama}</td>
                                <td>${item.mclass_nama}</td>
                                <td>${item.major.nama}</td>
                            </tr>
                            
                        `)
                    });

                    $("#participantModal")[0].showModal();

                    $(".btn-save-participant").attr('onClick', `saveParticipant(${courseId})`)
                }
            })
            .catch(error => {
                unloading()
                // console.log(error);
                toastr.error("Terjadi kesalahan sistem");
            });
    }


    function saveParticipant(courseId) {
        let selectedItem = [];
        $('.student-checkbox:checked').each(function() {
            selectedItem.push($(this).data('student-id'));
        })

        let formData = new FormData();
        formData.append('course_id', courseId)
        formData.append('item', selectedItem)
        formData.append('oldItem', studentItem)

        if (selectedItem.length <= 0) {
            return
        }

        sendAjax("{{ route('course.saveParticipant') }}", formData)
            .then(response => {
                $('#participantModal')[0].close();

                if (response) {
                    toastr.success('berhasil menambahkan data')
                    studentItem = response.selectedItem;
                }
            })
            .catch(error => {
                $('#participantModal')[0].close();

                toastr.error("Terjadi kesalahan sistem");
            });
    }
</script>
