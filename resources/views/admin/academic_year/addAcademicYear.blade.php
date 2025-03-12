@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add Academic Year
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form action="{{ route('academic-year.store') }}" method="post" id="addform" enctype="multipart/form-data"
                class="space-y-3">
                @csrf
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Tahun Akademik</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Tahun ajar <x-tooltip message="required" /></label>
                            <div class="flex gap-2">
                                <input type="text" class="input w-full" placeholder="Type here" name="tahun1"
                                    value="{{ old('tahun1') }}" onkeyup="onlyNumbers(this)" autocomplete="off"
                                    maxlength="4" id="tahun1" />
                                <label class="leading-10">/</label>
                                <input type="text" class="input w-full" placeholder="Type here" name="tahun2"
                                    value="{{ old('tahun2') }}" onkeyup="onlyNumbers(this)" autocomplete="off"
                                    maxlength="4" id="tahun2" />
                            </div>
                            @error('tahun1')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror

                            @error('tahun2')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block mb-1">Catatan</label>
                            <textarea placeholder="Type here ...." name="catatan" class="textarea w-full textarea-md resize-none">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <a href="{{ route('site-admin') }}" class="btn btn-info text-white"><i
                            class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
