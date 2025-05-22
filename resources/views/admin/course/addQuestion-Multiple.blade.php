@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add Question
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form
                action="{{ route('course.content.store-question', ['course' => $course_id, 'courseContents' => $content_id, 'question_type' => $question_type]) }}"
                method="post" id="addform" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Soal</div>
                    <div class="collapse-content text-sm grid grid-cols-1 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Soal <x-tooltip message="required" /></label>
                            <input id="question_text" type="hidden" name="question_text"
                                value="{{ old('question_text') }}">
                            <trix-editor input="question_text" class="trix-editor h-40 p-3"></trix-editor>
                            @error('question_text')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Bobot soal (0-100) <x-tooltip message="required" /></label>
                            <input type="text" class="input w-1/12" onkeyup="onlyNumbers(this)" placeholder="Type here"
                                name="bobot" value="{{ old('bobot') }}" autocomplete="off" maxlength="3"
                                id="bobot" />
                            @error('bobot')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-100 border-5 border-gray-100 rounded-md p-3">
                            <label class="block mb-1">Opsi 1 </label>
                            <input id="opsi1" type="hidden" name="opsi1" value="{{ old('opsi1') }}">
                            <trix-editor input="opsi1" class="trix-editor h-40 p-3 bg-white"></trix-editor>

                            <section class="inline-block mr-4 mb-1 mt-2">
                                <input type="radio" name="correct_answer" class="radio radio-info" value="a"
                                    id="opsi_1" />
                                <label for="opsi_1">Jawaban benar</label>
                            </section>
                            @error('opsi1')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                            @error('correct_answer')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-100 border-5 border-gray-100 rounded-md p-3">
                            <label class="block mb-1">Opsi 2 </label>
                            <input id="opsi2" type="hidden" name="opsi2" value="{{ old('opsi2') }}">
                            <trix-editor input="opsi2" class="trix-editor h-40 p-3 bg-white"></trix-editor>

                            <section class="inline-block mr-4 mb-2 mt-2">
                                <input type="radio" name="correct_answer" class="radio radio-info" value="b"
                                    id="opsi_2" />
                                <label for="opsi_2">Jawaban benar</label>
                            </section>
                            @error('opsi2')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                            @error('correct_answer')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-100 border-5 border-gray-100 rounded-md p-3">
                            <label class="block mb-1">Opsi 3 </label>
                            <input id="opsi3" type="hidden" name="opsi3" value="{{ old('opsi3') }}">
                            <trix-editor input="opsi3" class="trix-editor h-40 p-3 bg-white"></trix-editor>

                            <section class="inline-block mr-4 mb-3 mt-3">
                                <input type="radio" name="correct_answer" class="radio radio-info" value="c"
                                    id="opsi_3" />
                                <label for="opsi_3">Jawaban benar</label>
                            </section>
                            @error('opsi3')
                                <p class="mt-3 text-red-500">{{ $message }}</p>
                            @enderror
                            @error('correct_answer')
                                <p class="mt-3 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-100 border-5 border-gray-100 rounded-md p-3">
                            <label class="block mb-1">Opsi 4 </label>
                            <input id="opsi4" type="hidden" name="opsi4" value="{{ old('opsi4') }}">
                            <trix-editor input="opsi4" class="trix-editor h-40 p-3 bg-white"></trix-editor>

                            <section class="inline-block mr-4 mb-4 mt-4">
                                <input type="radio" name="correct_answer" class="radio radio-info" value="d"
                                    id="opsi_4" />
                                <label for="opsi_4">Jawaban benar</label>
                            </section>
                            @error('opsi4')
                                <p class="mt-4 text-red-500">{{ $message }}</p>
                            @enderror
                            @error('correct_answer')
                                <p class="mt-4 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-100 border-5 border-gray-100 rounded-md p-3">
                            <label class="block mb-1">Opsi 5 </label>
                            <input id="opsi5" type="hidden" name="opsi5" value="{{ old('opsi5') }}">
                            <trix-editor input="opsi5" class="trix-editor h-40 p-3 bg-white"></trix-editor>

                            <section class="inline-block mr-4 mb-5 mt-5">
                                <input type="radio" name="correct_answer" class="radio radio-info" value="e"
                                    id="opsi_5" />
                                <label for="opsi_5">Jawaban benar</label>
                            </section>
                            @error('opsi5')
                                <p class="mt-5 text-red-500">{{ $message }}</p>
                            @enderror
                            @error('correct_answer')
                                <p class="mt-5 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <a href="{{ route('course.content.show-content', ['course' => $course_id, 'courseContents' => $content_id, 'tipe' => 'quiz']) }}"
                        class="btn btn-info text-white"><i class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
