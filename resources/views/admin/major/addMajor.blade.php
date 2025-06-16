@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add Major
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form action="{{ route('major.store') }}" method="post" id="addform" enctype="multipart/form-data"
                class="space-y-3">
                @csrf
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Jurusan</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Nama jurusan <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                value="{{ old('nama') }}" onkeyup="upCase(this)" autocomplete="off" id="nama"
                                maxlength="100" />
                            @error('nama')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block mb-1">Deskripsi</label>
                            <textarea placeholder="Type here ...." name="deskripsi" class="textarea w-full textarea-md resize-none">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <a href="{{ route('major.index') }}" class="btn btn-info text-white"><i
                            class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
