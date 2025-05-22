@extends('layout.app')
@section('content')
    <div class="container mx-auto p-3 flex">
        <!-- Quiz Content -->
        <main class="w-3/4 p-4">
            <section class="flex justify-between mb-5">
                <h1 class="text-2xl font-semibold">{{ $content->nama }}</h1>

                <div class="mr-4 bg-gray-200 px-4 py-1 rounded-sm">
                    <span class="countdown font-mono text-2xl">
                        <span id="hours" style="--value:00;" aria-live="polite" aria-label="00">10</span>
                        :
                        <span id="minutes" style="--value:00;" aria-live="polite" aria-label="00">24</span>
                        :
                        <span id="seconds" style="--value:00;" aria-live="polite" aria-label="00">59</span>
                    </span>
                </div>
            </section>

            <!-- Question Box -->
            <div class="flex gap-3">
                <div class="border border-gray-400 rounded-md p-4 w-2/12 text-sm space-y-1">
                    <p>Question {{ $question->order }}</p>
                    <p>{{ $question->student_answer == null ? 'Not yet answered' : 'Answered' }}</p>
                    <button class="text-blue-500 text-sm mt-4 block"><i
                            class="{{ $question->markFlag == null ? 'fa-regular' : 'fa-solid' }} fa-flag text-red-500"></i>
                        Flag
                        question</button>
                </div>
                <div class="w-4/5">

                    {{-- action di script --}}
                    <form method="post" id="submitForm">
                        @csrf
                        <div class="border border-gray-500 rounded-md p-4  bg-blue-100">
                            @if ($question->question->question_type == 'multiple')
                                <p class="mb-5">{!! $question->question->question_text !!}</p>
                                @foreach ($question->question->option as $key => $val)
                                    <label class="block">
                                        <input type="radio" name="student_answer" value="{{ $key }}"
                                            {{ $question->student_answer == $key ? 'checked' : '' }}>
                                        {{ $key }}.
                                        {!! $val !!}
                                    </label>
                                @endforeach
                            @else
                                <p class="mb-5">{!! $question->question->question_text !!}</p>
                                <input id="student_answer" type="hidden" name="student_answer"
                                    value="{{ $question->student_answer }}">
                                <trix-editor input="student_answer" class="trix-editor h-40 p-3 bg-white"></trix-editor>
                            @endif
                            @error('student_answer')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror

                            <input type="hidden" name="question_id" id="question_id"
                                value="{{ $question->quiz_question_id }}">

                        </div>
                        <section class="flex {{ $question->order == 1 ? 'justify-end' : 'justify-between' }} mt-4"
                            id="nav-action">
                            <button
                                class="btn btn-info text-white question-nav {{ $question->order == 1 ? 'hidden' : '' }}">Previous</button>

                            <button
                                class="btn btn-info text-white question-nav {{ $question->order == $allQuestion->count() ? 'hidden' : '' }}">Next</button>

                            <button
                                class="btn btn-success text-white question-nav {{ $question->order == $allQuestion->count() ? '' : 'hidden' }}">Finish
                                attempt</button>

                        </section>
                    </form>

                </div>
            </div>
        </main>

        <!-- Sidebar Navigation -->
        <aside class="w-1/4 border border-gray-400 rounded-md p-4">
            <h2 class="font-semibold">Quiz Navigation</h2>
            <div class="border border-gray-500 rounded-md p-2 mt-2 flex flex-wrap gap-3 max-h-1/2 overflow-auto">
                @foreach ($allQuestion as $item)
                    <a href="{{ route('quiz.attempt', ['courseContent' => $content->id, 'idxQuestion' => $item->order]) }}"
                        class="border cursor-pointer relative hover:bg-gray-200 {{ $item->order == $idxQuestion ? 'bg-blue-400 text-white' : '' }} transition rounded-sm w-7 h-8 overflow-hidden text-center">
                        {{ $item->order }}
                        <span
                            class="w-2 h-2 bg-red-600 outline outline-black rounded-br-sm absolute left-0 top-0 {{ $item->markFlag != null && $item->student_answer == null ? '' : 'hidden' }}">
                        </span>

                        <span
                            class="w-2 h-2 bg-green-600 outline outline-black rounded-br-sm absolute left-0 top-0 {{ $item->student_answer != null ? '' : 'hidden' }}">
                        </span>
                    </a>
                @endforeach
            </div>
            <div class="mt-2">
                <a href="#" class="text-blue-500">Finish attempt ...</a>
            </div>
        </aside>
    </div>
@endsection
