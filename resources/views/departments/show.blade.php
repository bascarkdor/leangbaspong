@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: var(--text-muted); margin-bottom: 4px;">
                <a href="{{ route('departments.index') }}" style="color: var(--text-muted); text-decoration: none;">Departments</a>
                <span>&rsaquo;</span>
                <span style="color: var(--text-main); font-weight: 600;">{{ $department->dept_name }}</span>
            </div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text-main);">{{ $department->dept_name }}</h1>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back</span>
            </a>
            @if (Auth::user()?->canManage())
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Edit Department</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Department Meta Info Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
        <div class="card" style="padding: 1.25rem;">
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Dept ID (PK)</div>
            <div style="font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin-top: 4px;">#{{ $department->dept_id }}</div>
        </div>
        <div class="card" style="padding: 1.25rem;">
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Manager ID</div>
            <div style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-top: 4px;">{{ $department->manager_id ?: 'None' }}</div>
        </div>
        <div class="card" style="padding: 1.25rem;">
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Location / Building</div>
            <div style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-top: 4px;">{{ $department->location_id ?: 'None' }}</div>
        </div>
        <div class="card" style="padding: 1.25rem;">
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Total Students</div>
            <div style="font-size: 1.35rem; font-weight: 800; color: var(--primary); margin-top: 4px;">{{ $department->students->count() }}</div>
        </div>
    </div>

    <!-- Students in this Department Table -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main);">Students in this Department</h2>
                @if (Auth::user()?->canManage())
                    <a href="{{ route('students.create', ['dept_id' => $department->dept_id]) }}" class="btn btn-primary btn-sm">
                        + Add Student to Department
                    </a>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Student Name</th>
                        <th>Gender</th>
                        <th>Enrollment</th>
                        <th>Enrollment Date</th>
                        <th style="text-align: right; width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($department->students as $student)
                        <tr>
                            <td style="font-weight: 700; color: var(--text-muted);">#{{ $student->student_id }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" style="font-weight: 700; color: var(--text-main); text-decoration: none;">
                                    {{ $student->student_name }}
                                </a>
                            </td>
                            <td>
                                @if ($student->gender === 'Male')
                                    <span style="padding: 3px 10px; background: #e0f2fe; color: #0284c7; border-radius: 9999px; font-weight: 600; font-size: 0.78rem;">Male</span>
                                @elseif ($student->gender === 'Female')
                                    <span style="padding: 3px 10px; background: #fce7f3; color: #db2777; border-radius: 9999px; font-weight: 600; font-size: 0.78rem;">Female</span>
                                @else
                                    <span style="padding: 3px 10px; background: #f1f5f9; color: #475569; border-radius: 9999px; font-weight: 600; font-size: 0.78rem;">{{ $student->gender }}</span>
                                @endif
                            </td>
                            <td>
                                <code style="padding: 2px 8px; background: #f1f5f9; border-radius: 6px; font-size: 0.82rem; font-weight: 600;">{{ $student->enrollment }}</code>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.88rem;">{{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}</td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('students.show', $student) }}" class="btn-icon" title="View Student">
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
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                                No students currently assigned to this department.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
