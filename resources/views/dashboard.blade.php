@extends('layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics Dashboard')
@section('page-subtitle', 'Overview of your task performance')

@section('content')
<div class="row fade-in">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-value">{{ $totalTasks ?? 0 }}</div>
            <div class="stat-card-label">Total Tasks</div>
            <div class="stat-card-icon-sm">
                <i class="fas fa-tasks"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-value">{{ $pendingTasks ?? 0 }}</div>
            <div class="stat-card-label">Pending</div>
            <div class="stat-card-icon-sm">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-value">{{ $inProgressTasks ?? 0 }}</div>
            <div class="stat-card-label">In Progress</div>
            <div class="stat-card-icon-sm">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-value">{{ $completedTasks ?? 0 }}</div>
            <div class="stat-card-label">Completed</div>
            <div class="stat-card-icon-sm">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="row fade-in mt-4">
    <div class="col-md-6">
        <div class="data-card">
            <div class="data-card-header">
                <h5><i class="fas fa-chart-pie"></i> Task Distribution</h5>
            </div>
            <div class="p-4 text-center">
                <canvas id="taskChart" style="max-width: 300px; margin: 0 auto;"></canvas>
                <div class="chart-legend mt-3">
                    <div class="legend-item">
                        <span class="legend-color" style="background: #FFD700;"></span>
                        <span>Pending ({{ $pendingTasks ?? 0 }})</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #8B4513;"></span>
                        <span>In Progress ({{ $inProgressTasks ?? 0 }})</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #22C55E;"></span>
                        <span>Completed ({{ $completedTasks ?? 0 }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="data-card">
            <div class="data-card-header">
                <h5><i class="fas fa-chart-simple"></i> Quick Overview</h5>
            </div>
            <div class="p-4">
                <div class="overview-stats">
                    <div class="overview-item">
                        <div class="overview-label">Completion Rate</div>
                        <div class="overview-value">{{ $completionPercentage ?? 0 }}%</div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: {{ $completionPercentage ?? 0 }}%; background: #22C55E;"></div>
                        </div>
                    </div>
                    <div class="overview-item mt-3">
                        <div class="overview-label">Overdue Tasks</div>
                        <div class="overview-value text-danger">{{ $overdueTasks ?? 0 }}</div>
                    </div>
                    <div class="overview-item mt-3">
                        <div class="overview-label">Active Tasks</div>
                        <div class="overview-value">{{ ($pendingTasks ?? 0) + ($inProgressTasks ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row fade-in mt-4">
    <div class="col-md-12">
        <div class="data-card">
            <div class="data-card-header">
                <h5><i class="fas fa-calendar"></i> Upcoming Deadlines</h5>
                <a href="{{ route('tasks.index') }}" class="btn-outline-custom btn-sm">View All</a>
            </div>
            <div class="p-0">
                <table class="data-table table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Subject</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($upcomingDeadlines ?? []) as $task)
                        <tr>
                            <td>
                                <div class="task-title-cell">
                                    <strong>{{ $task->title }}</strong>
                                    @if($task->description)<br><small class="text-muted">{{ Str::limit($task->description, 40) }}</small>@endif
                                </div>
                            </td>
                            <td>{{ $task->subject }}</td>
                            <td>
                                @if($task->priority == 'High')
                                    <span class="priority-badge priority-high">
                                        <i class="fas fa-flag"></i> High
                                    </span>
                                @elseif($task->priority == 'Medium')
                                    <span class="priority-badge priority-medium">
                                        <i class="fas fa-chart-line"></i> Medium
                                    </span>
                                @else
                                    <span class="priority-badge priority-low">
                                        <i class="fas fa-check-circle"></i> Low
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $dueDate = \Carbon\Carbon::parse($task->due_date);
                                    $isOverdue = $dueDate->isPast() && $task->status != 'Completed';
                                    $isToday = $dueDate->isToday();
                                @endphp
                                @if($isOverdue)
                                    <span class="text-danger fw-bold">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $dueDate->format('M d, Y') }}
                                    </span>
                                @elseif($isToday)
                                    <span class="text-warning fw-bold">
                                        <i class="fas fa-bell"></i> Today
                                    </span>
                                @else
                                    {{ $dueDate->format('M d, Y') }}
                                @endif
                            </td>
                            <td>
                                @if($task->status == 'Pending')
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @elseif($task->status == 'In Progress')
                                    <span class="status-badge status-progress">
                                        <i class="fas fa-spinner fa-pulse"></i> In Progress
                                    </span>
                                @else
                                    <span class="status-badge status-completed">
                                        <i class="fas fa-check-circle"></i> Completed
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No upcoming deadlines
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    /* Dashboard specific styles */
    .stat-card {
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-icon-sm {
        position: absolute;
        bottom: 12px;
        right: 16px;
        font-size: 32px;
        opacity: 0.15;
        color: #8B4513;
    }
    
    .chart-legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #666;
    }
    
    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 4px;
    }
    
    .overview-stats {
        padding: 10px;
    }
    
    .overview-item {
        margin-bottom: 20px;
    }
    
    .overview-label {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .overview-value {
        font-size: 28px;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 8px;
    }
    
    .text-danger {
        color: #DC2626 !important;
    }
    
    .text-warning {
        color: #D97706 !important;
    }
    
    .progress-bar-custom {
        background: #F0F0F0;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
    }
    
    /* Priority Badges */
    .priority-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .priority-high {
        background: #DC2626;
        color: white;
    }
    
    .priority-medium {
        background: #FFD700;
        color: #1A1A1A;
    }
    
    .priority-low {
        background: #22C55E;
        color: white;
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-pending {
        background: #FFD700;
        color: #1A1A1A;
    }
    
    .status-progress {
        background: #8B4513;
        color: white;
    }
    
    .status-completed {
        background: #22C55E;
        color: white;
    }
    
    .task-title-cell {
        line-height: 1.4;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pending = {{ $pendingTasks ?? 0 }};
        const inProgress = {{ $inProgressTasks ?? 0 }};
        const completed = {{ $completedTasks ?? 0 }};
        
        if (pending > 0 || inProgress > 0 || completed > 0) {
            const ctx = document.getElementById('taskChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'In Progress', 'Completed'],
                    datasets: [{
                        data: [pending, inProgress, completed],
                        backgroundColor: ['#FFD700', '#8B4513', '#22C55E'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw} tasks`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush