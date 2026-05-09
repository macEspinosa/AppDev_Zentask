@extends('layouts.app')

@section('title', 'Task Management')
@section('page-title', 'Task Management')
@section('page-subtitle', 'Manage and track all your tasks')

@section('styles')
<style>
    /* Modal Styles */
    .modal-custom .modal-content {
        border-radius: 16px;
        border: none;
    }
    
    .modal-custom .modal-header {
        background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        border-bottom: none;
    }
    
    .modal-custom .btn-close {
        filter: brightness(0) invert(1);
    }
    
    .form-control-custom {
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.875rem;
        width: 100%;
        transition: all 0.2s;
    }
    
    .form-control-custom:focus {
        border-color: #1E293B;
        outline: none;
        box-shadow: 0 0 0 3px rgba(30,41,59,0.1);
    }
    
    .btn-primary-custom {
        background: #1E293B;
        border: none;
        padding: 8px 24px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: #0F172A;
    }
    
    .btn-outline-custom {
        background: transparent;
        border: 1px solid #CBD5E1;
        padding: 8px 24px;
        border-radius: 8px;
        color: #475569;
        transition: all 0.2s;
    }
    
    .btn-outline-custom:hover {
        background: #F1F5F9;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .status-pending { background: #F1F5F9; color: #475569; }
    .status-in-progress { background: #DBEAFE; color: #1E40AF; }
    .status-completed { background: #D1FAE5; color: #065F46; }
    
    .priority-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .priority-high { background: #FEE2E2; color: #991B1B; }
    .priority-medium { background: #FEF3C7; color: #92400E; }
    .priority-low { background: #D1FAE5; color: #065F46; }
</style>
@endsection

@section('content')
<div class="fade-in">
    <div class="data-card">
        <div class="data-card-header">
            <h5><i class="fas fa-list"></i> All Tasks</h5>
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                <i class="fas fa-plus"></i> New Task
            </button>
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $index => $task)
                    <tr>
                        <td>{{ $tasks->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $task->title }}</strong>
                            @if($task->description)<br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>@endif
                        </td>
                        <td>{{ $task->subject }}</td>
                        <td><span class="priority-badge priority-{{ strtolower($task->priority) }}">{{ $task->priority }}</span></td>
                        <td @class(['text-danger fw-bold' => $task->due_date < now()])>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="title" value="{{ $task->title }}">
                                <input type="hidden" name="subject" value="{{ $task->subject }}">
                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                <input type="hidden" name="due_date" value="{{ $task->due_date }}">
                                <select name="status" class="form-select form-select-sm d-inline w-auto" style="width: 120px;" onchange="this.form.submit()">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn-outline-custom btn-sm" style="padding: 4px 12px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-outline-custom btn-sm" style="border-color:#FEE2E2; color:#991B1B; padding: 4px 12px;" onclick="return confirm('Move to archive?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-2"></i>
                            <p>No tasks yet. Click "New Task" to create your first task!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $tasks->links() }}
        </div>
    </div>
</div>

<!-- Modal for Creating New Task -->
<div class="modal fade modal-custom" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control-custom" placeholder="Enter task title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control-custom" rows="3" placeholder="Enter task description..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control-custom" placeholder="e.g., Mathematics" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                            <select name="priority" class="form-control-custom">
                                <option value="High">🔴 High Priority</option>
                                <option value="Medium">🟡 Medium Priority</option>
                                <option value="Low">🟢 Low Priority</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                            <input type="date" name="due_date" class="form-control-custom" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
