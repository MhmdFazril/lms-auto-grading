@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Logos
                </h3>
                {{-- <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span> --}}
            </section>

            <div class="collapse collapse-plus bg-base-100 border border-base-300">
                <input type="checkbox" class="dropdownAcc" checked="checked" />
                <div class="collapse-title font-semibold text-white bg-grf-primary">Logo </div>
                <div class="collapse-content text-sm grid grid-cols-1 gap-4 mt-4">
                    <div>
                        <section class="flex justify-between">
                            <label class="block mb-1">Logo</label>
                            <label class="text-red-500">Accepted file types: JPEG, PNG, JPG, SVG</label>
                        </section>
                        <form action="{{ route('logos.store') }}" method="post" class="dropzone" id="logo-dropzone">
                            @csrf
                        </form>
                        @error('file')
                            <p class="mt-2 text-red-500">{{ $message }}</p>
                        @enderror
                        <span class="italic font-light text-xs">A full logo to be used for main image and for login page
                            image
                        </span>
                    </div>

                    <div>
                        <section class="flex justify-between">
                            <label class="block mb-1">Favicon</label>
                            <label class="text-red-500">Accepted file types: JPEG, PNG, JPG, SVG, ICO</label>
                        </section>
                        <form action="{{ route('favicon.store') }}" method="post" class="dropzone" id="favicon-dropzone">
                            @csrf
                        </form>
                        <span class="italic font-light text-xs">The favicon is displayed next to the page title in the
                            browser tab.
                        </span>

                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-5">
                <a href="{{ route('site-admin') }}" class="btn btn-info text-white"><i class="fa-solid fa-xmark"></i></a>
                <button type="submit" class="btn btn-success text-white"><i class="fa-solid fa-floppy-disk"></i></button>
            </div>
        </div>
    </div>
@endsection
