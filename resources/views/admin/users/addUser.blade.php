@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                Add {{ $role }}
            </h3>
            <form action="{{ route('insertUser') }}" method="post" id="addform" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block">NIP <x-tooltip message="required" /></label>
                                <input type="text" class="input w-full" placeholder="Type here" name="nip"
                                    value="{{ old('nip') }}" autocomplete="off" onkeyup="LettersAndNumbers(this)"
                                    maxlength="20" id="nip" />
                                @error('nip')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label>Full Name <x-tooltip message="required" /></label>
                                <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                    value="{{ old('nama') }}" onkeyup="upCase(this)" autocomplete="off" maxlength="100"
                                    id="nama" />
                                @error('nama')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label>Tempat Lahir <x-tooltip message="required" /></label>
                                <input type="text" class="input w-full" placeholder="Type here" name="tempat_tgl_lahir"
                                    value="{{ old('tempat_tgl_lahir') }}" onkeyup="upCase(this)" autocomplete="off"
                                    id="tempat_tgl_lahir" />
                                @error('tempat_tgl_lahir')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label>Tanggal Lahir <x-tooltip message="required" /></label>
                                <input type="date" class="input w-full" name="tgl_lahir" id="tgl_lahir"
                                    value="{{ old('tgl_lahir') }}" autocomplete="off" />
                                @error('tgl_lahir')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label>Alamat </label>
                                <input type="text" class="input w-full" placeholder="Type here" name="alamat"
                                    value="{{ old('alamat') }}" onkeyup="upCase(this)" autocomplete="off" id="alamat" />
                                @error('alamat')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label>Telp <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" name="telp" id="telp"
                                        value="{{ old('telp') }}" autocomplete="off" onkeyup="onlyNumbers(this)"
                                        maxlength="15" />
                                    @error('telp')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>WA <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" name="wa" id="wa"
                                        value="{{ old('wa') }}" autocomplete="off" onkeyup="onlyNumbers(this)"
                                        maxlength="15" />

                                    @error('wa')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label>Email Address <x-tooltip message="required" /></label>
                                <input type="text" class="input w-full" placeholder="Email Address" name="email"
                                    value="{{ old('email') }}" autocomplete="off" id="email" />

                                @error('email')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label>New Password <x-tooltip message="required" /></label>
                                <input type="password" class="input w-full" placeholder="New Password" name="pass"
                                    value="{{ old('pass') }}" id="pass" maxlength="8" autocomplete="off" />
                                @error('pass')
                                    <p id="passwordError" class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="relative border-2 border-gray-300 overflow-hidden group w-80 h-80">
                            <img id="profileImage" src="{{ asset('img/user-default.png') }}" alt="Profile Picture"
                                class="w-full h-full object-cover">
                            <div
                                class="absolute inset-0 bg-gray-300/35 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <span id="uploadButton"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                    <i class="fa-solid fa-upload"></i>
                                </span>
                                <span id="removeImage"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ml-2 hidden">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                            </div>
                        </div>
                        @error('gambar')
                            <p class="mt-2 text-red-500">{{ $message }}</p>
                        @enderror
                        <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden">
                    </div>
                </div>

            </form>
            <div class="flex justify-end gap-3 mt-5">
                <a href="{{ route('site-admin') }}" class="btn btn-info text-white"><i
                        class="fa-solid fa-xmark"></i></a>
                <button onclick="saveValidate(this)" class="btn btn-success text-white"><i
                        class="fa-solid fa-floppy-disk"></i></button>
            </div>
        </div>
    </div>
@endsection
