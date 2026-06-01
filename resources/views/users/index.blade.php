@extends('layouts.app')
@section('title', 'TEACHER ACCOUNTS')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p style="color:#69766d;font-size:.85rem;letter-spacing:.05em;margin:0;">
        MANAGE TEACHER ACCOUNTS FOR THIS SYSTEM.
    </p>
    <button class="btn-val btn-val-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-lg me-1"></i> Add Teacher
    </button>
</div>

<div class="vcard">
    <div class="vcard-header">
        <span><i class="bi bi-people-fill"></i> TEACHER LIST
            <span style="background:rgba(0,102,51,.15);color:#006633;padding:.15rem .5rem;font-size:.72rem;border-radius:2px;margin-left:.5rem;">{{ $users->total() }}</span>
        </span>
        <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm"
                   style="width:200px;"
                   placeholder="Search teachers..." value="{{ request('search') }}">
            <button type="submit" class="btn-ghost" style="padding:.3rem .65rem;"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="vcard-body p-0">
        <div class="table-responsive">
            <table class="vtable">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Teacher</th>
                        <th>Email</th>
                        <th>Added</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4" style="color:#8a958b;">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="val-avatar" style="width:30px;height:30px;font-size:.75rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:600;letter-spacing:.03em;">{{ strtoupper($user->name) }}</span>
                            </div>
                        </td>
                        <td style="color:#69766d;">{{ $user->email }}</td>
                        <td style="color:#69766d;font-size:.8rem;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="pe-4 text-end">
                            <button class="btn-val-outline me-1"
                                    onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')"
                                    style="padding:.25rem .6rem;font-size:.72rem;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline"
                                  onsubmit="return confirm('Delete teacher {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="background:rgba(0,102,51,.1);border:1px solid rgba(0,102,51,.3);color:#006633;border-radius:2px;padding:.25rem .6rem;font-size:.72rem;font-weight:700;cursor:pointer;transition:all .2s;"
                                        onmouseover="this.style.background='rgba(0,102,51,.25)'"
                                        onmouseout="this.style.background='rgba(0,102,51,.1)'">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5" style="color:#8a958b;">
                            <i class="bi bi-person-x d-block fs-2 mb-2"></i>
                            No teachers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div style="background:var(--val-panel);border-top:1px solid var(--val-border);padding:.75rem 1.25rem;display:flex;justify-content:flex-end;">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">ADD NEW TEACHER</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body" style="padding:1.25rem;background:var(--val-card);">
                    <div class="mb-3">
                        <label class="form-label">Teacher Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Michael Maico" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="teacher@school.test" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 characters" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                    </div>
                </div>
                <div class="modal-footer" style="padding:.85rem 1.25rem;gap:.5rem;">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-val btn-val-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">EDIT TEACHER DATA</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editUserForm">
                @csrf @method('PUT')
                <div class="modal-body" style="padding:1.25rem;background:var(--val-card);">
                    <div class="mb-3">
                        <label class="form-label">Teacher Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">New Password <span style="color:#8a958b;font-weight:400;">(leave blank to keep)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    </div>
                </div>
                <div class="modal-footer" style="padding:.85rem 1.25rem;gap:.5rem;">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-val btn-val-sm">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditModal(id, name, email) {
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editUserForm').action = `/users/${id}`;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}
@if($errors->any())
    new bootstrap.Modal(document.getElementById('addUserModal')).show();
@endif
</script>
@endpush
