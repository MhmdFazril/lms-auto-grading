@extends('layout.app')

@section('content')
    <div class="flex justify-center items-center mt-15">
        <div class="w-full max-w-md bg-white border border-slate-400 shadow-lg rounded-xl p-4 sm:p-8 space-y-6 mx-5 sm:mx-0">
            <div class="flex justify-center">
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo->path) }}" alt="Logo" class="w-44 sm:w-50 h-44 sm:h-50">
                @else
                    <h2 class="text-4xl font-bold text-gray-700">Login</h2>
                @endif
            </div>

            <form action="{{ route('auth') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1">NIP | NIS</label>
                    <input type="text" class="input w-full" placeholder="Type here" name="nomor"
                        value="{{ old('nomor') }}" autocomplete="off" onkeyup="safeInput(this)" maxlength="20"
                        id="nomor" />
                    @error('nomor')
                        <p class="mt-2 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <label class="block mb-1">Password</label>
                    <input type="password" class="input w-full" placeholder="Type here" name="password"
                        value="{{ old('password') }}" autocomplete="off" onkeyup="LettersAndNumbers(this)" maxlength="20"
                        id="password" />

                    <!-- Icon Mata -->
                    <i id="togglePassword" class="fa fa-eye absolute right-3 bottom-3 cursor-pointer"></i>

                    @error('password')
                        <p class="mt-2 text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <button class="btn bg-grf-primary hover:bg-blue-600 text-white w-full">
                    Login
                </button>
            </form>

        </div>
    </div>
@endsection
