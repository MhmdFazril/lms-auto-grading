@extends('layout.app')
@section('content')
    <div class="p-4 m-5">
        <div class="flex justify-between mb-4">
            <a href="{{ route('site-admin') }}" class="btn btn-primary">Back</a>
            <a href="{{ route('school.create') }}" class="btn btn-success text-white">Add School</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full" id="tableUser">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox" /></th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Aktif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($schools as $school)
                        <tr>
                            <th><input type="checkbox" class="checkbox" /></th>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">
                                            @if ($school->gambar != null)
                                                <img src="{{ asset('storage/' . $school->gambar) }}"
                                                    alt="{{ $school->nama }}" />
                                            @else
                                                <img src="{{ asset('img/school-default.png') }}" alt="{{ $school->nama }}"
                                                    width="20px" />
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $school->nama }}</div>
                                        {{-- <div class="text-sm opacity-50">United States</div> --}}
                                    </div>
                                </div>
                            </td>
                            <td>{{ $school->alamat }}</td>
                            <td>
                                @if ($school->aktif == '1')
                                    <div class="badge badge-soft badge-success">Active</div>
                                @else
                                    <div class="badge badge-soft badge-error">Inactive</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('school.edit', ['school' => $school->id]) }}"
                                    class="btn bg-blue-700 btn-xs">
                                    <i class="fa-solid fa-file-pen text-white"></i>
                                </a>
                                <form method="post" class="inline-block" id="deleteForm">
                                    @method('delete')
                                    @csrf
                                    <button class="btn bg-red-600 btn-xs"
                                        onclick="modalDelete(this, {{ $school->id }})"><i
                                            class="fa-solid fa-trash text-white"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-modal.delete id="modalHapusUser" title="Hapus data sekolah" message="Yakin ingin menghapus data sekolah ini?"
        confirmId="btnHapus" />
@endsection
