<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user) {
                if ($user->role == 'teacher') {
                    $userCourses = Course::with('teacher')->where(['teacher_id' => $user->id, 'aktif' => true])->get();
                } else if ($user->role == 'student') {
                    $userCourses = Course::where(['course_enrollments.student_id' => $user->id, 'aktif' => true])
                        ->leftJoin('course_enrollments', 'course_enrollments.course_id', '=', 'courses.id')
                        ->select('courses.*')
                        ->get();
                } else if ($user->role == 'admin') {
                    $userCourses = Course::where('aktif', true)->get();
                } else {
                    $userCourses = [];
                }

                $view->with('userCourses', $userCourses);
            }
        });
    }
}
