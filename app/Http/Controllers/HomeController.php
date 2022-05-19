<?php


namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    } // end of __construct

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $teachers = Teacher::latest()->get();
        $students = Student::latest()->get();
        $subjects = Subject::latest()->get();
        $courses = Course::latest()->get();

        if ($user->hasRole('admin')) {
            return view('home', compact('teachers', 'students', 'courses'));
        } elseif ($user->hasRole('teacher')) {

            $teacher = Teacher::with(['user', 'subjects', 'courses', 'students'])->withCount('subjects', 'courses')->findOrFail($user->teacher->id);

            return view('home', compact('teacher'));
        } elseif ($user->hasRole('student')) {
            $attendances = Attendance::latest()->get();
            $course = Course::latest()->get();

            $student = Student::with(['user', 'course', 'attendances'])->findOrFail($user->student->id);

            return view('home', compact('student'));
        } else {
            return 'NO ROLE ASSIGNED YET!';
        }
    }

}
