@extends('layout.app')
@section('content')
    <div class="tabs tabs-border m-5">
        <!-- General Tab -->
        <input type="radio" name="admin_tabs" class="tab" aria-label="General" checked />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">General Settings</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('logos') }}" class="text-blue-500 hover:text-blue-600 hover:underline block">Logos</a>
                    <a href="{{ route('dashboard.index') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Site
                        Settings</a>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">School Settings</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('school.index') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline 
                    block">Browse list of
                        school</a>
                    <a href="{{ route('school.create') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Add new
                        school</a>
                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Import School</a>
                </div>
            </section>
        </div>

        <!-- Users Tab -->
        <input type="radio" name="admin_tabs" class="tab" aria-label="Users" />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">User Management</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('userListing') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Browse list of
                        users</a>
                    <a href="{{ route('addTeacher') }}" class="text-blue-500 hover:text-blue-600 hover:underline block">Add
                        new
                        teacher</a>

                    <a href="{{ route('addStudent') }}" class="text-blue-500 hover:text-blue-600 hover:underline block">Add
                        new
                        student</a>

                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Import
                        Users</a>

                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Export Users</a>
                </div>
            </section>
        </div>

        <!-- Courses Tab -->
        <input type="radio" name="admin_tabs" class="tab" aria-label="Courses" />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Course Management</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('course.index') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Manage courses</a>
                    {{-- <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Add new category</a> --}}
                    <a href="{{ route('course.create') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Add new course</a>
                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Import course</a>
                </div>
            </section>
        </div>

        <!-- Major Tab -->
        <input type="radio" name="admin_tabs" class="tab" aria-label="Major" />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Major Management</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('major.index') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Browse list of
                        major</a>
                    <a href="{{ route('major.create') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Add
                        new major</a>
                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Import major</a>
                </div>
            </section>
        </div>

        <!-- Class Tab -->
        <input type="radio" name="admin_tabs" class="tab" aria-label="Class" />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Class Management</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('mclass.index') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Manage class</a>
                    <a href="{{ route('mclass.create') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Add new class</a>
                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Import
                        class</a>
                </div>
            </section>
        </div>

        <!-- Academic Year Tab -->
        <input type="radio" name="admin_tabs" class="tab" aria-label="Academic Year" />
        <div class="tab-content border border-base-300 bg-base-100 p-6 space-y-5">
            <section>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Academic Year Management</h2>
                <div class="ml-4 space-y-2">
                    <a href="{{ route('academic-year.index') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Manage
                        academic
                        year</a>
                    <a href="{{ route('academic-year.create') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline block">Add new
                        academic
                        year</a>
                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline block">Import academic
                        year</a>
                </div>
            </section>
        </div>
    </div>
@endsection
