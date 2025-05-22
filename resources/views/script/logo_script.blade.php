<script>
    let logo = @json($logo);
    let favicon = @json($favicon);

    let logo_file = logo ? logo.file : '';
    let logo_size = logo ? logo.size : '';
    let logo_path = logo ? logo.path : '';

    let favicon_file = favicon ? favicon.file : '';
    let favicon_size = favicon ? favicon.size : '';
    let favicon_path = favicon ? favicon.path : '';



    $(document).ready(function() {

        let dropzone = new Dropzone('.dropzone', {
            acceptedFiles: 'image/*',
            // autoProcessQueue: false,
            addRemoveLinks: true,
            maxFiles: 1,
        })

        let dropzone2 = new Dropzone('#favicon-dropzone', {
            acceptedFiles: 'image/*',
            // autoProcessQueue: false,
            addRemoveLinks: true,
            maxFiles: 1,
        })

        if (logo_file != '') {
            showImage(logo_file, logo_size, logo_path, dropzone);
            dropzone.disable()
        }
        if (favicon_file != '') {
            showImage(favicon_file, favicon_size, favicon_path, dropzone2);
            dropzone2.disable()
        }

        dropzone.on("removedfile", file => {
            dropzone.enable()

            let formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}"); // CSRF Laravel
            formData.append("filename", file.name);

            sendAjax("{{ route('logos.destroy') }}", formData)
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

        });

        dropzone2.on("removedfile", file => {
            dropzone2.enable()

            let formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}"); // CSRF Laravel
            formData.append("filename", file.name);

            sendAjax("{{ route('favicon.destroy') }}", formData)
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

        });
    })

    function showImage(file_name, file_size, file_path, dropzoneElement) {
        if (!dropzoneElement) {
            console.error(`Dropzone instance not found for: #${dropzoneElement}`);
            return;
        }

        let mockFile = {
            name: file_name,
            size: file_size
        };

        let imageUrl = `/storage/${file_path}`;

        dropzoneElement.displayExistingFile(mockFile, imageUrl);
    }
</script>
