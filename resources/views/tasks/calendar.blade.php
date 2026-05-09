@extends('layouts.app')

@section('title', 'Calendar')
@section('page-title', '📅 Task Calendar')
@section('page-subtitle', 'View your tasks by due date')

@section('content')
@php
    use App\Models\Task;
    $tasks = Task::where('user_id', auth()->id())->orderBy('due_date')->get();
    
    $totalTasks = $tasks->count();
    $activeTasks = $tasks->where('status', '!=', 'Completed')->count();
    $completedTasks = $tasks->where('status', 'Completed')->count();
    $today = date('Y-m-d');
    $overdueTasks = $tasks->filter(function($t) use ($today) {
        return $t->due_date < $today && $t->status != 'Completed';
    })->count();
    
    // Group tasks by date
    $tasksByDate = [];
    foreach ($tasks as $task) {
        $tasksByDate[$task->due_date][] = $task;
    }
    
    // Calendar calculations
    $currentMonth = request()->get('month', date('n'));
    $currentYear = request()->get('year', date('Y'));
    
    $firstDay = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
    $daysInMonth = date('t', $firstDay);
    $startOffset = date('w', $firstDay);
    
    $prevMonth = $currentMonth - 1;
    $prevYear = $currentYear;
    if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
    
    $nextMonth = $currentMonth + 1;
    $nextYear = $currentYear;
    if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
    
    $monthName = date('F Y', $firstDay);
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
@endphp

