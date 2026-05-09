@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile Settings')
@section('page-subtitle', 'Manage your account information')

@section('content')
<div class="row fade-in">
    <div class="col-md-4 mb-4">
        <div class="profile-card text-center">
            <div class="profile-avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <h4>{{ Auth::user()->name }}</h4>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            <hr>
            <div class="profile-stats">
                <div class="stat">
                    <div class="stat-number">{{ $totalTasks ?? 0 }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
                <div class="stat">
                    <div class="stat-number">{{ $completedTasks ?? 0 }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat">
                    <div class="stat-number">{{ $pendingTasks ?? 0 }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <hr>
            <p class="text-muted small mb-0">Member since {{ Auth::user()->created_at->format('M d, Y') }}</p>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="profile-form-card">
            <h5><i class="fas fa-user-edit"></i> Update Profile Information</h5>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control-custom" value="{{ old('name', Auth::user()->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control-custom" value="{{ old('email', Auth::user()->email) }}" required>
                </div>
                <button type="submit" class="btn-primary-custom">Save Changes</button>
            </form>
        </div>
        
        <div class="profile-form-card mt-4">
            <h5><i class="fas fa-lock"></i> Update Password</h5>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control-custom">
                </div>
                <button type="submit" class="btn-primary-custom">Update Password</button>
            </form>
        </div>
    </div>
</div>

<style>
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #E0E0E0;
        height: 100%;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        background: #FFD700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 40px;
        font-weight: 700;
        color: #1A1A1A;
    }
    .profile-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .profile-stats {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
    }
    .profile-stats .stat {
        text-align: center;
    }
    .profile-stats .stat-number {
        font-size: 24px;
        font-weight: 800;
        color: #8B4513;
    }
    .profile-stats .stat-label {
        font-size: 11px;
        color: #666;
    }
    .profile-form-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #E0E0E0;
    }
    .profile-form-card h5 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1A1A1A;
    }
    .profile-form-card h5 i {
        color: #8B4513;
        margin-right: 8px;
    }
</style>
@endsection