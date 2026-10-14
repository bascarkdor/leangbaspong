@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: var(--text-muted); margin-bottom: 4px;">
                <a href="{{ route('students.index') }}" style="color: var(--text-muted); text-decoration: none;">Students</a>
                <span>&rsaquo;</span>
                <span style="color: var(--text-main); font-weight: 600;">Profile</span>
            </div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text-main);">Student Profile</h1>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back</span>
            </a>
            @if (Auth::user()?->canManage())
                <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Edit Profile</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Student Detail Card -->
    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.05));">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; border-radius: var(--radius-full); background: linear-gradient(135deg, #4f46e5, #0ea5e9); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.3rem;">
                    {{ strtoupper(substr($student->student_name, 0, 2)) }}
                </div>
                <div>
                    <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--text-main);">{{ $student->student_name }}</h2>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 4px;">
                        <code style="padding: 2px 8px; background: #e2e8f0; border-radius: 6px; font-size: 0.82rem; font-weight: 600;">
                            {{ $student->enrollment }}
                        </code>
                        @if ($student->department)
                            <span style="font-size: 0.85rem; color: var(--primary); font-weight: 600;">
                                &bull; {{ $student->department->dept_name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Student ID</div>
                    <div style="font-weight: 700; color: var(--text-main); font-size: 1rem;">#{{ $student->student_id }}</div>
                </div>

                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Gender</div>
                    <div>
                        @if ($student->gender === 'Male')
                            <span style="padding: 3px 10px; background: #e0f2fe; color: #0284c7; border-radius: 9999px; font-weight: 600; font-size: 0.82rem;">Male</span>
                        @elseif ($student->gender === 'Female')
                            <span style="padding: 3px 10px; background: #fce7f3; color: #db2777; border-radius: 9999px; font-weight: 600; font-size: 0.82rem;">Female</span>
                        @else
                            <span style="padding: 3px 10px; background: #f1f5f9; color: #475569; border-radius: 9999px; font-weight: 600; font-size: 0.82rem;">{{ $student->gender }}</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Date of Birth</div>
                    <div style="font-weight: 600; color: var(--text-main);">
                        {{ $student->dob ? $student->dob->format('F d, Y') : 'N/A' }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Enrollment Date</div>
                    <div style="font-weight: 600; color: var(--text-main);">
                        {{ $student->enrollment_date ? $student->enrollment_date->format('F d, Y') : 'N/A' }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Department (FK)</div>
                    <div>
                        @if ($student->department)
                            <a href="{{ route('departments.show', $student->department) }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                                {{ $student->department->dept_name }}
                            </a>
                            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">
                                Location: {{ $student->department->location_id ?? 'N/A' }} | Manager: {{ $student->department->manager_id ?? 'N/A' }}
                            </div>
                        @else
                            <span style="color: var(--text-muted); font-style: italic;">No Department</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Record Created</div>
                    <div style="font-weight: 500; color: var(--text-muted); font-size: 0.88rem;">
                        {{ $student->created_at ? $student->created_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Description / Bio Remarks</div>
                <div style="padding: 1rem; background: var(--bg-body); border-radius: var(--radius-md); font-size: 0.95rem; line-height: 1.6; color: #334155;">
                    {{ $student->description ?: 'No description provided.' }}
                </div>
            </div>

            @if (Auth::user()?->canManage())
                <!-- Danger Zone -->
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                    <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this student record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            <span>Delete Student Record</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
