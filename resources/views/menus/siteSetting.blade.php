@extends('layout.app')
@section('content')
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            {{-- <h1 class="sm:text-2xl font-bold">Kelola Informasi Beranda</h1> --}}
            <a href="{{ route('site-admin') }}" class="btn btn-primary">Back</a>
            <a href="{{ route('dashboard.create') }}" class="btn btn-success text-white">+ Add Information</a>
        </div>

        <div class="overflow-x-auto">
            @if ($information->count() > 0)
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Publish at</th>
                            <th>End at</th>
                            <th>Status</th>
                            <th class="text-center">Order</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($information as $info)
                            <tr>
                                <td>{{ $info->title }}</td>
                                <td>{{ $info->published_at ? $info->published_at : '-' }}</td>
                                <td>{{ $info->take_down_at ? $info->take_down_at : '-' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $info->is_active ? 'badge-success' : 'badge-error' }} text-white">{{ $info->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-center">{{ $info->order }}</td>
                                <td class="text-center">
                                    <a href="{{ route('dashboard.edit', ['dashboard' => $info->id]) }}"
                                        class="btn bg-blue-700 btn-xs">
                                        <i class="fa-solid fa-file-pen text-white"></i>
                                    </a>
                                    <form method="post" class="inline-block" id="deleteForm">
                                        @csrf
                                        <button class="btn bg-red-600 btn-xs"
                                            onclick="modalDelete(this, {{ $info->id }})"><i
                                                class="fa-solid fa-trash text-white"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h2 class="italic font-light p-3">no information available yet</h2>
            @endif
        </div>
    </div>


    <x-modal.delete id="deleteModal" title="Konfirmasi hapus" message="Apakah Anda yakin ingin menghapus data ini?"
        confirmId="deleteConfirm" />

@endsection
