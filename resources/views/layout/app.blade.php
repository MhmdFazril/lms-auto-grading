@include('layout.header')

<body class="font-poppins">
    @include('components.navbar')

    @yield('content')

    {{-- cdn jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- cdn toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- cdn loader --}}
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay"></script>

    @include('components.toast')

    <script src="{{ asset('js/customFunc.js') }}"></script>


    @if (!empty($script) && file_exists(resource_path('views/script/' . $script . '.blade.php')))
        @include('script.' . $script)
    @endif

</body>

</html>
