@extends('layout.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-base-100 shadow-lg rounded-2xl">
        <h2 class="text-2xl font-bold text-primary text-center mb-6">Edit Profil</h2>

        @if (auth()->user()->role === 'admin')
            <div class="text-center text-gray-500 py-10">Admin tidak perlu mengatur profil pribadi.</div>
        @else
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- Foto Profil -->
                <div class="flex flex-col items-center gap-4 col-span-1 md:col-span-2">
                    <img src="{{ auth()->user()->gambar ? asset('storage/' . auth()->user()->gambar) : asset('images/user-default.png') }}"
                        class="w-32 h-32 rounded-full ring-4 ring-primary object-cover" alt="Foto Profil" id="profileImage">
                    <input type="file" name="gambar"
                        class="file-input file-input-bordered w-full max-w-xs file-input-primary" accept="image/*"
                        id="gambar" />

                    <input type="hidden" name="gambar_old" value="{{ auth()->user()->gambar }}">
                </div>

                <!-- Nama -->
                <div class="form-control">
                    <label class="label"><span class="label-text">Nama Lengkap</span></label>
                    <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}"
                        class="input input-bordered input-error w-full" readonly />
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                        class="input input-bordered input-error w-full" readonly />
                </div>

                <!-- Telepon -->
                <div class="form-control">
                    <label class="label"><span class="label-text">No HP</span></label>
                    <input type="text" name="wa" value="{{ old('wa', auth()->user()->wa) }}"
                        class="input input-bordered w-full" maxlength="15" />
                    @error('wa')
                        <span class="text-light text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIP untuk guru -->
                @if (auth()->user()->role === 'teacher')
                    <div class="form-control">
                        <label class="label"><span class="label-text">NIP</span></label>
                        <input type="text" name="nip" value="{{ old('nip', auth()->user()->nip) }}"
                            class="input input-bordered input-error w-full" readonly />
                    </div>
                @endif

                <!-- NIS untuk siswa -->
                @if (auth()->user()->role === 'student')
                    <div class="form-control">
                        <label class="label"><span class="label-text">NIS</span></label>
                        <input type="text" name="nis" value="{{ old('nis', auth()->user()->nis) }}"
                            class="input input-bordered input-error w-full" readonly />
                    </div>
                @endif

                <!-- Alamat -->
                <div class="form-control md:col-span-2">
                    <label class="label"><span class="label-text">Alamat</span></label>
                    <textarea name="alamat" rows="3" class="textarea textarea-bordered w-full resize-none">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-light text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <a href="" class="md:col-span-2 text-right text-blue-600">Change Password</a>

                <section class="flex justify-between md:col-span-2">
                    <div class="md:col-span-2 flex justify-end">
                        <a href="{{ url()->previous() }}" class="btn btn-primary px-6">Back</a>
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="btn btn-primary px-6">Save</button>
                    </div>
                </section>
            </form>
        @endif
    </div>
@endsection
