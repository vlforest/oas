<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('users')->get()->map(function ($department) {
            $department->members = json_decode($department->members);
            return $department;
        });

        $users = User::where('role', 'Verified')->get();

        return inertia('Departments/Index', [
            'departments' => $departments,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'nullable|json',
            'main_responsible' => 'nullable|exists:users,id',
        ]);

        $department = Department::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'members' => json_encode($validated['members']),
            'main_responsible' => $validated['main_responsible'],
        ]);

        if (!empty($validated['members'])) {
            $members = json_decode($validated['members']);
            $department->users()->sync($members);
        }

        return redirect()->route('departments.index')->with([
            'success' => 'Department created successfully.',
            'id' => $department->id
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'nullable|json',
            'main_responsible' => 'nullable|exists:users,id',
        ]);

        $department->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'members' => json_encode($validated['members']),
            'main_responsible' => $validated['main_responsible'],
        ]);

        if (!empty($validated['members'])) {
            $members = json_decode($validated['members']);
            $department->users()->sync($members);
        }

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
