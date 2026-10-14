<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments with search.
     */
    public function index(Request $request): View
    {
        $query = Department::withCount('students');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('dept_name', 'like', "%{$search}%")
                    ->orWhere('manager_id', 'like', "%{$search}%")
                    ->orWhere('location_id', 'like', "%{$search}%");
            });
        }

        $departments = $query->orderBy('dept_id', 'asc')->paginate(10)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create(): View
    {
        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:100'],
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department): View
    {
        $department->load(['students' => function ($q) {
            $q->orderBy('student_name', 'asc');
        }]);

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name,'.$department->dept_id.',dept_id'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:100'],
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        if ($department->students()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department because it still has registered students. Reassign students first.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully!');
    }
}
