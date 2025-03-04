<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Elearning Grafika YL</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- cdn fontawesome --}}
    <script src="https://kit.fontawesome.com/0b6be34a48.js" crossorigin="anonymous"></script>

    {{-- cdn toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-white">
    <div class="navbar bg-base-100 shadow-sm">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">E-Learning Grafika YL</a>
        </div>
        <div class="flex-none">
            <button class="btn btn-info">Login</button>
        </div>
    </div>















    {{-- cdn jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- cdn toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        @if (session('successToast'))
            toastr.success("{{ session('successToast') }}");
        @endif

        @if (session('errorToast'))
            toastr.error("{{ session('errorToast') }}");
        @endif

        @if (session('infoToast'))
            toastr.info("{{ session('infoToast') }}");
        @endif

        @if (session('warningToast'))
            toastr.warning("{{ session('warningToast') }}");
        @endif
    </script>

    <script src="js/customFunc.js"></script>
</body>

</html>
