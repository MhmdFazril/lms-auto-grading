@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Edit {{ $role }}
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form action="{{ route('updateStudent') }}" method="post" id="addform" enctype="multipart/form-data"
                class="space-y-3">
                @csrf

                <input type="hidden" name="nis_old" id="nis_old" value="{{ $user->nis }}">
                <input type="hidden" name="nisn_old" id="nisn_old" value="{{ $user->nisn }}">
                <input type="hidden" name="gambar_old" id="gambarp_old" value="{{ $user->gambar }}">
                <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                <input type="hidden" name="remove_image" id="remove_image" value="0">

                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" name="my-accordion-3" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Pribadi</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Nama Lengkap <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama"
                                value="{{ old('nama', $user->nama) }}" onkeyup="upCase(this)" autocomplete="off"
                                maxlength="100" id="nama" />
                            @error('nama')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">NISN <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nisn"
                                value="{{ old('nisn', $user->nisn) }}" autocomplete="off" onkeyup="LettersAndNumbers(this)"
                                maxlength="20" id="nisn" />
                            @error('nisn')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">NIS <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nis"
                                value="{{ old('nis', $user->nis) }}" autocomplete="off" onkeyup="LettersAndNumbers(this)"
                                maxlength="20" id="nis" />
                            @error('nis')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Jenis Kelamin <x-tooltip message="required" /></label>
                            <section class="inline-block mr-4 mb-2">
                                <input type="radio" name="jenis_kelamin" class="radio radio-info" value="L"
                                    id="L" checked />
                                <label for="L">Laki-laki</label>
                            </section>
                            <section class="inline-block mr-4 mb-2">
                                <input type="radio" name="jenis_kelamin" class="radio radio-info" value="P"
                                    id="P" />
                                <label for="P">Perempuan</label>
                            </section>
                            @error('jenis_kelamin')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Tanggal Lahir <x-tooltip message="required" /></label>
                            <input type="date" class="input w-full" name="tgl_lahir" id="tgl_lahir"
                                value="{{ old('tgl_lahir', $user->tgl_lahir) }}" autocomplete="off" />
                            @error('tgl_lahir')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Tempat Lahir <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="tempat_tgl_lahir"
                                value="{{ old('tempat_tgl_lahir', $user->tempat_tgl_lahir) }}" onkeyup="upCase(this)"
                                autocomplete="off" maxlength="100" id="tempat_tgl_lahir" />
                            @error('tempat_tgl_lahir')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Alamat Lengkap </label>
                            <input type="text" class="input w-full" placeholder="Type here" name="alamat"
                                value="{{ old('alamat', $user->alamat) }}" onkeyup="upCase(this)" autocomplete="off"
                                id="alamat" />
                            @error('alamat')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Nomor Telepon <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" name="telp" id="telp"
                                value="{{ old('telp', $user->telp) }}" autocomplete="off" onkeyup="onlyNumbers(this)"
                                maxlength="15" />
                            @error('telp')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Nomor WhatsApp <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" name="wa" id="wa"
                                value="{{ old('wa', $user->wa) }}" autocomplete="off" onkeyup="onlyNumbers(this)"
                                maxlength="15" />
                            @error('wa')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Alamat Email</label>
                            <input type="text" class="input w-full" placeholder="Email Address" name="email"
                                value="{{ old('email', $user->email) }}" autocomplete="off" id="email" />
                            @error('email')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">New password </label>
                            <input type="password" class="input w-full" name="password" value="{{ old('password') }}"
                                autocomplete="off" id="password" minlength="8" />
                            @error('password')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="collapse collapse-plus border border-base-300">
                    <input type="checkbox" class="dropdownAcc" name="my-accordion-3" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Orang Tua/Wali</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Nama Ayah <x-tooltip message="isi '-' jika kosong" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama_ayah"
                                value="{{ old('nama_ayah', $user->nama_ayah) }}" onkeyup="upCase(this)"
                                autocomplete="off" id="nama_ayah" maxlength="100" />
                            @error('nama_ayah')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Pekerjaan Ayah <x-tooltip message="isi '-' jika kosong" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="pekerjaan_ayah"
                                value="{{ old('pekerjaan_ayah', $user->pekerjaan_ayah) }}" onkeyup="upCase(this)"
                                autocomplete="off" id="pekerjaan_ayah" maxlength="100" />
                            @error('pekerjaan_ayah')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Nama Ibu <x-tooltip message="isi '-' jika kosong" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama_ibu"
                                value="{{ old('nama_ibu', $user->nama_ibu) }}" onkeyup="upCase(this)" autocomplete="off"
                                id="nama_ibu" maxlength="100" />
                            @error('nama_ibu')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Pekerjaan Ibu <x-tooltip message="isi '-' jika kosong" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="pekerjaan_ibu"
                                value="{{ old('pekerjaan_ibu', $user->pekerjaan_ibu) }}" onkeyup="upCase(this)"
                                autocomplete="off" maxlength="100" id="pekerjaan_ibu" />
                            @error('pekerjaan_ibu')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Nama Wali <x-tooltip message="isi '-' jika kosong" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nama_wali"
                                value="{{ old('nama_wali', $user->nama_wali) }}" onkeyup="upCase(this)"
                                autocomplete="off" id="nama_wali" maxlength="100" />
                            @error('nama_wali')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Pekerjaan Wali <x-tooltip message="isi '-' jika kosong" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="pekerjaan_wali"
                                value="{{ old('pekerjaan_wali', $user->pekerjaan_wali) }}" onkeyup="upCase(this)"
                                autocomplete="off" maxlength="100" id="pekerjaan_wali" />
                            @error('pekerjaan_wali')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block mb-1">Nomor Kontak Orang Tua/Wali</label>
                            <input type="text" class="input w-full" name="telp_orwa" id="telp_orwa"
                                value="{{ old('telp_orwa', $user->telp_orwa) }}" autocomplete="off"
                                onkeyup="onlyNumbers(this)" maxlength="15" />
                            @error('telp_orwa')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Alamat Orang Tua/Wali</label>
                            <input type="text" class="input w-full" name="alamat_orwa" id="alamat_orwa"
                                value="{{ old('alamat_orwa', $user->alamat_orwa) }}" autocomplete="off"
                                onkeyup="upCase(this)" maxlength="15" />
                            @error('alamat_orwa')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="collapse collapse-plus border border-base-300">
                    <input type="checkbox" class="dropdownAcc" name="my-accordion-3" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Data Sekolah</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Tahun Masuk <x-tooltip message="required" /></label>
                            <select class="select w-full" name="tahun_masuk" id="tahun_masuk">
                                @for ($year = (int) date('Y'); 1900 <= $year; $year--)
                                    <option value="{{ $year }}"
                                        {{ $user->tahun_masuk == $year ? 'selected' : '' }}>{{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun_masuk')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Jurusan <x-tooltip message="required" /></label>
                            <select class="select w-full" name="id_major" id="id_major">
                                <option value="1">jurusan</option>
                            </select>
                            @error('id_major')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div>
                            <label class="block mb-1">Keterangan Beasiswa <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="beasiswa"
                                value="{{ old('beasiswa', $user->beasiswa) }}" onkeyup="upCase(this)" autocomplete="off"
                                id="beasiswa" />
                            @error('beasiswa')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div> --}}

                    </div>
                </div>

                <div class="collapse collapse-plus border border-base-300">
                    <input type="checkbox" class="dropdownAcc" name="my-accordion-3" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">User Profile</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
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
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ml-2 {{ $user->gambar == null ? 'hidden' : '' }}">
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
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <a href="{{ route('site-admin') }}" class="btn btn-info text-white"><i
                            class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
