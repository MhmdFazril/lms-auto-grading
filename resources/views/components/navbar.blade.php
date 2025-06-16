{{-- <div class="navbar shadow-sm bg-grf-primary"> --}}
<div
    class="w-full flex items-center {{ Route::currentRouteName() == 'course.show' ? 'p-2' : 'p-4' }} shadow-sm bg-grf-primary">
    <div class="flex-1">
        <p
            class="text-2xl md:text-3xl ml-3 font-audiowide text-white {{ Route::currentRouteName() == 'course.show' ? 'hidden' : '' }}">
            E-Learning Grafika YL</p>
    </div>

    @if (Route::currentRouteName() == 'index')
        <div class="flex-none">
            <a href="{{ route('login') }}" class="btn btn-ghost text-white hover:text-black">Login</a>
        </div>
    @endif

    @if (Auth::check())
        <div class="dropdown dropdown-end cursor-pointer">
            <div tabindex="0" role="button" class="rounded-field flex gap-2 items-center">
                @php
                    $nomor = auth()->user()->role == 'student' ? auth()->user()->nis : auth()->user()->nip;
                @endphp
                <p class="text-slate-100 hidden sm:block">{{ auth()->user()->nama . ' ' . $nomor }}</p>
                <i class="fa-solid fa-circle-user text-slate-100 text-2xl"></i>
                <i class="fa-solid fa-chevron-down text-slate-100 text-sm"></i>
            </div>

            <ul tabindex="0" class="menu dropdown-content bg-grf-primary rounded-box z-1 mt-4 w-52 p-2 shadow-sm">
                <li>
                    <a href="{{ route('profile') }}" class="text-slate-100"><i class="fa-solid fa-circle-user"></i>
                        Profile</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="text-slate-100"><i
                            class="fa-solid fa-right-from-bracket fa-flip-horizontal"></i> Log out</a>
                </li>
            </ul>
        </div>
    @endif
</div>

<div
    class="navbar shadow-sm bg-grf-primary {{ Route::currentRouteName() != 'course.show' ? 'hidden' : 'hidden sm:block' }} border border-t-slate-300 ">
    <h1 class="text-3xl md:text-4xl ml-3 font-audiowide text-white">
        {{ $title }}</h1>
</div>

@if (Route::currentRouteName() == 'dashboard' ||
        Route::currentRouteName() == 'site-admin' ||
        Route::currentRouteName() == 'course.show')
    <div class="border-b-2 border-b-grf-primary flex space-x-4 overflow-auto">
        <a href="{{ route('dashboard') }}" class="p-3 hover:bg-grf-primary group ">
            <section class="group-hover:text-white"><i class="fa-solid fa-house"></i> Home</section>
        </a>

        <button popovertarget="popover-1" class="p-3 hover:bg-grf-primary group cursor-pointer hover:text-white"
            style="anchor-name:--anchor-1">
            <i class="fa-solid fa-briefcase "></i> My Courses
        </button>
        <ul class="dropdown menu w-52 rounded-box bg-grf-primary shadow-sm" popover id="popover-1"
            style="position-anchor:--anchor-1">
            @if ($userCourses->count() == 0)
                <li>
                    <span class="text-white italic">no course available yet</span>
                </li>
            @else
                @foreach ($userCourses as $course)
                    <li>
                        <a href="{{ route('course.show', ['course' => $course->id]) }}" class="text-white"><i
                                class="fa-solid fa-graduation-cap"></i>
                            {{ $course->nama }}</a>
                    </li>
                @endforeach
            @endif
        </ul>

        @if (auth()->user()->role == 'admin')
            <a href="{{ route('site-admin') }}" class="p-3 hover:bg-grf-primary group ">
                <section class="group-hover:text-white"><i class="fa-solid fa-user-tie"></i> Site
                    Administration</section>
            </a>
        @endif
    </div>
@endif
