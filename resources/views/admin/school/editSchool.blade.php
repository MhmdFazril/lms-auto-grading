@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add School
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form action="{{ route('school.update', ['school' => $school->id]) }}" method="post" id="addform"
                enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('put')

                <input type="hidden" name="nama_old" id="nama->old" value="{{ $school->nama }}">
                <input type="hidden" name="alamat_old" id="alamat->old" value="{{ $school->alamat }}">
                <input type="hidden" name="remove_image" id="remove_image" value="0">

                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" name="my-accordion-3" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Sekolah</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Nama Sekolah <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                value="{{ old('nama', $school->nama) }}" onkeyup="upCase(this)" autocomplete="off"
                                maxlength="100" id="nama" />
                            @error('nama')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Alamat Lengkap <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="alamat"
                                value="{{ old('alamat', $school->alamat) }}" onkeyup="upCase(this)" autocomplete="off"
                                id="alamat" />
                            @error('alamat')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-1">Alamat Email</label>
                            <input type="text" class="input w-full" placeholder="Email Address" name="email"
                                value="{{ old('email', $school->email) }}" autocomplete="off" id="email" />
                            @error('email')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="collapse collapse-plus border border-base-300">
                    <input type="checkbox" class="dropdownAcc" name="my-accordion-3" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Foto Profile</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div class="flex flex-col items-center">
                            <div class="relative border-2 border-gray-300 overflow-hidden group w-80 h-80">
                                <img id="profileImage"
                                    src="{{ asset($school->gambar ? 'storage/' . $school->gambar : 'img/school-default.png') }}"
                                    alt="Profile Picture" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-gray-300/35 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <span id="uploadButton"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        <i class="fa-solid fa-upload"></i>
                                    </span>
                                    <span id="removeImage"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ml-2 {{ $school->gambar ? '' : 'hidden' }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                </div>
                            </div>
                            @error('gambar')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                            <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden">
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