<style>
    /* Stats Cards */
    .stats-container {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .stat-item {
        flex: 1;
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: bold;
        color: #1e293b;
    }
    
    .stat-label {
        font-size: 13px;
        color: #64748b;
        margin-top: 5px;
    }
    
    /* Reminder Cards */
    .reminder-container {
        background: white;
        border-radius: 12px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    
    .reminder-title {
        background: #f8fafc;
        padding: 12px 20px;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
    }
    
    .reminder-list {
        padding: 15px 20px;
    }
    
    .reminder-card {
        padding: 12px 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    
    .reminder-card.overdue { background: #fee2e2; border-left: 4px solid #ef4444; }
    .reminder-card.today { background: #fef3c7; border-left: 4px solid #f59e0b; }
    .reminder-card.tomorrow { background: #d1fae5; border-left: 4px solid #10b981; }
    
    .reminder-text strong { display: block; font-size: 14px; }
    .reminder-text small { font-size: 12px; color: #64748b; }
    
    /* Calendar Navigation */
    .calendar-nav {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .nav-btn {
        background: #f1f5f9;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        color: #475569;
        font-size: 14px;
    }
    
    .nav-btn:hover {
        background: #1e293b;
        color: white;
    }
    
    .month-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    
    /* Calendar Grid */
    .calendar-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border: 1px solid #e2e8f0;
        border-top: none;
    }
    
    .calendar-table th {
        padding: 12px;
        text-align: center;
        background: #f8fafc;
        font-weight: 600;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    
    .calendar-table td {
        border: 1px solid #e2e8f0;
        vertical-align: top;
        padding: 8px;
        width: 14.28%;
        height: 100px;
    }
    
    .calendar-day-number {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 5px;
        display: inline-block;
        padding: 3px 8px;
        border-radius: 20px;
    }
    
    .calendar-day.today .calendar-day-number {
        background: #f59e0b;
        color: white;
    }
    
    .calendar-task {
        background: #f1f5f9;
        border-radius: 6px;
        padding: 4px 8px;
        margin-bottom: 4px;
        font-size: 11px;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .calendar-task.high {
        background: #fee2e2;
        border-left: 3px solid #ef4444;
    }
    
    .calendar-task.medium {
        background: #fef3c7;
        border-left: 3px solid #f59e0b;
    }
    
    .calendar-task.low {
        background: #d1fae5;
        border-left: 3px solid #10b981;
    }
    
    /* Legend */
    .calendar-legend {
        background: white;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 12px 12px;
        padding: 12px 20px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .legend {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }
    
    .legend-box {
        width: 24px;
        height: 12px;
        border-radius: 4px;
    }
    
    .legend-box.high { background: #fee2e2; border-left: 3px solid #ef4444; }
    .legend-box.medium { background: #fef3c7; border-left: 3px solid #f59e0b; }
    .legend-box.low { background: #d1fae5; border-left: 3px solid #10b981; }
    .legend-box.today { background: #fef3c7; border: 1px solid #f59e0b; }
    
    .text-center { text-align: center; }
</style>

<div class="container-fluid p-0">
    <!-- Stats Row -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-number">{{ $totalTasks }}</div>
            <div class="stat-label">Total Tasks</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $activeTasks }}</div>
            <div class="stat-label">Active Tasks</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $completedTasks }}</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" style="color: #ef4444;">{{ $overdueTasks }}</div>
            <div class="stat-label">Overdue</div>
        </div>
    </div>

    <!-- Reminders -->
    @php
        $hasReminder = false;
    @endphp
    
    <div class="reminder-container">
        <div class="reminder-title">⏰ Upcoming Reminders</div>
        <div class="reminder-list">
            @foreach($tasks as $task)
                @if($task->due_date < $today && $task->status != 'Completed')
                    @php $hasReminder = true; @endphp
                    <div class="reminder-card overdue" onclick="window.location='{{ route('tasks.edit', $task->id) }}'">
                        <div class="reminder-text">
                            <strong>⚠️ {{ $task->title }}</strong>
                            <small>Overdue - Due: {{ date('M d, Y', strtotime($task->due_date)) }}</small>
                        </div>
                        <i class="fas fa-exclamation-circle" style="color: #ef4444;"></i>
                    </div>
                @elseif($task->due_date == $today && $task->status != 'Completed')
                    @php $hasReminder = true; @endphp
                    <div class="reminder-card today" onclick="window.location='{{ route('tasks.edit', $task->id) }}'">
                        <div class="reminder-text">
                            <strong>🔔 {{ $task->title }}</strong>
                            <small>Due Today!</small>
                        </div>
                        <i class="fas fa-bell" style="color: #f59e0b;"></i>
                    </div>
                @elseif($task->due_date == $tomorrow && $task->status != 'Completed')
                    @php $hasReminder = true; @endphp
                    <div class="reminder-card tomorrow" onclick="window.location='{{ route('tasks.edit', $task->id) }}'">
                        <div class="reminder-text">
                            <strong>⏳ {{ $task->title }}</strong>
                            <small>Due Tomorrow</small>
                        </div>
                        <i class="fas fa-hourglass-half" style="color: #10b981;"></i>
                    </div>
                @endif
            @endforeach
            
            @if(!$hasReminder)
                <div style="text-align: center; padding: 20px; color: #64748b;">
                    <i class="fas fa-check-circle" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                    No upcoming reminders! Great job!
                </div>
            @endif
        </div>
    </div>

    <!-- Calendar -->
    <div class="calendar-nav">
        <a href="?month={{ $prevMonth }}&year={{ $prevYear }}" class="nav-btn">
            <i class="fas fa-chevron-left"></i> Previous
        </a>
        <h3 class="month-title">{{ $monthName }}</h3>
        <a href="?month={{ $nextMonth }}&year={{ $nextYear }}" class="nav-btn">
            Next <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <table class="calendar-table">
        <thead>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            @for($i = 0; $i < $startOffset; $i++)
                <td class="calendar-day"></td>
            @endfor
            
            @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $dateStr = sprintf("%04d-%02d-%02d", $currentYear, $currentMonth, $day);
                    $isToday = ($dateStr == date('Y-m-d'));
                    $dayTasks = $tasksByDate[$dateStr] ?? [];
                @endphp
                
                <td class="calendar-day {{ $isToday ? 'today' : '' }}">
                    <span class="calendar-day-number">{{ $day }}</span>
                    @foreach($dayTasks as $task)
                        @php
                            $priorityClass = strtolower($task->priority);
                        @endphp
                        <div class="calendar-task {{ $priorityClass }}" 
                             onclick="window.location='{{ route('tasks.edit', $task->id) }}'"
                             title="{{ $task->title }}">
                            {{ strlen($task->title) > 15 ? substr($task->title, 0, 12) . '...' : $task->title }}
                        </div>
                    @endforeach
                </td>
                
                @if(($startOffset + $day) % 7 == 0 && $day != $daysInMonth)
                    <tr>
                @endif
            @endfor
            
            @php
                $remaining = (7 - (($startOffset + $daysInMonth) % 7)) % 7;
            @endphp
            @for($i = 0; $i < $remaining; $i++)
                <td class="calendar-day"></td>
            @endfor
            </tr>
        </tbody>
    </table>

    <div class="calendar-legend">
        <div class="legend"><div class="legend-box high"></div><span>High Priority</span></div>
        <div class="legend"><div class="legend-box medium"></div><span>Medium Priority</span></div>
        <div class="legend"><div class="legend-box low"></div><span>Low Priority</span></div>
        <div class="legend"><div class="legend-box today"></div><span>Today</span></div>
    </div>
</div>
@endsection
