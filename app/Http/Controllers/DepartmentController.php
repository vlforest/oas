<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return inertia('Departments/Index', ['departments' => $departments]);
    }

    public function create()
    {
        return inertia('Departments/Create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $department = Department::create($validated);
    
        return redirect()->route('departments.index')->with([
            'success' => 'Department created successfully.',
            'id' => $department->id
        ]);
    }
    
    
    

    public function show(Department $department)
    {
        return inertia('Departments/Show', ['department' => $department]);
    }

    public function edit(Department $department)
    {
        return inertia('Departments/Edit', ['department' => $department]);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
