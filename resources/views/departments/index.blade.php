@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Page Header & Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text-main);">Academic Departments</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 4px;">Manage university faculties, managers, campus locations, and associated students.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
                <span>Students</span>
            </a>
            @if (Auth::user()?->canManage())
                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add Department</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Search Toolbar -->
    <div class="card" style="padding: 1.25rem;">
        <form method="GET" action="{{ route('departments.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 250px;">
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by department name, manager ID, or location... (Enter)" class="form-control" style="padding-left: 38px;">
                </div>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-secondary">Filter</button>
                @if (request('search'))
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary" title="Clear Search" style="color: var(--danger);">
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

    <!-- Departments Data Table -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main);">Departments List</h2>
                <span style="background: var(--primary-light); color: var(--primary); font-size: 0.78rem; font-weight: 700; padding: 2px 8px; border-radius: var(--radius-full);">
                    {{ $departments->total() }} Total
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Dept ID</th>
                        <th>Department Name</th>
                        <th>Manager ID</th>
                        <th>Location ID</th>
                        <th>Enrolled Students</th>
                        <th>Created At</th>
                        <th style="text-align: right; width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $dept)
                        <tr>
                            <td style="font-weight: 700; color: var(--text-muted);">
                                #{{ $dept->dept_id }}
                            </td>
                            <td>
                                <a href="{{ route('departments.show', $dept) }}" style="font-weight: 700; color: var(--text-main); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 32px; height: 32px; border-radius: 8px; background: #eef2ff; color: #4f46e5; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                                        {{ substr($dept->dept_name, 0, 1) }}
                                    </span>
                                    <span>{{ $dept->dept_name }}</span>
                                </a>
                            </td>
                            <td>
                                @if ($dept->manager_id)
                                    <code style="padding: 2px 8px; background: #f1f5f9; border-radius: 6px; font-size: 0.82rem; font-weight: 600;">{{ $dept->manager_id }}</code>
                                @else
                                    <span style="color: var(--text-muted); font-style: italic;">Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                @if ($dept->location_id)
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; color: #334155;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{ $dept->location_id }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted); font-style: italic;">N/A</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('students.index', ['dept_id' => $dept->dept_id]) }}" style="text-decoration: none;">
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; background: #ecfdf5; color: #047857; border-radius: var(--radius-full); font-weight: 700; font-size: 0.82rem; border: 1px solid #a7f3d0;">
                                        {{ $dept->students_count }} {{ Str::plural('Student', $dept->students_count) }}
                                    </span>
                                </a>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.88rem;">
                                {{ $dept->created_at ? $dept->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('departments.show', $dept) }}" class="btn-icon" title="View Department Details">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    @if (Auth::user()?->canManage())
                                        <a href="{{ route('departments.edit', $dept) }}" class="btn-icon" title="Edit Department">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete department {{ $dept->dept_name }}?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Delete Department">
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
                            <td colspan="7" style="text-align: center; padding: 3rem 1.5rem;">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; color: var(--text-muted);">
                                    <div style="font-size: 1.1rem; font-weight: 600; color: var(--text-main);">No departments found</div>
                                    <p style="font-size: 0.88rem; max-width: 400px; margin: 0;">Create a department to start organizing students.</p>
                                    <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm" style="margin-top: 8px;">
                                        Add Department
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($departments->hasPages())
            <div style="padding: 1.25rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center;">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
