@extends('layout.app')

@section('content')

    <div class="flex justify-between">
        <div class="breadcrumbs text-sm bg-slate-100 inline-block px-3 mx-4 mt-4">
            <ul>
                <li><a href="{{ route('course.show', ['course' => $course->id]) }}">{{ Str::lower($course->nama) }}</a>
                </li>
                <li>{{ Str::lower($content->nama) }}</li>
            </ul>
        </div>

        <button class="mx-4 mt-4 btn btn-accent text-white {{ count($studentAttempt) > 0 ? 'block' : 'hidden' }}"
            onclick="finishAll(this, {{ $content->id }})">Finish
            Review All</button>
    </div>

    @error('file')
        <div role="alert" class="alert alert-error mx-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $message }}</span>
        </div>
    @enderror


    <div class="tabs tabs-border m-5">
        <!-- Student Attempt -->
        <input type="radio" name="quiz_tabs" class="tab" aria-label="Student Attempt" checked />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <div class="overflow-x-auto">
                <table class="table table-zebra" id="table-attempt">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Start Time</th>
                            <th>Finish Time</th>
                            <th class="text-center">Score</th>
                            {{-- <th>Feedback</th> --}}
                            <th class="text-center">Finish Review</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentAttempt as $attempt)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $attempt->student->nama }}</td>
                                <td>{{ date('d-m-Y, H:i:s', strtotime($attempt->start_time)) }}</td>
                                <td>{{ date('d-m-Y, H:i:s', strtotime($attempt->end_time)) }}</td>
                                <td class="text-center">{{ $attempt->score ?? '--' }}</td>
                                <td class="text-center" id="review" data-attempt="{{ $attempt->id }}"
                                    data-content="{{ $content->id }}">
                                    @if ($attempt->review)
                                        <div class="badge cursor-pointer badge-success text-white">Yes</div>
                                    @else
                                        <div class="badge cursor-pointer badge-error text-white">No</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('course.content.correct-question', ['course' => $course->id, 'courseContents' => $content->id, 'quizAttempt' => $attempt->id]) }}"
                                        class="btn bg-blue-700 btn-xs">
                                        <i class="fa-solid fa-check-to-slot text-white"></i>
                                    </a>
                                    <form method="post" class="inline-block" id="deleteForm">
                                        @method('delete')
                                        @csrf
                                        <button class="btn bg-red-600 btn-xs"
                                            onclick="modalDelete(this, {{ $attempt->id }})"><i
                                                class="fa-solid fa-trash text-white"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Question -->
        <input type="radio" name="quiz_tabs" class="tab" aria-label="Question" />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section class="flex justify-between items-center px-2">
                <h1 class="text-2xl font-bold">Question</h1>

                <!-- Tombol Tambah Soal -->
                <div>
                    <button class="btn btn-accent text-white" onclick="import_modal.showModal()">
                        <i class="fa-solid fa-cloud-arrow-down"></i>Import Soal
                    </button>
                    <button class="btn btn-info text-white" onclick="question_modal.showModal()"><i
                            class="fa-solid fa-plus"></i> Tambah Soal</button>
                </div>
            </section>

            <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
            <input type="hidden" name="content_id" id="content_id" value="{{ $content->id }}">

            @if ($question->count() == 0)
                <h2 class="text-lg italic font-light p-3">No question available yet</h2>
            @else
                @foreach ($question as $question)
                    <div class="space-y-4">
                        <div class="card bg-base-100 shadow-md p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ strip_tags($question->question_text) }}</p>
                                    <p class="text-sm text-gray-500">Tipe: {{ $question->question_type }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('course.content.edit-question', ['course' => $course->id, 'courseContents' => $content->id, 'quizQuestion' => $question->id, 'question_type' => $question->question_type]) }}"
                                        class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil text-gray-50"></i></a>

                                    <a href="{{ route('course.content.delete-question', ['course' => $course->id, 'courseContents' => $content->id, 'question' => $question->id]) }}"
                                        class="btn btn-sm btn-error"><i class="fa-solid fa-trash text-gray-50"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

    {{-- modal question --}}
    <dialog id="question_modal" class="modal">
        <div class="modal-box p-0 max-w-lg min-h-10/12">
            <h3 class="text-lg font-bold p-5">Add question type</h3>

            <div class="grid grid-cols-2 mt-4 ">
                <div class="bg-slate-200 p-3 space-y-4" id="section-question">
                    <section class="space-x-2">
                        <input type="radio" checked name="question_type" class="question_type" value="multiple"
                            id="multiple">
                        <label for="multiple">
                            <i class="fa-solid fa-list"></i>
                            <span>Multiple choose</span>
                        </label>
                    </section>

                    <section class="space-x-2">
                        <input type="radio" name="question_type" class="question_type" value="essay" id="essay">
                        <label for="essay">
                            <i class="fa-solid fa-file-lines"></i>
                            <span>Essay</span pan>
                        </label>
                    </section>
                </div>

                <div class="p-3" id="section-deskripsi">
                    <section id="multiple">
                        Allows the selection of a single or multiple responses from a pre-defined list.
                    </section>
                    <section id="essay" class="hidden">
                        Allows a response of a file upload and/or online text. This must then be graded manually.
                    </section>
                </div>
            </div>

            <div class="modal-action absolute bottom-3 right-3">
                <form method="dialog">
                    <button class="btn btn-info text-white">Close</button>
                    <button class="btn btn-accent text-white btn-add-question">Add</button>
                </form>
            </div>

            <span class="hidden" id="sect_id"></span>
            <span class="hidden" id="course_id"></span>
        </div>
    </dialog>


    {{-- modal import --}}
    <dialog id="import_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Import File</h3>
            <p class="mt-4">Pilih file soal yang ingin Anda import</p>
            <a href="{{ asset('formatExcel/QuestionImportFormat.xlsx') }}" download="QuestionImportFormat.xlsx"
                class="italic text-light text-green-600 mb-4 block">
                <i class="fa-solid fa-file-excel"></i>
                Klik disini untuk download format
            </a>
            <!-- Form -->
            <form method="post" id="formImport"
                action="{{ route('import.question.upload', ['course' => $course->id, 'courseContent' => $content->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input type="file" id="file" name="file" class="file-input file-input-bordered w-full"
                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                </div>
                <div class="modal-action">
                    <button class="btn btn-primary btn-import">Import</button>
                    <button class="btn close-import">Close</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal review -->
    <dialog id="review_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box space-y-4">
            <h3 class="text-xl font-bold text-center text-red-500">
                ⚠️ Konfirmasi Tindakan
            </h3>
            <p class="text-base text-gray-700 leading-relaxed text-justify">
                Apakah Anda yakin ingin melanjutkan tindakan ini? Tindakan ini akan memberikan akses kepada siswa
                untuk melihat hasil quiz yang telah dinilai. Pastikan Anda sudah melakukan penilaian dengan benar
                sebelum melanjutkan.
            </p>
            <div class="modal-action justify-center gap-4">
                <button class="btn btn-success text-white px-6" id="confirm_review">Ya, Saya Yakin</button>
                <button class="btn btn-outline" onclick="document.getElementById('review_modal').close()">Batal</button>
            </div>
        </div>
    </dialog>





    <x-modal.delete id="deleteModal" title="Konfirmasi hapus"
        message="Apakah Anda yakin ingin menghapus data ini? semua data yang berhubungan dengan data ini akan dihapus"
        confirmId="deleteConfirm" />
@endsection
