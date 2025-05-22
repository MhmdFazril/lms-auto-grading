@extends('layout.app')

@section('content')
    <div class="p-4 max-w-5xl mx-auto">
        <!-- Quiz Info -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold mb-2">Finish Quiz</h1>
            <p class="text-gray-600">Preview your answers before submitting.</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4 mb-6">
            <div class="flex flex-col sm:flex-row justify-between text-sm text-gray-700">
                <div>
                    <p><strong>Quiz Name:</strong> {{ $content->nama }}</p>
                    <p><strong>Major:</strong> {{ Str::ucfirst(Str::lower($major->nama)) }}</p>
                </div>
                <div class="mt-2 sm:mt-0 text-sm">
                    <p><strong>Student Name:</strong> {{ Str::ucfirst(Str::lower(auth()->user()->nama)) }}</p>
                    <p><strong>Start Time:</strong> {{ date('d F Y, H:i:s', strtotime($attempt->start_time)) }}</p>
                </div>
            </div>
        </div>

        <!-- Question List -->
        <div class="flex flex-col gap-3 max-h-[65vh] overflow-y-auto">
            {{-- Loop Here --}}
            @foreach ($attempt->studentAnswer as $answer)
                <section
                    class="{{ $answer->student_answer ? 'bg-green-500' : 'bg-red-500' }} rounded-md w-full p-3 shadow-sm hover:shadow-md transition">
                    <p class="text-center text-white font-semibold">Question {{ $answer->order }}</p>
                </section>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6">

            <a href="{{ route('quiz.attempt', ['courseContent' => $content->id, 'idxQuestion' => '1']) }}"
                class="btn btn-neutral text-white w-full sm:w-auto {{ $overtime ? 'hidden' : '' }}">Back</a>

            <a href="{{ route('quiz.submit', ['courseContents' => $content->id]) }}"
                class="btn bg-green-900 text-white w-full sm:w-auto">Finish Attempt</a>
        </div>
    </div>
@endsection
