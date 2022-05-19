<div class="w-full block mt-8">
    <div class="flex flex-wrap sm:flex-no-wrap justify-between">
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ sprintf("%02d", $teacher->courses_count) }}</span>
                <span class="leading-tight">Courses</span>
            </h3>
        </div>
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 mx-0 sm:mx-6 my-4 sm:my-0 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ sprintf("%02d", $teacher->subjects_count) }}</span>
                <span class="leading-tight">Subjects</span>
            </h3>
        </div>
        <div class="w-full bg-gray-200 text-center border border-gray-300 px-8 py-6 rounded">
            <h3 class="text-gray-700 uppercase font-bold">
                <span class="text-4xl">{{ ($teacher->students[0]->students_count) ?? 0 }}</span>
                <span class="leading-tight">Students</span>
            </h3>
        </div>
    </div>
</div>
<div class="w-full block mt-8">
    <div class="flex flex-wrap sm:flex-no-wrap justify-between">
        <div class="w-full sm:w-1/2 mr-2 mb-6">
            <h3 class="text-gray-700 uppercase font-bold mb-2">Courses List</h3>
            <div class="flex flex-wrap items-center">
                @foreach ($teacher->courses as $course)
                    <div class="w-full sm:w-1/2 text-center border border-gray-200 rounded">
                        <div class="text-gray-800 uppercase font-semibold px-4 py-4 mb-2">{{ $course->course_name }}</div>
                        <a href="{{ route('teacher.attendance.create',$course->id) }}" class="bg-gray-200 inline-block mb-4 text-xs text-gray-600 uppercase font-semibold px-4 py-2 border border-gray-200 rounded">Attendence</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="w-full sm:w-1/2 ml-2 mb-6">
            <h3 class="text-gray-700 uppercase font-bold mb-2">Subject List</h3>
            <div class="flex items-center bg-gray-200 rounded-tl rounded-tr">
                <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-semibold">Code</div>
                <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-semibold">Subject</div>
                <div class="w-1/3 text-right text-gray-600 py-2 px-4 font-semibold">Teacher</div>
            </div>
            @foreach ($teacher->subjects as $subject)
                <div class="flex items-center justify-between border border-gray-200">
                    <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-medium">{{ $subject->subject_code }}</div>
                    <div class="w-1/3 text-left text-gray-600 py-2 px-4 font-medium">{{ $subject->name }}</div>
                    <div class="w-1/3 text-right text-gray-600 py-2 px-4 font-medium">{{ $subject->teacher->user->name }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div> <!-- ./END TEACHER -->