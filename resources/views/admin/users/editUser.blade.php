@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                Add {{ $role }}
            </h3>
            <form action="{{ route('updateUser') }}" method="post" id="editform" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                @if ($role === 'Teacher')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block">NIP <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Type here" name="nip"
                                        value="{{ old('nip', $user->nip) }}" autocomplete="off"
                                        onkeyup="LettersAndNumbers(this)" maxlength="20" id="nip" />
                                    <input type="hidden" name="nip_old" id="nip_old" value="{{ $user->nip }}">
                                    @error('nip')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>Nama Lengkap <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                        value="{{ old('nama', $user->nama) }}" onkeyup="upCase(this)" autocomplete="off"
                                        maxlength="100" id="nama" />
                                    @error('nama')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label>Tempat Lahir <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Type here"
                                        name="tempat_tgl_lahir"
                                        value="{{ old('tempat_tgl_lahir', $user->tempat_tgl_lahir) }}"
                                        onkeyup="upCase(this)" autocomplete="off" id="tempat_tgl_lahir" />
                                    @error('tempat_tgl_lahir')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>Tanggal Lahir <x-tooltip message="required" /></label>
                                    <input type="date" class="input w-full" name="tgl_lahir" id="tgl_lahir"
                                        value="{{ old('tgl_lahir', $user->tgl_lahir) }}" autocomplete="off" />
                                    @error('tgl_lahir')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label>Alamat </label>
                                    <input type="text" class="input w-full" placeholder="Type here" name="alamat"
                                        value="{{ old('alamat', $user->alamat) }}" onkeyup="upCase(this)"
                                        autocomplete="off" id="alamat" />
                                    @error('alamat')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label>Telp <x-tooltip message="required" /></label>
                                        <input type="text" class="input w-full" name="telp" id="telp"
                                            value="{{ old('telp', $user->telp) }}" autocomplete="off"
                                            onkeyup="onlyNumbers(this)" maxlength="15" />
                                        @error('telp')
                                            <p class="mt-2 text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label>WA <x-tooltip message="required" /></label>
                                        <input type="text" class="input w-full" name="wa" id="wa"
                                            value="{{ old('wa', $user->wa) }}" autocomplete="off"
                                            onkeyup="onlyNumbers(this)" maxlength="15" />

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
                                        value="{{ old('email', $user->email) }}" autocomplete="off" id="email" />
                                    <input type="hidden" name="email_old" id="email_old" value="{{ $user->email }}">
                                    @error('email')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>New Password</label>
                                    <input type="password" class="input w-full" placeholder="Password" name="password"
                                        value="{{ old('password') }}" id="password" maxlength="8"
                                        autocomplete="off" />
                                    @error('password')
                                        <p id="passwordError" class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="relative border-2 border-gray-300 overflow-hidden group w-80 h-80">
                                <img id="profileImage"
                                    src="{{ asset($user->gambar == null ? 'img/user-default.png' : 'storage/' . $user->gambar) }}"
                                    alt="Profile Picture" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-gray-300/35 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <span id="uploadButton"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        <i class="fa-solid fa-upload"></i>
                                    </span>
                                    <span id="removeImage"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ml-2 {{ $user->gambar == null ? 'hidden' : 'block' }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                </div>
                            </div>
                            @error('gambar')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                            <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden">
                            <input type="hidden" id="gambar_old" name="gambar_old" value="{{ $user->gambar }}">
                        </div>

                        <input type="hidden" name="role" id="role" value="teacher">
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block">NISN <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Type here" name="nisn"
                                        value="{{ old('nisn', $user->nisn) }}" autocomplete="off"
                                        onkeyup="LettersAndNumbers(this)" maxlength="20" id="nisn" />

                                    <input type="hidden" name="nisn_old" id="nisn_old" value="{{ $user->nisn }}">
                                    @error('nisn')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>Nama Lengkap <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                        value="{{ old('nama', $user->nama) }}" onkeyup="upCase(this)" autocomplete="off"
                                        maxlength="100" id="nama" />
                                    @error('nama')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label>Tempat Lahir <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Type here"
                                        name="tempat_tgl_lahir"
                                        value="{{ old('tempat_tgl_lahir', $user->tempat_tgl_lahir) }}"
                                        onkeyup="upCase(this)" autocomplete="off" id="tempat_tgl_lahir" />
                                    @error('tempat_tgl_lahir')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>Tanggal Lahir <x-tooltip message="required" /></label>
                                    <input type="date" class="input w-full" name="tgl_lahir" id="tgl_lahir"
                                        value="{{ old('tgl_lahir', $user->tgl_lahir) }}" autocomplete="off" />
                                    @error('tgl_lahir')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label>Alamat </label>
                                    <input type="text" class="input w-full" placeholder="Type here" name="alamat"
                                        value="{{ old('alamat', $user->alamat) }}" onkeyup="upCase(this)"
                                        autocomplete="off" id="alamat" />
                                    @error('alamat')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label>Telp <x-tooltip message="required" /></label>
                                        <input type="text" class="input w-full" name="telp" id="telp"
                                            value="{{ old('telp', $user->telp) }}" autocomplete="off"
                                            onkeyup="onlyNumbers(this)" maxlength="15" />
                                        @error('telp')
                                            <p class="mt-2 text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label>WA <x-tooltip message="required" /></label>
                                        <input type="text" class="input w-full" name="wa" id="wa"
                                            value="{{ old('wa', $user->wa) }}" autocomplete="off"
                                            onkeyup="onlyNumbers(this)" maxlength="15" />

                                        @error('wa')
                                            <p class="mt-2 text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label>Email Address <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Email Address"
                                        name="email" value="{{ old('email', $user->email) }}" autocomplete="off"
                                        id="email" />
                                    <input type="hidden" name="email_old" id="email_old" value="{{ $user->email }}">
                                    @error('email')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>New Password</label>
                                    <input type="password" class="input w-full" placeholder="Password" name="password"
                                        value="{{ old('password', $user->password) }}" id="password" maxlength="8"
                                        autocomplete="off" />
                                    @error('password')
                                        <p id="passwordError" class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label>Nama wali <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" placeholder="Nama wali" name="wali"
                                        onkeyup="upCase(this)" value="{{ old('wali', $user->wali) }}" autocomplete="off"
                                        id="wali" />

                                    @error('wali')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label>Alamat wali</label>
                                    <input type="text" class="input w-full" placeholder="Alamat wali"
                                        name="alamat_wali" value="{{ old('alamat_wali', $user->alamat_wali) }}"
                                        id="alamat_wali" onkeyup="upCase(this)" maxlength="100" autocomplete="off" />
                                    @error('alamat_wali')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label>Telp wali <x-tooltip message="required" /></label>
                                    <input type="text" class="input w-full" name="telp_wali" id="telp_wali"
                                        value="{{ old('telp_wali', $user->telp_wali) }}" autocomplete="off"
                                        onkeyup="onlyNumbers(this)" maxlength="15" />

                                    @error('telp_wali')
                                        <p class="mt-2 text-red-500">{{ $message }}</p>
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
                            <input type="hidden" id="gambar_old" name="gambar_old" value="{{ $user->gambar }}">
                        </div>
                    </div>
                    <input type="hidden" name="role" id="role" value="student">
                @endif

            </form>
            <div class="flex justify-end gap-3 mt-5">
                <a href="{{ route('userListing') }}" class="btn btn-info text-white"><i
                        class="fa-solid fa-xmark"></i></a>
                <button onclick="saveValidate(this)" class="btn btn-success text-white"><i
                        class="fa-solid fa-floppy-disk"></i></button>
            </div>
        </div>
    </div>
@endsection
