@extends('layout.app')
@section('content')
    <div class="p-5">
        <div class=" flex justify-between mb-2">
            <h2 class="text-xl">Student class <b>{{ $mclass->nama }}</b></h2>

            <span id="id_class" class="hidden">{{ $mclass->id }}</span>
            <section>
                <span class="inline-block mr-2">Guru Kelas</span>
                <span class="inline-block">
                    <select class="select" name="wali_kelas" id="wali_kelas" onchange="saveGuru(this.value)">
                        <option disabled selected>Pilih guru</option>
                        @foreach ($teacher as $teacher)
                            <option value="{{ $teacher->id }}" {{ $mclass->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->nama }}
                            </option>
                        @endforeach
                    </select>
                </span>
            </section>
        </div>
        <div class="flex justify-content-between border-2 border-gray-300 rounded-md">
            <div class="overflow-auto w-1/2 h-80 p-2">
                <div class="flex justify-between mb-2">
                    <h1 class="p-2 font-semibold">Students</h1>
                    <select class="select" id="filter-jurusan" onchange="filter(this.value)">
                        <option selected value="all">All</option>
                        @foreach ($majors as $majors)
                            <option value="{{ $majors->id }}">
                                {{ $majors->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <h2 class="italic text-center {{ count($students) !== 0 ? 'hidden' : '' }}" id="empty-text">No
                    available student yet</h2>
                <table class="table table-zebra table-md table-pin-rows table-pin-cols" id="table-students"
                    style="{{ count($students) == 0 ? 'display: none' : '' }}">
                    <thead>
                        <tr>
                            <th></th>
                            <td>Nama</td>
                            <td>Jurusan</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <th></th>
                            <td>Cy Ganderton</td>
                            <td>Quality Control Specialist</td>
                        </tr> --}}
                        @foreach ($students as $student)
                            <tr>
                                <th><input type="checkbox" class="checkbox user-students" id="students" name="students"
                                        data-id="{{ $student->id }}" data-major="{{ $student->major_id }}" /></th>
                                <td>{{ $student->nama }}</td>
                                <td>{{ $student->major->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <td>Nama</td>
                            <td>Jurusan</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="w-20 h-80 bg-gray-100 flex flex-col gap-2 justify-center items-center text-center ">
                <button class="btn btn-soft btn-info tooltip" onclick="insert()" data-tip="insert" id="insert"><i
                        class="fa-solid fa-arrow-right"></i></button>
                <button class="btn btn-soft btn-warning tooltip tooltip-bottom" data-tip="remove" id="remove"><i
                        class="fa-solid fa-arrow-left"></i></button>
            </div>

            <div class="overflow-auto w-1/2 h-72 p-2">
                <div class="collapse collapse-arrow">
                    <input type="checkbox" checked="checked" />
                    <div class="collapse-title font-semibold">{{ $mclass->nama }}</div>
                    <div class="collapse-content text-sm">
                        <h2 class="italic text-center {{ count($sclass) !== 0 ? 'hidden' : '' }}" id="empty-text">No
                            available student yet</h2>
                        <table class="table table-zebra table-md table-pin-rows table-pin-cols" id="table-class"
                            style="{{ count($sclass) == 0 ? 'display: none' : '' }}">
                            <thead>
                                <tr>
                                    <th></th>
                                    <td>Nama</td>
                                    <td>Jurusan</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sclass as $class)
                                    <tr>
                                        <th><input type="checkbox" class="checkbox" id="student" name="student" />
                                        </th>
                                        <td>{{ $class->student->nama }}</td>
                                        <td>{{ $class->major->nama }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <td>Nama</td>
                                    <td>Jurusan</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('mclass.index') }}" class="btn btn-info text-white"><i class="fa-solid fa-xmark"></i></a>
        </div>
    </div>
@endsection
