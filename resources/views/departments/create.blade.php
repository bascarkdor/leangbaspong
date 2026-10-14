@extends('layouts.app')

@section('content')
<div style="max-width: 640px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: var(--text-muted); margin-bottom: 4px;">
                <a href="{{ route('departments.index') }}" style="color: var(--text-muted); text-decoration: none;">Departments</a>
                <span>&rsaquo;</span>
                <span style="color: var(--text-main); font-weight: 600;">Create</span>
            </div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text-main);">Add Department</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Create a new academic department or faculty unit.</p>
        </div>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main);">Department Details</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <!-- Department Name -->
                <div class="form-group">
                    <label for="dept_name" class="form-label">Department Name <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="dept_name" name="dept_name" value="{{ old('dept_name') }}" class="form-control @error('dept_name') is-invalid @enderror" placeholder="e.g. Computer Science" required autofocus>
                    @error('dept_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                    <!-- Manager ID -->
                    <div class="form-group">
                        <label for="manager_id" class="form-label">Manager ID</label>
                        <input type="text" id="manager_id" name="manager_id" value="{{ old('manager_id') }}" class="form-control @error('manager_id') is-invalid @enderror" placeholder="e.g. MGR-101">
                        @error('manager_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Location ID -->
                    <div class="form-group">
                        <label for="location_id" class="form-label">Location ID / Building</label>
                        <input type="text" id="location_id" name="location_id" value="{{ old('location_id') }}" class="form-control @error('location_id') is-invalid @enderror" placeholder="e.g. BUILDING-A">
                        @error('location_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Save Department</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
