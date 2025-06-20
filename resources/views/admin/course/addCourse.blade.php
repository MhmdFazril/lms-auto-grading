@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add Course
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form action="{{ route('course.store') }}" method="post" id="addform" enctype="multipart/form-data"
                class="space-y-3">
                @csrf
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Informasi umum</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Nama Pelajaran <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                value="{{ old('nama') }}" onkeyup="upCase(this)" autocomplete="off" maxlength="100"
                                id="nama" />
                            @error('nama')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Aktif pada <x-tooltip message="required" /></label>
                            <input type="datetime-local" class="input w-full" placeholder="Type here" name="start_date"
                                value="{{ old('start_date') }}" onkeyup="upCase(this)" autocomplete="off" id="start_date" />
                            @error('start_date')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Berakhir pada <x-tooltip message="required" /></label>
                            <input type="datetime-local" class="input w-full" placeholder="Type here" name="end_date"
                                value="{{ old('end_date') }}" onkeyup="upCase(this)" autocomplete="off" id="end_date" />
                            @error('end_date')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Pengajar <x-tooltip message="required" /></label>
                            <select class="select w-full" name="teacher_id" id="teacher_id">
                                <option disabled selected>Pilih pengajar</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Jurusan <x-tooltip message="required" /></label>
                            <select class="select w-full" name="major_id" id="major_id">
                                <option disabled selected>Pilih jurusan</option>
                                <option value="0">Gabungan</option>
                                @foreach ($majors as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ old('major_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('major_id')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Jumlah section (perminggu)</label>
                            <input type="text" class="input w-full" placeholder="Number of section" name="section"
                                value="{{ old('section', '18') }}" onkeyup="onlyNumbers(this)" autocomplete="off"
                                maxlength="2" id="section" />
                            @error('section')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Lainnya</div>
                    <div class="collapse-content text-sm grid grid-cols-1 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Deskripsi</label>
                            <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi') }}">
                            <trix-editor input="deskripsi" class="trix-editor h-40 p-3"></trix-editor>
                            @error('deskripsi')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Gambar course </label>
                            <div class="relative border-2 border-gray-300 overflow-hidden group w-80 h-80">
                                <img id="profileImage" alt="Profile Picture" class="w-full h-full object-cover hidden">
                                <p class="p-4" id="text-profileImage">klik untuk memilih gambar</p>
                                <div
                                    class="absolute inset-0 bg-gray-300/35 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <span id="uploadButton"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        <i class="fa-solid fa-upload"></i>
                                    </span>
                                    <span id="removeImage"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ml-2 hidden">
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
                    <a href="{{ route('course.index') }}" class="btn btn-info text-white"><i
                            class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
