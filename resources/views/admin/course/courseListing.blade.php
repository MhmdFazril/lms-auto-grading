@extends('layout.app')
@section('content')
    <div class="p-4 m-5">
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-0 justify-between mb-4">
            <a href="{{ route('site-admin') }}" class="btn btn-primary max-w-16 mb-4">Back</a>
            <div class="sm:flex sm:gap-2">
                <select class="select w-60" name="jurusan" id="jurusan" onchange="filter(this.value)">
                    <option selected value="all">All</option>
                    <option value="campuran">Campuran</option>
                    @foreach ($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->nama }}</option>
                    @endforeach
                </select>
                <a href="{{ route('course.create') }}" class="btn btn-success text-white">Add Course</a>
            </div>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 rounded-xl p-2 border-2 border-gray-200">
            @if ($courses->count() == 0)
                <h2 class="italic font-light p-3">no course available yet</h2>
            @else
                @foreach ($courses as $course)
                    <div class="card bg-white shadow-sm border border-gray-100 hover:shadow-xl transition">
                        <figure class="max-h-36">
                            <a href="{{ route('course.show', ['course' => $course->id]) }}">
                                <img src="{{ asset($course->gambar) }}" alt="{{ $course->nama }}" />
                            </a>
                        </figure>
                        <div class="card-body">
                            <span
                                class="text-xs font-light">{{ $course->academic->tahun1 . '/' . $course->academic->tahun2 }}</span>
                            <h2 class="card-title">
                                <a href="{{ route('course.show', ['course' => $course->id]) }}">{{ $course->nama }}</a>
                            </h2>
                            <p>{!! $course->deskripsi !!}</p>
                            <div class="card-actions justify-end">
                                <div class="dropdown">
                                    <div tabindex="0" role="button" class="m-1 cursor-pointer"><i
                                            class="fa-solid fa-ellipsis fa-rotate-90"></i></div>
                                    <ul tabindex="0"
                                        class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-xl border-2 border-gray-100">
                                        <li><a onclick="getParticipant({{ $course->id }})">Participants</a></li>
                                        <li><a href="{{ route('course.edit', ['course' => $course->id]) }}">Edit course</a>
                                        </li>
                                        <form method="post" class="inline-block" id="deleteForm">
                                            @method('delete')
                                            @csrf
                                            <li><a onclick="modalDelete(this, {{ $course->id }})">Delete course</a></li>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

    <x-modal.delete id="deleteModal" title="Konfirmasi hapus"
        message="Apakah Anda yakin ingin menghapus course ini? Menghapus course ini berakibat menghapus semua konten didalamnya"
        confirmId="deleteConfirm" />

    <dialog id="participantModal" class="modal">
        <div class="modal-box w-11/12 h-11/12 max-w-5xl">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold">Participant</h3>
                <!-- Filter Jurusan -->
                <select class="select select-bordered w-48" id="departmentFilter" onchange="getParticipant('', this.value)">
                    <option value="all" selected>All</option>
                    @foreach ($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->nama }}</option>
                    @endforeach
                </select>
            </div>

            <p class="py-4">Pilih siswa</p>

            <!-- Tabel Daftar User -->
            <div class="overflow-x-auto h-7/12">
                <table class="table table-zebra w-full" id="table-participant">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama User</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <span class="hidden" id="course_id"></span>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-info text-white">Close</button>
                </form>
                <button class="btn btn-success text-white btn-save-participant" onclick="saveParticipant()">Save</button>
            </div>
        </div>
    </dialog>


@endsection
