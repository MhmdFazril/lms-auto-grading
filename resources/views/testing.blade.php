<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- cdn fontawesome --}}
    <script src="https://kit.fontawesome.com/0b6be34a48.js" crossorigin="anonymous"></script>

    {{-- cdn toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <button class="btn btn-info" onclick="toastrNotif(this, 'testing Info notification')">Info</button>
    <button class="btn btn-success" onclick="toastrNotif(this, 'testing Success notification')">Success</button>
    <button class="btn btn-warning" onclick="toastrNotif(this, 'testing Warning notification')">Warning</button>
    <button class="btn btn-error" onclick="toastrNotif(this, 'testing Error notification')">Error</button>
</body>


{{-- cdn jquery --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

{{-- cdn toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $(document).ready(function() {

    })

    // function toastrShow(type, text = 'testing') {
    //     toastr.type(text);
    // }


    function toastrNotif(element, message) {
        let type = $(element).text()

        toastr.options = {
            closeButton: true, // Menampilkan tombol close (X)
            progressBar: true, // Menampilkan progress bar
            positionClass: "toast-bottom-right", // Posisi notifikasi
            timeOut: "3000", // Durasi tampil (dalam ms, 3000 = 3 detik)
            extendedTimeOut: "1000", // Durasi tambahan jika di-hover
            showEasing: "swing", // Efek saat muncul
            hideEasing: "linear", // Efek saat menghilang
            showMethod: "fadeIn", // Efek animasi saat muncul
            hideMethod: "fadeOut", // Efek animasi saat menghilang
        };

        // toastr.options.onclick = function() {
        //     console.log('clicked');
        // }

        switch (type) {
            case 'Success':
                toastr.success(message, 'Success');
                break;
            case 'Error':
                toastr.error(message, 'Error');
                break;
            case 'Warning':
                toastr.warning(message, 'Warning');
                break;
            case 'Info':
                toastr.info(message, 'Info');
                break;
            default:
                toastr.info('Jenis notifikasi tidak dikenali');
        }
    }
</script>

</html>
