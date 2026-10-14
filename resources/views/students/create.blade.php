@extends('layouts.app')

@section('content')
<div style="max-width: 760px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Breadcrumb & Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: var(--text-muted); margin-bottom: 4px;">
                <a href="{{ route('students.index') }}" style="color: var(--text-muted); text-decoration: none;">Students</a>
                <span>&rsaquo;</span>
                <span style="color: var(--text-main); font-weight: 600;">Create</span>
            </div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text-main);">Add New Student</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Enter student personal and academic details to register them in the system.</p>
        </div>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main);">Student Registration Information</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <!-- Student Full Name -->
                <div class="form-group">
                    <label for="student_name" class="form-label">Student Full Name <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="student_name" name="student_name" value="{{ old('student_name') }}" class="form-control @error('student_name') is-invalid @enderror" placeholder="e.g. Chan Sokha" required autofocus>
                    @error('student_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                    <!-- Department (FK Relational Selection) -->
                    <div class="form-group">
                        <label for="dept_id" class="form-label">Department <span style="color: var(--danger);">*</span></label>
                        <select id="dept_id" name="dept_id" class="form-select @error('dept_id') is-invalid @enderror" required>
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->dept_id }}" {{ old('dept_id') == $dept->dept_id ? 'selected' : '' }}>
                                    {{ $dept->dept_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('dept_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label for="gender" class="form-label">Gender <span style="color: var(--danger);">*</span></label>
                        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                    <!-- Date of Birth -->
                    <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth <span style="color: var(--danger);">*</span></label>
                        <input type="date" id="dob" name="dob" value="{{ old('dob') }}" class="form-control @error('dob') is-invalid @enderror" required>
                        @error('dob')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Enrollment Code -->
                    <div class="form-group">
                        <label for="enrollment" class="form-label">Enrollment Code / ID <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="enrollment" name="enrollment" value="{{ old('enrollment', 'STU-' . date('Y') . '-' . rand(100, 999)) }}" class="form-control @error('enrollment') is-invalid @enderror" placeholder="e.g. STU-2026-001" required>
                        @error('enrollment')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Enrollment Date -->
                <div class="form-group">
                    <label for="enrollment_date" class="form-label">Enrollment Date <span style="color: var(--danger);">*</span></label>
                    <input type="date" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}" class="form-control @error('enrollment_date') is-invalid @enderror" required>
                    @error('enrollment_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description / Notes -->
                <div class="form-group">
                    <label for="description" class="form-label">Description / Bio Notes</label>
                    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Additional notes or academic remarks regarding the student...">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span>Save Student</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
