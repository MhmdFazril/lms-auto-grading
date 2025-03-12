@props([
    'id' => 'deleteModal',
    'title' => 'Konfirmasi Hapus',
    'message' => 'Apakah Anda yakin ingin menghapus data ini?',
    'confirmId' => 'deleteConfirm',
])

<dialog id="{{ $id }}" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="text-lg font-bold">{{ $title }}</h3>
        <p class="py-4">{{ $message }}</p>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
                <button id="{{ $confirmId }}" class="btn bg-red-600 text-white">Hapus</button>
            </form>
        </div>
    </div>
</dialog>
