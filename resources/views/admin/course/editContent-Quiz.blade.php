@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add Quiz
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form
                action="{{ route('course.content.update-content', ['course' => $course->id, 'courseSection' => $content->id, 'courseContents' => $content->id]) }}"
                method="post" id="addform" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Quiz</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Nama quiz <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                value="{{ old('nama', $content->nama) }}" onkeyup="upCase(this)" autocomplete="off"
                                id="nama" maxlength="100" />
                            @error('nama')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block mb-1">Deskripsi</label>
                            <input id="deskripsi" type="hidden" name="deskripsi"
                                value="{{ old('deskripsi', $content->deskripsi) }}">
                            <trix-editor input="deskripsi" class="trix-editor h-40 p-3"></trix-editor>
                            @error('deskripsi')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="collapse collapse-plus border border-base-300">
                    <input type="checkbox" class="dropdownAcc" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Timing dan lainnya</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Mulai Quiz <x-tooltip message="required" /></label>
                            <input type="datetime-local" class="input w-full" placeholder="Type here" name="open_quiz"
                                value="{{ old('open_quiz', $content->open_quiz) }}" onkeyup="upCase(this)"
                                autocomplete="off" id="open_quiz" />
                            @error('open_quiz')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Selesai Quiz <x-tooltip message="required" /></label>
                            <input type="datetime-local" class="input w-full" placeholder="Type here" name="close_quiz"
                                value="{{ old('close_quiz', $content->close_quiz) }}" onkeyup="upCase(this)"
                                autocomplete="off" id="close_quiz" />
                            @error('close_quiz')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Durasi pengerjaan <x-tooltip message="required" /></label>
                            <div class="grid grid-cols-4 gap-2">
                                <input type="text" class="input w-full" name="time_limit" id="time_limit"
                                    value="{{ old('time_limit', $content->time_limit) }}" autocomplete="off"
                                    onkeyup="onlyNumbers(this)" maxlength="15" />

                                <select class="select w-full col-span-3" name="satuan" id="satuan">
                                    <option value="detik"
                                        {{ old('satuan', $content->satuan) == 'detik' ? 'selected' : '' }}>Detik</option>
                                    <option value="menit"
                                        {{ old('satuan', $content->satuan) == 'menit' ? 'selected' : '' }}>Menit</option>
                                    <option value="jam"
                                        {{ old('satuan', $content->satuan) == 'jam' ? 'selected' : '' }}>Jam</option>
                                </select>
                            </div>
                            @error('time_limit')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                            @error('satuan')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Acak soal </label>
                            <select class="select w-full col-span-3" name="shuffle" id="shuffle">
                                <option value="0" {{ old('shuffle', $content->shuffle) == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                                <option value="1" {{ old('shuffle', $content->shuffle) == '1' ? 'selected' : '' }}>Ya
                                </option>
                            </select>
                            @error('shuffle')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <a href="{{ route('course.show', ['course' => $course->id]) }}" class="btn btn-info text-white"><i
                            class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
