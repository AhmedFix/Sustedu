<?php


namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::withCount('students')->latest()->paginate(10);

        return view('backend.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::latest()->get();
        
        return view('backend.courses.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_name'        => 'required|string|max:255|unique:courses',
            'course_numeric'     => 'required|numeric',
            'teacher_id'        => 'required|numeric',
            'course_description' => 'required|string|max:255'
        ]);

        Course::create([
            'course_name'        => $request->course_name,
            'course_numeric'     => $request->course_numeric,
            'teacher_id'        => $request->teacher_id,
            'course_description' => $request->course_description
        ]);

        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teachers = Teacher::latest()->get();
        $course = Course::findOrFail($id);

        return view('backend.courses.edit', compact('course','teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_name'        => 'required|string|max:255|unique:courses,course_name,'.$id,
            'course_numeric'     => 'required|numeric',
            'teacher_id'        => 'required|numeric',
            'course_description' => 'required|string|max:255'
        ]);

        $course = Course::findOrFail($id);

        $course->update([
            'course_name'        => $request->course_name,
            'course_numeric'     => $request->course_numeric,
            'teacher_id'        => $request->teacher_id,
            'course_description' => $request->course_description
        ]);

        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        
        $course->subjects()->detach();
        $course->delete();

        return back();
    }

    /*
     * Assign Subjects to Grade 
     * 
     * @return \Illuminate\Http\Response
     */
    public function assignSubject($courseid)
    {
        $subjects   = Subject::latest()->get();
        $assigned   = Course::with(['subjects','students'])->findOrFail($courseid);

        return view('backend.courses.assign-subject', compact('courseid','subjects','assigned'));
    }

    
    /*
     * Add Assigned Subjects to Grade 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAssignedSubject(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->subjects()->sync($request->selectedsubjects);

        return redirect()->route('courses.index');
    }
}
