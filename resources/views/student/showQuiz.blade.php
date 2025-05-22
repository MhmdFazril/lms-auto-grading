@extends('layout.app')
@section('content')
    <div class="p-6 bg-gray-50 shadow-md rounded-md">
        <div class="breadcrumbs text-sm bg-slate-200 inline-block px-3 mb-4">
            <ul>
                <li><a href="{{ route('course.show', ['course' => $course->id]) }}">{{ Str::lower($course->nama) }}</a></li>
                <li>{{ Str::lower($content->nama) }}</li>
            </ul>
        </div>

        <h2 class="text-2xl font-semibold">{{ $content->nama }}</h2>

        <div class="flex justify-between">
            <div class="mt-2 text-sm">
                <p>
                    <span class="font-medium">Opened:</span>
                    {{ \Carbon\Carbon::parse($content->open_quiz)->translatedFormat('l, j F Y, H:i') }}
                </p>
                <p>
                    <span class="font-medium">Closed:</span>
                    {{ \Carbon\Carbon::parse($content->close_quiz)->translatedFormat('l, j F Y, H:i') }}
                </p>
            </div>

            <div class="mt-2 text-sm">
                <p><span class="font-medium">Attempts allowed:</span> {{ $content->max_attempt }}</p>
                @php
                    if ($content->satuan == 'menit') {
                        $satuan = 'mins';
                    } elseif ($content->satuan == 'detik') {
                        $satuan = 'secs';
                    } else {
                        $satuan = 'hour';
                    }
                @endphp
                <p><span class="font-medium">Time limit:</span> {{ $content->time_limit . ' ' . $satuan }}</p>
            </div>
        </div>

        <h3 class="mt-6 font-bold text-lg">Summary of your previous attempts</h3>

        <div class="overflow-x-auto">
            <table class="w-full mt-2 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">State</th>
                        <th class="border border-gray-300 px-4 py-2">Grade / 100</th>
                        <th class="border border-gray-300 px-4 py-2">Review</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        {{-- <td class="border border-gray-300 px-4 py-2">Finished<br>Submitted Thursday, 6 October 2022, 3:47 PM
                        </td> --}}
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($attemptInfo != null && $attemptInfo->end_time == null)
                                attempted<br>
                                {{ \Carbon\Carbon::parse($attemptInfo->start_time)->translatedFormat('l, j F Y, H:i') }}
                            @elseif ($attemptInfo != null && $attemptInfo->end_time != null)
                                Finished<br>Submitted
                                {{ \Carbon\Carbon::parse($attemptInfo->end_time)->translatedFormat('l, j F Y, H:i') }}
                            @else
                                Not attempted
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @if ($attemptInfo->review)
                                {{ $attemptInfo->score }}
                            @else
                                --
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @if ($attemptInfo->review)
                                <a href="{{ route('quiz.review', ['course' => $course, 'courseContent' => $content, 'tipe' => 'quiz']) }}"
                                    class="text-blue-500">Review</a>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="mt-6 text-lg font-bold {{ $attemptInfo != null && $attemptInfo->status == 'attempt' ? 'hidden' : '' }}">
            You
            have not attempted this
            quiz yet.</p>
        {{-- <p class="mt-6 text-lg font-bold">Your final grade for this quiz is 60.00/100.00.</p> --}}

        {{-- <p class="text-gray-600">No more attempts are allowed</p> --}}

        <div class="mt-4">
            @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($content->close_quiz))
                <a href="{{ route('course.show', ['course' => $course->id]) }}"
                    class="px-4 py-2 btn bg-gray-600 text-white rounded-md">Back to the course</a>
            @elseif (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($content->open_quiz))
                <button class="px-4 py-2 btn bg-red-500 text-white rounded-md">Quiz unopened</button>
            @else
                <a href="{{ $attemptInfo != null && $attemptInfo->end_time != null ? route('course.show', ['course' => $course->id]) : route('quiz.attempt', ['courseContent' => $content->id, 'idxQuestion' => '1']) }}"
                    class="px-4 py-2 btn bg-emerald-500 text-white rounded-md {{ $content->close_quiz }}">
                    @if ($attemptInfo != null && $attemptInfo->end_time == null)
                        Continue Quiz
                    @elseif ($attemptInfo != null && $attemptInfo->end_time != null)
                        Back to the course
                    @else
                        Attempt Quiz
                    @endif
                </a>
            @endif
        </div>
    </div>
@endsection
