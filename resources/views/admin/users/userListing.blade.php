@extends('layout.app')
@section('content')
    <div class="p-4 m-5">

        <div class="flex justify-between mb-6">
            <a href="{{ route('site-admin') }}" class="btn btn-primary">Back</a>
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn bg-grf-primary text-white">Filter</label>
                <div tabindex="0" class="dropdown-content z-[1]  p-4 shadow-md rounded-md w-60 bg-grf-primary">
                    <label class="block mb-2 text-sm font-medium text-white">Role</label>
                    <select id="filterRole" class="select select-bordered w-full mb-4">
                        <option value="">Semua Role</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Student">Student</option>
                    </select>

                    <label class="block mb-2 text-sm font-medium text-white">Status</label>
                    <select id="filterStatus" class="select select-bordered w-full mb-4">
                        <option value="">Semua Status</option>
                        <option value="Active">Aktif</option>
                        <option value="Inactive">Tidak Aktif</option>
                    </select>

                    <button id="applyFilter" class="btn bg-grf-secondary  w-full">Apply</button>
                </div>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="table table-zebra w-full" id="tableUser">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox" /></th>
                        <th>Nama</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Aktif</th>
                        <th>Suspend</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($users as $user)
                        <tr data-role="{{ $user->role }}">
                            <th><input type="checkbox" class="checkbox" /></th>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">
                                            @if ($user->gambar != null)
                                                <img src="{{ asset('storage/' . $user->gambar) }}"
                                                    alt="{{ $user->nama }}" />
                                            @else
                                                <img src="{{ asset('img/user-default.png') }}" alt="{{ $user->nama }}"
                                                    width="20px" />
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $user->nama }}</div>
                                        {{-- <div class="text-sm opacity-50">United States</div> --}}
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role == 'teacher')
                                    <div class="badge badge-soft badge-info">{{ $user->role }}</div>
                                @else
                                    <div class="badge badge-soft badge-warning">{{ $user->role }}</div>
                                @endif
                            </td>
                            <td>
                                @if ($user->aktif == '1')
                                    <div class="badge badge-soft badge-success">Active</div>
                                @else
                                    <div class="badge badge-soft badge-error">Inactive</div>
                                @endif
                            </td>
                            <td>
                                @if ($user->suspen == '1')
                                    <div class="badge badge-soft badge-success">Yes</div>
                                @else
                                    <div class="badge badge-soft badge-error">No</div>
                                @endif
                            </td>
                            <td>
                                @if ($user->role == 'teacher')
                                    <a href="{{ route('editTeacher', ['user' => $user->nip]) }}"
                                        class="btn bg-blue-700 btn-xs">
                                        <i class="fa-solid fa-file-pen text-white"></i>
                                    </a>
                                @elseif ($user->role == 'student')
                                    <a href="{{ route('editStudent', ['user' => $user->nisn]) }}"
                                        class="btn bg-blue-700 btn-xs">
                                        <i class="fa-solid fa-file-pen text-white"></i>
                                    </a>
                                @endif
                                <form method="post" class="inline-block" id="deleteForm">
                                    @csrf
                                    <button class="btn bg-red-600 btn-xs"
                                        onclick="modalDelete(this, {{ $user->id }})"><i
                                            class="fa-solid fa-trash text-white"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-modal.delete id="deleteModal" title="Konfirmasi hapus" message="Apakah Anda yakin ingin menghapus user ini?"
        confirmId="deleteConfirm" />
@endsection
