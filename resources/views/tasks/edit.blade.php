@extends('layouts.app')

@section('title', 'Edit Task')
@section('page-title', 'Edit Task')
@section('page-subtitle', 'Update task details')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <div class="data-card">
            <div class="data-card-header">
                <h5><i class="fas fa-edit"></i> Edit Task</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Task Title</label>
                        <input type="text" name="title" class="form-control-custom w-100" value="{{ $task->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control-custom w-100" rows="3">{{ $task->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" class="form-control-custom w-100" value="{{ $task->subject }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Priority</label>
                            <select name="priority" class="form-control-custom w-100">
                                <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Due Date</label>
                            <input type="date" name="due_date" class="form-control-custom w-100" value="{{ $task->due_date }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-control-custom w-100">
                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Update Task</button>
                        <a href="{{ route('tasks.index') }}" class="btn-outline-custom">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
