@extends('layouts.app')

@section('title', 'Services')
@section('page-title', 'Our Services')
@section('page-subtitle', 'What Zentask offers to boost your productivity')

@section('content')
<div class="row fade-in">
    <div class="col-md-4 mb-4">
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <h4>Task Management</h4>
            <p>Create, edit, and organize your tasks with ease. Set priorities and track progress in real-time.</p>
            <div class="service-features">
                <span class="badge">CRUD Operations</span>
                <span class="badge">Priority Levels</span>
                <span class="badge">Due Dates</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h4>Calendar View</h4>
            <p>Visualize your deadlines with an interactive calendar. Never miss important dates again.</p>
            <div class="service-features">
                <span class="badge">Monthly View</span>
                <span class="badge">Deadline Alerts</span>
                <span class="badge">Color Coded</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h4>Analytics Dashboard</h4>
            <p>Track your productivity with beautiful charts and comprehensive statistics.</p>
            <div class="service-features">
                <span class="badge">Task Distribution</span>
                <span class="badge">Completion Rate</span>
                <span class="badge">Progress Tracking</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12">
        <div class="data-card text-center">
            <div class="p-4">
                <h5>Need something specific?</h5>
                <p class="text-muted">Contact us for custom solutions and enterprise plans.</p>
                <a href="{{ route('contact') }}" class="btn-primary-custom">Contact Sales →</a>
            </div>
        </div>
    </div>
</div>

<style>
    .service-card {
        background: white;
        border-radius: 20px;
        padding: 30px 25px;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .service-card:hover {
        transform: translateY(-5px);
        border-color: #FFD700;
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    .service-icon {
        width: 70px;
        height: 70px;
        background: #F5F5F5;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        transition: all 0.3s ease;
    }
    .service-card:hover .service-icon {
        background: #FFD700;
    }
    .service-icon i {
        font-size: 32px;
        color: #8B4513;
    }
    .service-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1A1A1A;
    }
    .service-card p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 16px;
    }
    .service-features {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .service-features .badge {
        background: #F5F5F5;
        color: #666;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
    }
</style>
@endsection