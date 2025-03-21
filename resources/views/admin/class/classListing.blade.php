@extends('layout.app')
@section('content')
    <div class="p-4 m-5">
        <div class="flex justify-between mb-5">
            <a href="{{ route('site-admin') }}" class="btn btn-primary">Back</a>
            <a href="{{ route('mclass.create') }}" class="btn btn-success text-white">Add class</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full" id="tableUser">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox" /></th>
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Deskripsi</th>
                        <th>Aktif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($classes as $class)
                        <tr>
                            <th><input type="checkbox" class="checkbox" /></th>
                            <td>{{ $class->nama }}</td>
                            <td>{{ $class->teacher->nama ?? '-' }}</td>
                            <td>{{ $class->sclass->count() }}</td>
                            <td>{{ $class->deskripsi }}</td>
                            <td>
                                @if ($class->aktif == '1')
                                    <div class="badge badge-soft badge-success">Active</div>
                                @else
                                    <div class="badge badge-soft badge-error">Inactive</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sclass.index', ['mclass' => $class->id]) }}"
                                    class="btn bg-blue-700 btn-xs">
                                    <i class="fa-solid fa-users text-white"></i>
                                </a>
                                <a href="{{ route('mclass.edit', ['mclass' => $class->id]) }}"
                                    class="btn bg-blue-700 btn-xs">
                                    <i class="fa-solid fa-file-pen text-white"></i>
                                </a>
                                <form method="post" class="inline-block" id="deleteForm">
                                    @method('delete')
                                    @csrf
                                    <button class="btn bg-red-600 btn-xs"
                                        onclick="modalDelete(this, {{ $class->id }})"><i
                                            class="fa-solid fa-trash text-white"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-modal.delete id="deleteModal" title="Konfirmasi hapus" message="Apakah Anda yakin ingin menghapus data ini?"
        confirmId="deleteConfirm" />
@endsection
