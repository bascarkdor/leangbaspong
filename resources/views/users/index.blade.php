@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Top Action Bar -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.02em;">User Management</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 2px;">
                Manage university system accounts, roles, and access credentials
            </p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Create New User</span>
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card" style="padding: 1.25rem 1.5rem;">
        <form method="GET" action="{{ route('users.index') }}" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <!-- Search Keyword -->
            <div style="flex: 1; min-width: 240px;">
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email address... (Enter)" class="form-control" style="padding-left: 38px;">
                </div>
            </div>

            <!-- Role Filter Dropdown -->
            <div style="min-width: 200px;">
                <select name="role_id" class="form-select">
                    <option value="">All Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ (string) request('role_id') === (string) $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary btn-sm">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'role_id']) && (request('search') != '' || request('role_id') != ''))
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm" title="Clear all filters">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="card">
        <div class="card-header">
            <span style="font-weight: 700; font-size: 1rem;">
                Registered Users <span style="font-size: 0.8rem; background: #e0e7ff; color: #4338ca; padding: 2px 8px; border-radius: var(--radius-full); margin-left: 6px;">{{ $users->total() }} total</span>
            </span>
            <span style="font-size: 0.85rem; color: var(--text-muted);">
                Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>User Profile</th>
                        <th>Email Address</th>
                        <th>Role / Department</th>
                        <th>Created Date</th>
                        <th style="text-align: right; width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td style="font-weight: 600; color: var(--text-muted);">
                                #{{ $user->id }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar-sm" style="font-size: 0.85rem; width: 36px; height: 36px;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-main);">
                                            {{ $user->name }}
                                        </div>
                                        @if(Auth::id() === $user->id)
                                            <span style="font-size: 0.72rem; color: var(--primary); font-weight: 600;">(You)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="color: var(--text-muted);">
                                {{ $user->email }}
                            </td>
                            <td>
                                @php
                                    $roleName = $user->role->role_name ?? 'None';
                                    $badgeClass = match(strtolower($roleName)) {
                                        'administrator' => 'badge-admin',
                                        'manager' => 'badge-manager',
                                        'staff' => 'badge-staff',
                                        'student' => 'badge-student',
                                        default => 'badge-default'
                                    };
                                @endphp
                                <span class="role-badge {{ $badgeClass }}">
                                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background-color: currentColor;"></span>
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.85rem;">
                                {{ $user->created_at?->format('M d, Y') ?? 'N/A' }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <!-- View Details -->
                                    <a href="{{ route('users.show', $user) }}" class="btn-icon" title="View Details">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>

                                    <!-- Edit User -->
                                    <a href="{{ route('users.edit', $user) }}" class="btn-icon" title="Edit User">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete User -->
                                    @if(Auth::id() !== $user->id)
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to permanently delete {{ $user->name }}?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Delete User">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 3rem 1.5rem;">
                                <div style="max-width: 320px; margin: 0 auto; color: var(--text-muted);">
                                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.75rem;">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    <h3 style="font-size: 1.1rem; color: var(--text-main); font-weight: 600; margin-bottom: 4px;">No Users Found</h3>
                                    <p style="font-size: 0.85rem;">No user records match your search criteria. Try adjusting your search keyword or selected role.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                </div>
                <div style="display: flex; gap: 6px;">
                    @if ($users->onFirstPage())
                        <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="btn btn-secondary btn-sm">Previous</a>
                    @endif

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="btn btn-secondary btn-sm">Next</a>
                    @else
                        <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">Next</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
