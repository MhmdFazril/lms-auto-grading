@extends('layout.app')

@section('content')
    <div class="flex justify-center items-center mt-15">
        <div class="w-full max-w-md bg-white border border-slate-400 shadow-lg rounded-xl p-4 sm:p-8 space-y-6 mx-5 sm:mx-0">
            <div class="flex justify-center">
                <img src="{{ asset('img/grafika-logo.png') }}" alt="Logo" class="w-44 sm:w-50 h-44 sm:h-50">
            </div>

            <form action="{{ route('auth') }}" method="POST" class="space-y-4">
                @csrf
                <label class="input validator w-full m-0">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </g>
                    </svg>
                    <input type="email" name="email" placeholder="mail@site.com" required />
                </label>
                <div class="validator-hint hidden m-0">Enter valid email address</div>

                <label class="input w-full mt-[16px]">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <path
                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                            </path>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                        </g>
                    </svg>
                    <input type="password" name="password" placeholder="******" required />
                </label>

                {{-- <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg"> --}}
                <button class="btn bg-grf-primary hover:bg-blue-600 text-white w-full">
                    Login
                </button>
            </form>

        </div>
    </div>
@endsection
