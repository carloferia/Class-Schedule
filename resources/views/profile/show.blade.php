@extends('layouts.app')
@section('title', 'TEACHER PROFILE')

@section('content')

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="vcard">
            <div class="vcard-header">
                <span><i class="bi bi-person-fill"></i> TEACHER CARD</span>
            </div>
            <div class="vcard-body text-center py-4">
                <div class="mb-3 mx-auto" style="position:relative;width:92px;">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                             id="profilePreview"
                             style="width:92px;height:92px;object-fit:cover;border-radius:50%;border:3px solid var(--val-red);"
                             alt="Teacher">
                    @else
                        <div id="avatarPlaceholder"
                             style="width:92px;height:92px;background:var(--val-red);border:3px solid var(--val-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Libre Baskerville',serif;font-size:2rem;color:#fff;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <img src="" id="profilePreview"
                             style="width:92px;height:92px;object-fit:cover;border-radius:50%;border:3px solid var(--val-red);display:none;"
                             alt="Teacher">
                    @endif
                </div>

                <div style="font-family:'Libre Baskerville',serif;font-size:1.15rem;color:var(--val-text);">{{ $user->name }}</div>
                <div style="font-size:.82rem;color:var(--val-muted);margin-bottom:1.25rem;">{{ $user->email }}</div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div style="background:#f8faf6;border:1px solid var(--val-border);border-radius:6px;padding:.7rem .5rem;">
                            <div style="font-size:.62rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--val-muted);">Subjects</div>
                            <div style="font-family:'Libre Baskerville',serif;font-size:1.4rem;color:var(--val-red);">{{ $expenseCount }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#f8faf6;border:1px solid var(--val-border);border-radius:6px;padding:.7rem .5rem;">
                            <div style="font-size:.62rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--val-muted);">Schedule Rows</div>
                            <div style="font-family:'Libre Baskerville',serif;font-size:1.4rem;color:#9b7400;">{{ number_format($totalSpent, 0) }}</div>
                        </div>
                    </div>
                </div>

                <div style="border-top:1px solid var(--val-border);padding-top:1rem;text-align:left;">
                    @foreach([
                        ['bi-calendar3', 'Joined', $user->created_at->format('M d, Y')],
                        ['bi-gender-ambiguous', 'Gender', $user->gender ?? '-'],
                        ['bi-geo-alt', 'Department', $user->address ?? '-'],
                    ] as [$icon, $label, $val])
                    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.5rem;font-size:.82rem;">
                        <i class="bi {{ $icon }}" style="color:var(--val-red);width:14px;"></i>
                        <span style="color:var(--val-muted);font-weight:800;font-size:.72rem;letter-spacing:.08em;text-transform:uppercase;min-width:60px;">{{ $label }}</span>
                        <span style="color:var(--val-text);">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="vcard">
            <div class="vcard-header">
                <span><i class="bi bi-pencil-fill"></i> EDIT TEACHER PROFILE</span>
            </div>
            <div class="vcard-body">
                @if($errors->any())
                <div style="background:#fff4e0;border:1px solid #f3c779;border-radius:6px;padding:.75rem 1rem;margin-bottom:1.25rem;">
                    <ul style="margin:0;padding-left:1.2rem;color:#8a4f00;font-weight:700;font-size:.85rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">Profile Photo</label>
                        <div class="d-flex align-items-center gap-3">
                            <label for="profilePicInput" class="btn-val-outline" style="cursor:pointer;">
                                <i class="bi bi-upload me-1"></i> Choose Photo
                            </label>
                            <span id="fileNameLabel" style="font-size:.78rem;color:var(--val-muted);">No file chosen</span>
                            <input type="file" name="profile_picture" id="profilePicInput" class="d-none" accept="image/*">
                        </div>
                        <div style="font-size:.72rem;color:var(--val-muted);margin-top:.35rem;">
                            JPG, PNG, GIF - max 2MB
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Teacher Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Prefer not to say</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $user->gender) == $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Department / Section</label>
                            <input type="text" name="address" class="form-control"
                                   value="{{ old('address', $user->address) }}" placeholder="BSIT 1-A">
                        </div>

                        <div class="col-12">
                            <hr class="val-hr">
                            <div style="font-size:.78rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--val-muted);margin-bottom:.75rem;">
                                Change Password - leave blank to keep current
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 characters">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('dashboard') }}" class="btn-ghost" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="btn-val btn-val-sm">
                            <i class="bi bi-check-lg me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('profilePicInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    document.getElementById('fileNameLabel').textContent = file.name;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('profilePreview');
        const placeholder = document.getElementById('avatarPlaceholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
