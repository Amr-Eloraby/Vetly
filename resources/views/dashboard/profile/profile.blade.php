@extends('dashboard.master')
@section('title', 'Profile')
@section('Profile', 'active')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account /</span> Profile</h4>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body pt-4">
                        <div class="avatar mx-auto mb-3"
                            style="width:80px;height:80px;border-radius:50%;background:#696cff;display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:32px;color:#fff;font-weight:600;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-3" style="font-size:13px;">{{ auth()->user()->email }}</p>
                        <span class="badge bg-label-primary">
                            {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="card">
                    <h5 class="card-header">Edit Profile</h5>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Name --}}
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', auth()->user()->name) }}" placeholder="Full Name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()->email) }}" placeholder="Email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', auth()->user()->phone) }}" placeholder="Phone Number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            {{-- New Password --}}
                            <div class="mb-3">
                                <label class="form-label">New Password <span class="text-muted"
                                        style="font-size:12px;">(leave blank to keep current)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="password" name="password" id="newPassword"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="New Password" oninput="checkPasswords()">
                                    <span class="input-group-text" style="cursor:pointer;"
                                        onclick="togglePassword('newPassword', this)">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                        class="form-control" placeholder="Confirm Password" oninput="checkPasswords()">
                                    <span class="input-group-text" style="cursor:pointer;"
                                        onclick="togglePassword('confirmPassword', this)">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                {{-- ✅ Password match message --}}
                                <small id="passwordMsg" class="mt-1 d-none"></small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> Save Changes
                                </button>
                                <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- / Content -->
@endsection

<script>
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);
        const i = icon.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            i.classList.replace('bx-hide', 'bx-show');
        } else {
            input.type = 'password';
            i.classList.replace('bx-show', 'bx-hide');
        }
    }

    function checkPasswords() {
        const pass = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        const msg = document.getElementById('passwordMsg');
        const btn = document.getElementById('submitBtn');

        if (pass === '' && confirm === '') {
            msg.className = 'mt-1 d-none';
            btn.disabled = false;
            return;
        }

        if (confirm === '') {
            msg.className = 'mt-1 d-none';
            btn.disabled = true;
            return;
        }

        if (pass === confirm) {
            msg.textContent = '✓ Passwords match';
            msg.className = 'mt-1 text-success d-block';
            btn.disabled = false;
        } else {
            msg.textContent = '✗ Passwords do not match';
            msg.className = 'mt-1 text-danger d-block';
            btn.disabled = true;
        }
    }
</script>
