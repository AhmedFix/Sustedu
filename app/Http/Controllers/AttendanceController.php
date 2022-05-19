<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $months = Attendance::select('attendence_date')
                            ->orderBy('attendence_date')
                            ->get()
                            ->groupBy(function ($val) {
                                return Carbon::parse($val->attendence_date)->format('m');
                            });

        if( request()->has(['type', 'month']) ) {
            $type = request()->input('type');
            $month = request()->input('month');

            if($type == 'course') {
                $attendances = Attendance::whereMonth('attendence_date', $month)
                                     ->select('attendence_date','student_id','attendence_status','course_id')
                                     ->orderBy('course_id','asc')
                                     ->get()
                                     ->groupBy(['course_id','attendence_date']);

                return view('backend.attendance.index', compact('attendances','months'));

            }
            
        }
        $attendances = [];
        
        return view('backend.attendance.index', compact('attendances','months'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function createByTeacher($courseid)
    {
        $course = Course::with(['students','subjects','teacher'])->findOrFail($courseid);

        return view('backend.attendance.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courseid    = $request->course_id;
        $attenddate = date('Y-m-d');

        $teacher = Teacher::findOrFail(auth()->user()->teacher->id);
        $course   = Course::find($courseid);

        if($teacher->id !== $course->teacher_id) {
            return redirect()->route('teacher.attendance.create',$courseid)
                             ->with('status', 'You are not assign for this course attendence!');
        }

        $dataexist = Attendance::whereDate('attendence_date',$attenddate)
                                ->where('course_id',$courseid)
                                ->get();

        if (count($dataexist) !== 0 ) {
            return redirect()->route('teacher.attendance.create',$courseid)
                             ->with('status', 'Attendance already taken!');
        }

        $request->validate([
            'course_id'      => 'required|numeric',
            'teacher_id'    => 'required|numeric',
            'attendences'   => 'required'
        ]);

        foreach ($request->attendences as $studentid => $attendence) {

            if( $attendence == 'present' ) {
                $attendence_status = true;
            } else if( $attendence == 'absent' ){
                $attendence_status = false;
            }

            Attendance::create([
                'course_id'          => $request->course_id,
                'teacher_id'        => $request->teacher_id,
                'student_id'        => $studentid,
                'attendence_date'   => $attenddate,
                'attendence_status' => $attendence_status
            ]);
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $attendances = Attendance::where('student_id',$attendance->id)->get();

        return view('backend.attendance.show', compact('attendances'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
