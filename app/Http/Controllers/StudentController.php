<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search and filter.
     */
    public function index(Request $request): View
    {
        $query = Student::with('department');

        // Search by student name or enrollment code
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('enrollment', 'like', "%{$search}%");
            });
        }

        // Filter by Department (Foreign Key dept_id)
        if ($deptId = $request->input('dept_id')) {
            $query->where('dept_id', $deptId);
        }

        // Filter by Gender
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }

        $students = $query->orderBy('student_id', 'desc')->paginate(10)->withQueryString();
        $departments = Department::orderBy('dept_name', 'asc')->get();

        return view('students.index', compact('students', 'departments'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        $departments = Department::orderBy('dept_name', 'asc')->get();

        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['required', 'date', 'before:today'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students,enrollment'],
            'enrollment_date' => ['required', 'date'],
            'dept_id' => ['required', 'exists:departments,dept_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student record created successfully!');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student): View
    {
        $student->load('department');

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student): View
    {
        $departments = Department::orderBy('dept_name', 'asc')->get();

        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['required', 'date', 'before:today'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students,enrollment,'.$student->student_id.',student_id'],
            'enrollment_date' => ['required', 'date'],
            'dept_id' => ['required', 'exists:departments,dept_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student record updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student record deleted successfully!');
    }
}
