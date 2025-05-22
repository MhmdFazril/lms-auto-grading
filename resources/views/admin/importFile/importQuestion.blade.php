@extends('layout.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold mb-4">Preview Data Soal (<span class="text-green-400">{{ $namaFile }}</span>)
            </h1>

            {{-- <div class="space-x-4">
                <a href="{{ route('course.content.show-content', ['course' => $course->id, 'courseContents' => $content->id, 'tipe' => 'quiz']) }}"
                    class="btn btn-info text-white">Back</a>
                <button class="btn btn-accent text-white">Import</button>
            </div> --}}
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Bobot</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Jenis Soal</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Soal</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Pilihan A</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Pilihan B</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Pilihan C</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Pilihan D</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Pilihan E</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Jawaban Benar</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Kunci Jawaban</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Jenis essay</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $question['no'] }}</td>

                            <td
                                class="{{ isset($question['errors']['bobot']) ? 'bg-red-500' : '' }} border border-gray-300 px-4 py-2">
                                {{ $question['bobot'] }}
                            </td>
                            <td
                                class="{{ isset($question['errors']['jenis']) ? 'bg-red-500' : '' }} border border-gray-300 px-4 py-2">
                                {{ ucfirst($question['jenis']) }}
                            </td>

                            <td
                                class="{{ isset($question['errors']['soal']) ? 'bg-red-500' : '' }} border border-gray-300 px-4 py-2">
                                {{ $question['soal'] }}
                            </td>

                            <td class="border border-gray-300 px-4 py-2">{{ $question['a'] }}</td>

                            <td class="border border-gray-300 px-4 py-2">{{ $question['b'] }}</td>

                            <td class="border border-gray-300 px-4 py-2">{{ $question['c'] }}</td>

                            <td class="border border-gray-300 px-4 py-2">{{ $question['d'] }}</td>

                            <td class="border border-gray-300 px-4 py-2">{{ $question['e'] }}</td>

                            <td
                                class="{{ isset($question['errors']['jawaban_benar']) ? 'bg-red-500' : '' }} border border-gray-300 px-4 py-2">
                                {{ $question['jawaban_benar'] }}
                            </td>

                            <td
                                class="{{ isset($question['errors']['kunci_essay']) ? 'bg-red-500' : '' }} border border-gray-300 px-4 py-2">
                                {{ $question['kunci_essay'] }}
                            </td>

                            <td
                                class="{{ isset($question['errors']['jenis_essay']) ? 'bg-red-500' : '' }} border border-gray-300 px-4 py-2">
                                {{ $question['jenis_essay'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="py-3 px-2 mt-1 bg-grf-primary flex justify-end gap-4 sticky bottom-0">
            <a href="{{ route('course.content.show-content', ['course' => $course->id, 'courseContents' => $content->id, 'tipe' => 'quiz']) }}"
                class="btn btn-info text-white">Back</a>

            <a href="{{ route('import.question.import', ['course' => $course->id, 'courseContent' => $content->id]) }}"
                class="btn btn-accent text-white {{ empty($errorsInfo) ? '' : 'hidden' }}">Import</a>
        </div>

    </div>
@endsection
