@extends('layouts.app')

@section('title', 'Archive')
@section('page-title', 'Archived Tasks')
@section('page-subtitle', 'Restore or permanently delete archived tasks')

@section('content')
<div class="fade-in">
    <div class="data-card">
        <div class="data-card-header">
            <h5><i class="fas fa-archive"></i> Archived Tasks</h5>
            <a href="{{ route('tasks.index') }}" class="btn-outline-custom btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Tasks
            </a>
        </div>
        <div class="p-0">
            <table class="data-table table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task Title</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedTasks as $index => $task)
                    <tr>
                        <td>{{ $trashedTasks->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $task->title }}</strong>
                            @if($task->description)<br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>@endif
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
                        <td>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                        <td>{{ $task->deleted_at->format('M d, Y H:i') }}</td>
                        <td>
                            <form action="{{ route('tasks.restore', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-sm btn-outline-custom" style="border-color:#22C55E; color:#22C55E;">
                                    <i class="fas fa-trash-restore"></i> Restore
                                </button>
                            </form>
                            <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-outline-custom" style="border-color:#DC2626; color:#DC2626;" onclick="return confirm('Permanently delete this task? This cannot be undone!')">
                                    <i class="fas fa-trash-alt"></i> Permanent
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-archive fa-3x mb-2 d-block"></i>
                            No archived tasks found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $trashedTasks->links() }}
        </div>
    </div>
</div>

<style>
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
    
    .btn-sm {
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-sm:hover {
        transform: translateY(-1px);
    }
    
    /* Restore button hover */
    .btn-outline-custom[style*="#22C55E"]:hover {
        background: #22C55E;
        color: white !important;
    }
    
    /* Permanent delete button hover */
    .btn-outline-custom[style*="#DC2626"]:hover {
        background: #DC2626;
        color: white !important;
    }
</style>
@endsection