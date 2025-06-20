@extends('layout.app')
@section('content')
    <div class="mx-3 my-6 md:mx-auto md:max-w-7xl">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
            <section class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">
                    Add Information
                </h3>
                <span class="text-blue-500 hover:text-blue-700 cursor-pointer" id="expand">expand all</span>
            </section>
            <form action="{{ route('dashboard.store') }}" method="post" id="addform" enctype="multipart/form-data"
                class="space-y-3">
                @csrf

                {{-- Konten --}}
                <div class="collapse collapse-plus bg-base-100 border border-base-300">
                    <input type="checkbox" class="dropdownAcc" checked="checked" />
                    <div class="collapse-title font-semibold text-white bg-grf-primary">Konten</div>
                    <div class="collapse-content text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-4">

                        <div>
                            <label class="block mb-1">Judul <x-tooltip message="required" /></label>
                            <input type="text" class="input w-full" placeholder="Masukkan Title" name="title"
                                value="{{ old('title') }}" maxlength="100" autocomplete="off" />
                            @error('title')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Terbit pada</label>
                            <input type="datetime-local" class="input w-full" name="published_at"
                                value="{{ old('published_at') }}" />
                            @error('published_at')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Takedown pada</label>
                            <input type="datetime-local" class="input w-full" name="take_down_at"
                                value="{{ old('take_down_at') }}" />
                            @error('take_down_at')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Tampilkan Urutan <x-tooltip message="required" /></label>
                            <select class="select w-full" name="order" id="order">
                                <option value="1">Urutan pertama</option>
                                @foreach ($orders as $order)
                                    <option value="{{ $order->order + 1 }}">Setelah {{ $order->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="sm:col-span-2 md:col-span-3">
                            <label class="block mb-1">Isi Konten <x-tooltip message="required" /></label>
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content" class="trix-editor h-40 p-3"></trix-editor>
                            @error('content')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block mb-1">Gambar</label>
                            <div class="relative border-2 border-gray-300 overflow-hidden group w-80 h-80">
                                <img id="image" alt="Profile Picture" class="w-full h-full object-cover hidden">
                                <p class="p-4" id="text-image">klik untuk memilih gambar</p>
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
                </div>

                {{-- Submit --}}
                <div class="flex justify-end gap-3 mt-5">
                    <a href="{{ route('dashboard.index') }}" class="btn btn-info text-white"><i
                            class="fa-solid fa-xmark"></i></a>
                    <button type="submit" class="btn btn-success text-white"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>

        </div>
    </div>
@endsection
