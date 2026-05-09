@extends('layouts.app')

@section('title', 'About')
@section('page-title', 'About Zentask')
@section('page-subtitle', 'Learn more about our task management platform')

@section('content')
<div class="row fade-in">
    <div class="col-md-8 mx-auto">
        <div class="data-card">
            <div class="p-4">
                <div class="text-center mb-4">
                    <div class="about-icon mx-auto">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="mt-3">About Zentask</h3>
                    <p class="text-muted">Professional Task Management System</p>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-flag-checkered"></i> Our Mission</h5>
                        <p class="text-muted small">To help individuals and teams organize tasks efficiently, boost productivity, and achieve goals on time.</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-eye"></i> Our Vision</h5>
                        <p class="text-muted small">To become the leading task management platform for professionals worldwide.</p>
                    </div>
                </div>
                <hr>
                <h5><i class="fas fa-star"></i> Key Features</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <ul class="feature-list">
                            <li><i class="fas fa-check-circle text-success"></i> Task Management (CRUD)</li>
                            <li><i class="fas fa-check-circle text-success"></i> Priority Levels (High, Medium, Low)</li>
                            <li><i class="fas fa-check-circle text-success"></i> Status Tracking</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="feature-list">
                            <li><i class="fas fa-check-circle text-success"></i> Calendar View</li>
                            <li><i class="fas fa-check-circle text-success"></i> Analytics Dashboard</li>
                            <li><i class="fas fa-check-circle text-success"></i> Soft Delete & Restore</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p class="text-muted small mb-0">Version 1.0 | Built with Laravel</p>
                    <p class="text-muted small">© {{ date('Y') }} Zentask - All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .about-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #8B4513, #FFD700);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .about-icon i {
        font-size: 40px;
        color: white;
    }
    .feature-list {
        list-style: none;
        padding-left: 0;
    }
    .feature-list li {
        padding: 6px 0;
        font-size: 14px;
        color: #555;
    }
    .feature-list li i {
        margin-right: 10px;
        width: 18px;
    }
</style>
@endsection