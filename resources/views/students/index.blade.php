@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Page Header & Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text-main);">Students Directory</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 4px;">Manage student records, department affiliations, and academic enrollment.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Departments</span>
            </a>
            @if (Auth::user()?->canManage())
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add New Student</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Filter & Search Toolbar (Exam Requirement: Filter & Search by Name) -->
    <div class="card" style="padding: 1.25rem;">
        <form method="GET" action="{{ route('students.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
            <!-- Search Keyword by Student Name -->
            <div style="flex: 2; min-width: 250px;">
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student name or enrollment code... (Press Enter)" class="form-control" style="padding-left: 38px;">
                </div>
            </div>

            <!-- Department Filter Dropdown (Relational Filter) -->
            <div style="flex: 1; min-width: 200px;">
                <select name="dept_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->dept_id }}" {{ request('dept_id') == $dept->dept_id ? 'selected' : '' }}>
                            {{ $dept->dept_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Gender Filter Dropdown -->
            <div style="min-width: 150px;">
                <select name="gender" class="form-select" onchange="this.form.submit()">
                    <option value="">All Genders</option>
                    <option value="Male" {{ request('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ request('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Filter Controls -->
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-secondary">
                    <span>Filter</span>
                </button>
                @if (request()->hasAny(['search', 'dept_id', 'gender']))
                    <a href="{{ route('students.index') }}" class="btn btn-secondary" title="Clear Filters" style="color: var(--danger);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Students Data Table Card -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main);">Enrolled Students</h2>
                <span style="background: var(--primary-light); color: var(--primary); font-size: 0.78rem; font-weight: 700; padding: 2px 8px; border-radius: var(--radius-full);">
                    {{ $students->total() }} Total
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Enrollment Code</th>
                        <th>Enrollment Date</th>
                        <th style="text-align: right; width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td style="font-weight: 700; color: var(--text-muted);">
                                #{{ $student->student_id }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: var(--radius-full); background: linear-gradient(135deg, #4f46e5, #0ea5e9); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($student->student_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('students.show', $student) }}" style="font-weight: 700; color: var(--text-main); text-decoration: none;">
                                            {{ $student->student_name }}
                                        </a>
                                        @if ($student->description)
                                            <div style="font-size: 0.78rem; color: var(--text-muted); max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $student->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($student->department)
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #eef2ff; color: #4338ca; border-radius: 6px; font-weight: 600; font-size: 0.82rem; border: 1px solid #c7d2fe;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                        {{ $student->department->dept_name }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted); font-style: italic;">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                @if ($student->gender === 'Male')
                                    <span style="padding: 3px 10px; background: #e0f2fe; color: #0284c7; border-radius: 9999px; font-weight: 600; font-size: 0.78rem;">
                                        Male
                                    </span>
                                @elseif ($student->gender === 'Female')
                                    <span style="padding: 3px 10px; background: #fce7f3; color: #db2777; border-radius: 9999px; font-weight: 600; font-size: 0.78rem;">
                                        Female
                                    </span>
                                @else
                                    <span style="padding: 3px 10px; background: #f1f5f9; color: #475569; border-radius: 9999px; font-weight: 600; font-size: 0.78rem;">
                                        {{ $student->gender }}
                                    </span>
                                @endif
                            </td>
                            <td style="color: #334155; font-size: 0.88rem;">
                                {{ $student->dob ? $student->dob->format('M d, Y') : 'N/A' }}
                            </td>
                            <td>
                                <code style="padding: 3px 8px; background: #f1f5f9; border-radius: 6px; font-size: 0.82rem; font-weight: 600; color: #0f172a;">
                                    {{ $student->enrollment }}
                                </code>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.88rem;">
                                {{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('students.show', $student) }}" class="btn-icon" title="View Student Profile">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    @if (Auth::user()?->canManage())
                                        <a href="{{ route('students.edit', $student) }}" class="btn-icon" title="Edit Student">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete student {{ $student->student_name }}?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Delete Student">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 3rem 1.5rem;">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; color: var(--text-muted);">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                    <div style="font-size: 1.1rem; font-weight: 600; color: var(--text-main);">No students found</div>
                                    <p style="font-size: 0.88rem; max-width: 400px; margin: 0;">Try adjusting your search criteria or register a new student using the button above.</p>
                                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm" style="margin-top: 8px;">
                                        Add New Student
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
            <div style="padding: 1.25rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center;">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
