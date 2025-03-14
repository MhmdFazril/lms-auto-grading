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
            <form action="{{ route('updateTeacher') }}" method="post" id="addform" enctype="multipart/form-data"
                class="space-y-3">
                @csrf

                <input type="hidden" name="nip_old" id="nip_old" value="{{ $user->nip }}">
                <input type="hidden" name="gambar_old" id="gambarp_old" value="{{ $user->gambar }}">
                <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                <input type="hidden" name="remove_image" id="remove_image" value="0">


                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Identitas Pribadi</div>
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
                            <label class="block mb-1">NIP <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Type here" name="nip"
                                value="{{ old('nip', $user->nip) }}" autocomplete="off" onkeyup="LettersAndNumbers(this)"
                                maxlength="20" id="nip" />
                            @error('nip')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Jenis Kelamin <x-tooltip message="required" /></label>
                            <section class="inline-block mr-4 mb-2">
                                <input type="radio" name="jenis_kelamin" class="radio radio-info" value="L"
                                    id="L"
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'checked' : '' }} />
                                <label for="L">Laki-laki</label>
                            </section>
                            <section class="inline-block mr-4 mb-2">
                                <input type="radio" name="jenis_kelamin" class="radio radio-info" value="P"
                                    id="P"
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'checked' : '' }} />
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
                            @error('alamat`')
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
                            <label class="block mb-1">Alamat Email <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Email Address" name="email"
                                value="{{ old('email', $user->email) }}" autocomplete="off" id="email" />
                            @error('email')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Status Pernikahan <x-tooltip message="required" /></label>
                            <select class="select w-full" name="pernikahan" id="pernikahan">
                                <option selected disabled>Pilih Status</option>
                                <option value="no"
                                    {{ old('pernikahan', $user->pernikahan) == 'no' ? 'selected' : '' }}>belum kawin
                                </option>
                                <option value="yes"
                                    {{ old('pernikahan', $user->pernikahan) == 'yes' ? 'selected' : '' }}>kawin</option>
                                <option value="lainnya"
                                    {{ old('pernikahan', $user->pernikahan) == 'lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            <section class="flex justify-between">
                                @error('pernikahan')
                                    <p class="mt-2 text-red-500">{{ $message }}</p>
                                @enderror
                            </section>
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
                    <input type="checkbox" class="dropdownAcc" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Pendidikan</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">
                        <div>
                            <label class="block mb-1">Pendidikan Terakhir</label>
                            <select class="select w-full" name="pendidikan" id="pendidikan">
                                <option disabled selected>Pilih Pendidikan</option>
                                <option value="sma/smk"
                                    {{ old('pendidikan', $user->pendidikan) == 'sma/smk' ? 'selected' : '' }}>SMA/SMK
                                </option>
                                <option value="diploma"
                                    {{ old('pendidikan', $user->pendidikan) == 'diploma' ? 'selected' : '' }}>Diploma
                                </option>
                                <option value="sarjana"
                                    {{ old('pendidikan', $user->pendidikan) == 'sarjana' ? 'selected' : '' }}>Sarjana
                                </option>
                                <option value="magister"
                                    {{ old('pendidikan', $user->pendidikan) == 'magister' ? 'selected' : '' }}>Magister
                                </option>
                                <option value="doktor"
                                    {{ old('pendidikan', $user->pendidikan) == 'doktor' ? 'selected' : '' }}>Doktor
                                </option>
                                <option value="lainnya"
                                    {{ old('pendidikan', $user->pendidikan) == 'lainnya' ? 'selected' : '' }}>lainnya
                                </option>
                            </select>
                            @error('pendidikan')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Program Studi</label>
                            <input type="text" class="input w-full" placeholder="Type here" name="prodi"
                                value="{{ old('prodi', $user->prodi) }}" onkeyup="upCase(this)" autocomplete="off"
                                id="prodi" maxlength="20" />
                            @error('prodi')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Tahun Lulus</label>
                            <select class="select w-full" name="tahun_lulus" id="tahun_lulus">
                                @for ($year = (int) date('Y'); 1900 <= $year; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                            @error('tahun_lulus')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Nama Lembaga Pendidikan </label>
                            <input type="text" class="input w-full" placeholder="Type here" name="lembaga_pendidikan"
                                value="{{ old('lembaga_pendidikan', $user->lembaga_pendidikan) }}" onkeyup="upCase(this)"
                                autocomplete="off" id="lembaga_pendidikan" />
                            @error('lembaga_pendidikan')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="collapse collapse-plus border border-base-300">
                    <input type="checkbox" class="dropdownAcc" />
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
