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
                action="{{ route('course.content.update-question', ['course' => $course_id, 'courseContents' => $content_id, 'quizQuestion' => $question->id, 'question_type' => $question_type]) }}"
                method="post" id="addform" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Soal</div>
                    <div class="collapse-content text-sm grid grid-cols-1 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Soal <x-tooltip message="required" /></label>
                            <input id="question_text" type="hidden" name="question_text"
                                value="{{ old('question_text', $question->question_text) }}">
                            <trix-editor input="question_text" class="trix-editor h-40 p-3"></trix-editor>
                            @error('question_text')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-100 border-5 border-gray-100 rounded-md p-3">
                            <label class="block mb-1">Kunci jawaban <x-tooltip message="required" /></label>
                            <input id="correct_answer" type="hidden" name="correct_answer"
                                value="{{ old('correct_answer', $question->correct_answer) }}">
                            <trix-editor input="correct_answer" class="trix-editor h-40 p-3 bg-white"></trix-editor>
                            @error('correct_answer')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block mb-1">Bobot soal (0-100) <x-tooltip message="required" /></label>
                            <input type="text" class="input w-2/12" onkeyup="onlyNumbers(this)" placeholder="Type here"
                                name="bobot" value="{{ old('bobot', $question->bobot) }}" autocomplete="off"
                                maxlength="3" id="bobot" />
                            @error('bobot')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
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
