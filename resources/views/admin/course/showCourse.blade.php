@extends('layout.app')
@section('content')
    <div class="p-4 space-y-5">
        @foreach ($sections as $section)
            <section class="border border-slate-300">
                <div class="bg-slate-200 p-2 flex justify-between">
                    <section>
                        <h2 class="text-xl inline-block text-green-700">{{ $section->nama }}</h2>
                        <span class="{{ auth()->user()->role == 'student' ? 'hidden' : '' }}">
                            <a class="cursor-pointer section-pencil"><i class="fa-solid fa-pencil ml-2"></i></a>
                            <a class="cursor-pointer hidden section-cancel"><i class="fa-solid fa-times ml-2"></i></a>
                            <a class="cursor-pointer hidden section-save" data-sect-id="{{ $section->id }}"><i
                                    class="fa-solid fa-check ml-2"></i></a>
                        </span>
                        <div
                            class="badge badge-sm badge-soft badge-secondary ml-4 {{ $section->show == true ? 'hidden' : '' }}">
                            Hidden
                        </div>
                    </section>
                    <div class="dropdown dropdown-end {{ auth()->user()->role == 'student' ? 'hidden' : '' }}">
                        <div tabindex="0" role="button" class="m-1 cursor-pointer"><i
                                class="fa-solid fa-ellipsis fa-rotate-90"></i></div>
                        <ul tabindex="0"
                            class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-xl border-2 border-gray-100">
                            <li>
                                <a
                                    href="{{ route('course.section.edit-setting', ['course' => $course->id, 'courseSection' => $section->id]) }}"><i
                                        class="fa-solid fa-gear"></i> Edit
                                    Setting</a>
                            </li>
                            <li>
                                <a class="showHide-btn" data-sect-id='{{ $section->id }}'>
                                    <i class="fa-solid {{ $section->show == true ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    {{ $section->show == true ? 'Hide' : 'Show' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('course.section.delete-section', ['course' => $course->id, 'courseSection' => $section->id]) }}"
                                    class="text-red-600"><i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-3 space-y-2 ">
                    <div>
                        {!! $section->deskripsi !!}
                    </div>

                    @foreach ($section->contents as $item)
                        <div class="{{ auth()->user()->role == 'student' ? 'p-3' : 'course-section-contents' }}">
                            <div>
                                {{-- <i class="text-xl fa-solid fa-file-pdf"></i> --}}
                                <i class="text-lg fa-solid fa-book text-red-500"></i>
                                @php
                                    $route =
                                        auth()->user()->role == 'student'
                                            ? route('student.show-content', [
                                                'course' => $course->id,
                                                'courseContent' => $item->id,
                                                'tipe' => $item->content_type,
                                            ])
                                            : route('course.content.show-content', [
                                                'course' => $course->id,
                                                'courseContents' => $item->id,
                                                'tipe' => $item->content_type,
                                            ]);
                                @endphp

                                <a href="{{ $route }}" class="text-grf-primary">{{ $item->nama }}</a>
                            </div>
                            <div class="dropdown dropdown-end {{ auth()->user()->role == 'student' ? 'hidden' : '' }}">
                                <div tabindex="0" role="button" class="m-1 cursor-pointer"><i
                                        class="fa-solid fa-ellipsis fa-rotate-90"></i></div>
                                <ul tabindex="0"
                                    class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-xl border-2 border-gray-100">
                                    <li>
                                        <a
                                            href="{{ route('course.content.edit-content', ['course' => $course->id, 'courseContents' => $item->id, 'tipe' => $item->content_type]) }}"><i
                                                class="fa-solid fa-pencil"></i> Edit
                                            content
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('course.content.delete-content', ['course' => $course->id, 'courseContents' => $item->id]) }}"
                                            class="text-red-600"><i class="fa-solid fa-trash"></i> Delete
                                            content
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach

                    <div class="{{ auth()->user()->role == 'student' ? 'hidden' : '' }}">
                        <span class="cursor-pointer text-grf-primary add-content" data-sect-id="{{ $section->id }}"
                            data-course-id="{{ $course->id }}">
                            -- <i class="fa-solid fa-plus text-xl"></i> --
                        </span>
                    </div>
                </div>
            </section>
        @endforeach

        <a href="{{ route('course.section.add-setting', ['course' => $course->id]) }}"
            class="flex justify-content-between items-center gap-3 p-1 rounded-sm hover:border-2 border-grf-primary {{ auth()->user()->role == 'student' ? 'hidden' : '' }}">
            <span class="w-full h-[2px] bg-grf-primary"></span>
            <span><i class="fa-solid fa-plus text-grf-primary texlg"></i></span>
            <span class="w-full h-[2px] bg-grf-primary"></span>
        </a>
    </div>


    <!-- You can open the modal using ID.showModal() method -->
    <dialog id="modal-activity" class="modal">
        <div class="modal-box w-11/12 max-w-2xl">
            <h3 class="text-lg font-bold">Add an activity or resource</h3>

            <div class="grid grid-cols-3 gap-4 mt-4">
                <!-- Assignment -->
                <a>
                    <div class="flex flex-col items-center p-4 border rounded-lg shadow hover:bg-gray-100 cursor-pointer content"
                        data-tipe="Assignment">
                        <span class="text-pink-500 text-3xl">📄</span>
                        <span class="mt-2 font-medium">Assignment</span>
                    </div>
                </a>

                <!-- Quiz -->
                <a>
                    <div class="flex flex-col items-center p-4 border rounded-lg shadow hover:bg-gray-100 cursor-pointer content"
                        data-tipe="Quiz">
                        <span class="text-blue-500 text-3xl">📝</span>
                        <span class="mt-2 font-medium">Quiz</span>
                    </div>
                </a>

                <!-- File -->
                <a>
                    <div class="flex flex-col items-center p-4 border rounded-lg shadow hover:bg-gray-100 cursor-pointer content"
                        data-tipe="File">
                        <span class="text-green-500 text-3xl">📁</span>
                        <span class="mt-2 font-medium">File</span>
                    </div>
                </a>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>

            <span class="hidden" id="sect_id"></span>
            <span class="hidden" id="course_id"></span>
        </div>
    </dialog>
@endsection
