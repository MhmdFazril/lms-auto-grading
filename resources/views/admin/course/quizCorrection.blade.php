@extends('layout.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="breadcrumbs text-sm bg-slate-200 inline-block px-3 mb-4">
            <ul>
                <li><a href="{{ route('course.show', ['course' => $course->id]) }}">{{ Str::lower($course->nama) }}</a></li>
                <li><a
                        href="{{ route('course.content.show-content', ['course' => $course->id, 'courseContents' => $content->id, 'tipe' => 'quiz']) }}">{{ Str::lower($content->nama) }}</a>
                </li>
                <li>{{ Str::ucfirst(Str::lower($attempt->student->nama)) }}</li>
            </ul>
        </div>

        <h2 class="text-2xl font-bold mb-6">Penilaian Jawaban Siswa <span class="text-green-500">({{ $content->nama }})</span>
        </h2>

        <!-- Informasi Umum -->
        <div class="mb-8 p-4 flex justify-between bg-gray-100 rounded-lg shadow">
            <section>
                <p><strong>Nama Siswa:</strong> {{ Str::ucfirst(Str::lower($attempt->student->nama)) }}</p>
                <p><strong>Mata Pelajaran:</strong> {{ Str::ucfirst(Str::lower($course->nama)) }}</p>
            </section>
            <section class="text-right">
                <p><strong>Tanggal Pengerjaan:</strong> {{ date('d F Y, H:i:s', strtotime($attempt->start_time)) }}</p>
                <p><strong>Durasi Pengerjaan:</strong> {{ $duration }}</p>
            </section>
        </div>

        <!-- Form Penilaian -->
        <form id="penilaianForm" method="POST" action="#">

            <input type="hidden" name="attempt_id" id="attempt_id" value="{{ $attempt->id }}">
            <input type="hidden" name="student_id" id="student_id" value="{{ $attempt->student->id }}">
            <input type="hidden" name="content_id" id="content_id" value="{{ $content->id }}">

            <div class="space-y-8">
                @foreach ($answer as $answer)
                    <div class="p-6 border rounded-lg shadow bg-white">
                        <!-- Soal -->
                        <p class="font-semibold mb-2 text-indigo-600">Soal {{ $answer->order }} :</p>
                        <p class="mb-4 text-gray-700">{{ $answer->question->question_text }}</p>

                        <!-- Jawaban Siswa -->
                        <p class="font-semibold mb-2 text-indigo-600">Jawaban Siswa:</p>
                        @if ($answer->question->question_type == 'multiple')
                            <div class="mb-4 ml-2 space-y-2">
                                @foreach ($answer->question->option as $key => $val)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" disabled value="{{ $key }}"
                                            {{ $answer->student_answer == $key ? 'checked' : '' }}>
                                        <span>{{ $key }}. {!! $val !!} {!! $answer->question->correct_answer == $key
                                            ? '<span class="text-green-500">✔</span>'
                                            : '<span class="text-red-500">❌</span>' !!}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="mb-4">
                                <input id="student_answer_{{ $answer->id }}" type="hidden"
                                    value="{{ $answer->student_answer }}">
                                <trix-editor input="student_answer_{{ $answer->id }}"
                                    class="trix-editor bg-white p-3 rounded border"></trix-editor>
                            </div>
                        @endif

                        <!-- Kunci Jawaban -->
                        <label class="block mb-1 font-medium text-gray-700">Kunci Jawaban :</label>
                        <input type="text" disabled class="border rounded-md w-full p-2 mb-4 bg-gray-50"
                            value="{{ $answer->question->correct_answer }}">

                        <!-- Skor Manual -->
                        <label class="block mb-1 font-medium text-gray-700">
                            Skor <x-tooltip message="required" />
                        </label>
                        {{-- <input type="number" data-id="{{ $answer->id }}"
                            class="border rounded-md w-full p-2 mb-4 focus:ring focus:ring-indigo-200 score-input"
                            placeholder="Masukkan skor manual" min="0" max="100"
                            value="{{ $answer->question->correct_answer == $answer->student_answer && $answer->question->question_type == 'multiple' ? $answer->question->bobot : '0' }}"> --}}
                        @if ($answer->score == null)
                            <input type="number" data-id="{{ $answer->id }}"
                                class="border rounded-md w-full p-2 mb-4 focus:ring focus:ring-indigo-200 score-input"
                                placeholder="Masukkan skor manual" min="0" max="100"
                                value="{{ $answer->question->correct_answer == $answer->student_answer && $answer->question->question_type == 'multiple' ? $answer->question->bobot : '0' }}">
                        @else
                            <input type="number" data-id="{{ $answer->id }}"
                                class="border rounded-md w-full p-2 mb-4 focus:ring focus:ring-indigo-200 score-input"
                                placeholder="Masukkan skor manual" min="0" max="100"
                                value="{{ $answer->score }}">
                        @endif


                        <!-- Feedback Manual -->
                        <label class="block mb-1 font-medium text-gray-700">Feedback (optional):</label>
                        <textarea name="feedback[]" class="border rounded-md w-full p-2 mb-4 resize-y focus:ring focus:ring-green-200"
                            rows="3" placeholder="Masukkan feedback manual"></textarea>

                        <!-- Tombol AI -->
                        <div class="flex space-x-3">
                            <button type="button"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300 transition-all">
                                🔍 Koreksi Otomatis
                            </button>
                            <button type="button"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:ring focus:ring-green-300 transition-all">
                                💡 Feedback Otomatis
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tombol Simpan Semua -->
            <div class="mt-10 text-end sticky bottom-6 right-0">
                <button id="saveCorrection"
                    class="bg-indigo-600 cursor-pointer text-white px-8 py-3 rounded-md hover:bg-indigo-700 focus:ring focus:ring-indigo-300 transition-all">
                    💾 Simpan Hasil Penilaian
                </button>
            </div>
        </form>
    </div>
@endsection
