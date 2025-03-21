<script>
    function insert() {
        let wali_kelas = $('#wali_kelas').val()
        if (wali_kelas == null) {
            toastr.warning('Pilih guru kelas terlebih dahulu')
            return
        }

        let selected = [];

        $('.user-students:checked').each(function() {
            selected.push($(this).data('id'));
        });

        if (selected.length == 0) {
            return
        }

        let formData = new FormData();
        formData.append("students", selected);
        formData.append("wali_kelas", wali_kelas);
        formData.append("id_class", $('#id_class').text());

        $('.user-students:checked').each(function() {
            let tr = $(this).closest('tr');
            $('#table-class').show()
            $('#empty-text').hide()
            $('#table-class tbody').append(tr);

            $(this).prop("checked", false);
        })

        sendAjax("{{ route('sclass.insert') }}", formData)
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            })
            .catch(error => {
                toastr.error("Terjadi kesalahan sistem");
            });
    }


    function filter(val) {
        let formData = new FormData()

        let studentTable = $('#table-students tbody')
        let classTable = $('#table-class tbody')

        formData.append('filter', $('#id_class').text())


        loading()
        sendAjax("{{ route('sclass.filter') }}", formData)
            .then(response => {
                unloading()
                if (response.success) {
                    studentTable.empty()

                    response.data.forEach(item => {
                        studentTable.append(`
                        <tr>
                            <th>
                                <input type="checkbox" class="checkbox user-students" 
                                data-id="${item.id}"/>
                            </th>
                            <td>${item.nama}</td>
                            <td>${item.major.nama}</td>
                        </tr>`)
                    });

                }
            })
            .catch(error => {
                unloading()
                // console.log(error);
                toastr.error("Terjadi kesalahan sistem");
            });
    }


    function saveGuru(val) {
        let formData = new FormData();
        formData.append('id_class', $('#id_class').text())
        formData.append('teacher', val)

        sendAjax("{{ route('sclass.saveTeacher') }}", formData)
            .then(response => {
                if (response) {
                    alert('success');
                }
            })
            .catch(error => {
                // console.log(error);
                toastr.error("Terjadi kesalahan sistem");
            });
    }
</script>
