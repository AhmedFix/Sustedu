<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('backend.assignrole.index', compact('users'));
    } // end of index


    public function create()
    {
        $roles = Role::latest()->get();
        $courses = Course::latest()->get();
        return view('backend.assignrole.create', compact(['roles', 'courses']));
    } // end of create

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        $user->attachRole($request->role);

        if ($request->role == 'student') {
            $request->validate([
                'university_id'         => 'required',
                'course_id'          => 'required|numeric',
                'phone2'             => 'required|string|max:255',
            ]);
            DB::table('students')->insert([
                [
                    'user_id'           => $user->id,
                    'course_id'          => $request->course_id,
                    'university_id'       => $request->university_id,
                    'gender'            => $request->gender,
                    'phone'             => $request->phone,
                    'phone2'             => $request->phone2,
                    'dateofbirth'       => $request->dateofbirth,
                    'current_address'   => $request->current_address,
                    'permanent_address' => $request->permanent_address,
                    'created_at'        => date("Y-m-d H:i:s")
                ]
            ]);
        }
        if ($request->role == 'teacher') {
            DB::table('teachers')->insert([
                [
                    'user_id'           => $user->id,
                    'gender'            => $request->gender,
                    'phone'             => $request->phone,
                    'dateofbirth'       => $request->dateofbirth,
                    'current_address'   => $request->current_address,
                    'permanent_address' => $request->permanent_address,
                    'created_at'        => date("Y-m-d H:i:s")
                ]
            ]);
        }

        return redirect()->route('roles.index');
    } // end of store

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::latest()->get();

        return view('backend.assignrole.edit', compact('user', 'roles'));
    } // end of edit

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email
        ]);
        //  dd($request->selectedrole);
        $user->syncRoles([$request->selectedrole]);

        return redirect()->route('roles.index');
    } // end of update

    public function destroy(Role $role)
    {
        $this->delete($role);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    } // end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $role = Role::FindOrFail($recordId);
            $this->delete($role);
        } //end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    } // end of bulkDelete

    private function delete(Role $role)
    {
        $role->delete();
    } // end of delete

}//end of controller
