@extends('layout.app')

@section('content')
    <div class="p-4 space-y-3">
        <div class="breadcrumbs text-sm bg-slate-100 inline-block px-3">
            <ul>
                <li><a href="{{ route('course.show', ['course' => $course->id]) }}">{{ Str::lower($course->nama) }}</a></li>
                <li>{{ Str::lower($content->nama) }}</li>
            </ul>
        </div>
        <section class="flex justify-between items-center px-2">
            <h1 class="text-2xl font-bold">Question</h1>

            <!-- Tombol Tambah Soal -->
            <button class="btn btn-info text-white">+ Tambah Soal</button>
        </section>

        <!-- List Soal -->
        <div class="space-y-4">
            <div class="card bg-base-100 shadow-md p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold">1. Contoh soal pertama</p>
                        <p class="text-sm text-gray-500">Tipe: Pilihan Ganda</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil text-gray-50"></i></button>
                        <button class="btn btn-sm btn-error"><i class="fa-solid fa-trash text-gray-50"></i></button>
                    </div>
                </div>
            </div>

            {{-- <div class="card bg-base-100 shadow-md p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold">2. Contoh soal kedua</p>
                        <p class="text-sm text-gray-500">Tipe: Esai</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-error">Hapus</button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Modal Tambah Soal -->
    <dialog id="modal-add-question" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Tambah Soal</h3>

            <form>
                <!-- Input Pertanyaan -->
                <div class="mb-2">
                    <label class="block font-semibold">Pertanyaan</label>
                    <textarea class="textarea textarea-bordered w-full"></textarea>
                </div>

                <!-- Tombol Simpan -->
                <div class="mt-4 flex space-x-2">
                    <button class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn"
                        onclick="document.getElementById('modal-add-question').close()">Batal</button>
                </div>
            </form>
        </div>
    </dialog>
@endsection
