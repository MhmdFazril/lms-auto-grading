<script>
    $(document).ready(function() {
        let table = $('#tableUser').DataTable({
            responsive: true,
            lengthMenu: [10, 25, 50, 100], // Pilihan jumlah data per halaman
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ data per page",
                info: "Show _START_ until _END_ from _TOTAL_ data",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Before"
                }
            },
            stripeClasses: ["odd-row", "even-row"], // Menambahkan class CSS kustom
        });

        // Apply filter saat tombol ditekan
        $('#applyFilter').on('click', function() {
            let role = $('#filterRole').val();
            let status = $('#filterStatus').val();

            table.column(3).search(role).column(4).search(status).draw();
            // table.column(3).search(role).draw();
        });
    });


    function modalDelete(elem, id) {
        event.preventDefault();
        let form = $('#deleteForm');

        form.attr("action", `/admin/academic-year/${id}`);
        $("#deleteModal")[0].showModal();

        $('#deleteConfirm').on('click', function() {
            form.submit()
        })
    }
</script>
