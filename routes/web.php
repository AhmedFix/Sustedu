<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//profile routes
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

Route::name('profile.')->namespace('Profile')->group(function () {

    //password routes
    Route::get('/password/edit', 'PasswordController@edit')->name('password.edit');
    Route::put('/password/update', 'PasswordController@update')->name('password.update');
});


Route::group(['middleware' => ['auth', 'role:admin']], function () {
    //role routes
    Route::delete('/roles/bulk_delete', 'RoleController@bulkDelete')->name('roles.bulk_delete');
    Route::resource('roles', 'RoleController');

    Route::get('assign-subject-to-course/{id}', 'CourseController@assignSubject')->name('course.assign.subject');
    Route::post('assign-subject-to-course/{id}', 'CourseController@storeAssignedSubject')->name('store.course.assign.subject');

    Route::get('assign-subject-to-book/{id}', 'BookController@assignSubject')->name('book.assign.subject');
    Route::post('assign-subject-to-book/{id}', 'BookController@storeAssignedSubject')->name('store.book.assign.subject');

    Route::resource('courses', 'CourseController');
    Route::resource('subject', 'SubjectController');
    Route::resource('books', 'BookController');
    Route::resource('teacher', 'TeacherController');
    Route::resource('student', 'StudentController');
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
});

Route::group(['middleware' => ['auth', 'role:teacher']], function () {
    Route::post('attendance', 'AttendanceController@store')->name('teacher.attendance.store');
    Route::get('attendance-create/{classid}', 'AttendanceController@createByTeacher')->name('teacher.attendance.create');
});


Route::group(['middleware' => ['auth', 'role:student']], function () {
});
