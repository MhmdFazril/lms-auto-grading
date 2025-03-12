@extends('layout.app')
@section('content')
    <div class="p-4 m-5">
        <div class="flex justify-between mb-5">
            <a href="{{ route('site-admin') }}" class="btn btn-primary">Back</a>
            <a href="{{ route('academic-year.create') }}" class="btn btn-success text-white">Add academic year</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full" id="tableUser">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox" /></th>
                        <th>Periode</th>
                        <th>Catatan</th>
                        <th>Aktif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($years as $year)
                        <tr>
                            <th><input type="checkbox" class="checkbox" /></th>
                            <td>{{ $year->tahun1 . '/' . $year->tahun2 }}</td>
                            <td>{{ $year->catatan }}</td>
                            <td>
                                @if ($year->aktif == '1')
                                    <div class="badge badge-soft badge-success">Active</div>
                                @else
                                    <div class="badge badge-soft badge-error">Inactive</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('academic-year.edit', ['academic_year' => $year->id]) }}"
                                    class="btn bg-blue-700 btn-xs">
                                    <i class="fa-solid fa-file-pen text-white"></i>
                                </a>
                                <form method="post" class="inline-block" id="deleteForm">
                                    @method('delete')
                                    @csrf
                                    <button class="btn bg-red-600 btn-xs"
                                        onclick="modalDelete(this, {{ $year->id }})"><i
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
