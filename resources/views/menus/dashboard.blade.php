@extends('layout.app')
@section('content')
    <div class="m-5">
        <div class="p-3 bg-slate-200 ">
            <p class="text-base md:text-lg">Dashboard Informasi</p>
        </div>

        @foreach ($info as $info)
            <section class="mt-6">
                <section class="flex gap-2 items-start">
                    <i class="fa-solid fa-circle-info text-blue-600 text-xl mt-1"></i>
                    <h1 class="text-blue-600 md:text-xl">{{ $info->title }}</h1>
                </section>

                @if ($info->gambar)
                    <div class="my-4">
                        <img src="{{ asset($info->gambar) }}" alt="{{ $info->title }}"
                            class="w-full h-auto max-w-full object-contain rounded-lg shadow-md sm:max-h-[300px] md:max-h-[400px] lg:max-h-[500px]">
                    </div>
                @endif


                <div class="mt-2">
                    {!! $info->content !!}
                </div>

            </section>
        @endforeach
    </div>
@endsection
