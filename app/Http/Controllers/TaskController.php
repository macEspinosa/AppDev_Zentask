<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Dashboard with advanced statistics
     * Feature: Aggregates, Charts data, Completion rate
     */
    public function dashboard()
    {
        $userId = auth()->id();
        
        // Basic statistics
        $totalTasks = Task::where('user_id', $userId)->count();
        $pendingTasks = Task::where('user_id', $userId)->where('status', 'Pending')->count();
        $inProgressTasks = Task::where('user_id', $userId)->where('status', 'In Progress')->count();
        $completedTasks = Task::where('user_id', $userId)->where('status', 'Completed')->count();
        
        // Completion percentage
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        
        // Upcoming deadlines (next 7 days)
        $upcomingDeadlines = Task::where('user_id', $userId)
            ->where('status', '!=', 'Completed')
            ->where('due_date', '>=', Carbon::today())
            ->where('due_date', '<=', Carbon::today()->addDays(7))
            ->orderBy('due_date')
            ->get();
        
        // Overdue tasks
        $overdueTasks = Task::where('user_id', $userId)
            ->where('status', '!=', 'Completed')
            ->where('due_date', '<', Carbon::today())
            ->count();
        
        // Priority distribution
        $highPriority = Task::where('user_id', $userId)->where('priority', 'High')->count();
        $mediumPriority = Task::where('user_id', $userId)->where('priority', 'Medium')->count();
        $lowPriority = Task::where('user_id', $userId)->where('priority', 'Low')->count();
        
        // Recent activities (last 5 tasks)
        $recentActivities = Task::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        // Weekly progress (last 7 days)
        $weeklyProgress = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyProgress[$date->format('D')] = Task::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
        }
        
        return view('dashboard', compact(
            'totalTasks', 'pendingTasks', 'inProgressTasks', 'completedTasks',
            'completionPercentage', 'upcomingDeadlines', 'overdueTasks',
            'highPriority', 'mediumPriority', 'lowPriority', 'recentActivities',
            'weeklyProgress'
        ));
    }

    /**
     * Feature 2 & 3: Retrieving Records with filtering and sorting
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        
        // Build query with filters
        $query = Task::where('user_id', $userId);
        
        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by priority
        if ($request->has('priority') && $request->priority != 'all') {
            $query->where('priority', $request->priority);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'due_date');
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy($sortBy, $sortOrder);
        
        $tasks = $query->paginate(10);
        
        // Statistics for sidebar
        $pendingTasks = Task::where('user_id', $userId)->where('status', 'Pending')->count();
        $inProgressTasks = Task::where('user_id', $userId)->where('status', 'In Progress')->count();
        $completedTasks = Task::where('user_id', $userId)->where('status', 'Completed')->count();
        
        return view('tasks.index', compact('tasks', 'pendingTasks', 'inProgressTasks', 'completedTasks'));
    }

    /**
     * Show create task form
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Feature 4: Inserting Or Saving Data With Eloquent
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'priority' => 'required|in:High,Medium,Low',
            'due_date' => 'required|date|after_or_equal:today',
        ], [
            'title.required' => 'Task title is required',
            'title.min' => 'Task title must be at least 3 characters',
            'subject.required' => 'Subject is required',
            'priority.required' => 'Please select a priority',
            'due_date.required' => 'Due date is required',
            'due_date.after_or_equal' => 'Due date cannot be in the past',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'status' => 'Pending',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task "' . $task->title . '" created successfully!');
    }

    /**
     * Feature 2: Retrieving single record for edit
     */
    public function edit($id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('tasks.edit', compact('task'));
    }

    /**
     * Feature 5: Updating Data With Eloquent
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'priority' => 'required|in:High,Medium,Low',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);
        
        $oldStatus = $task->status;
        $task->update($validated);
        
        $message = 'Task "' . $task->title . '" updated successfully!';
        
        // Add special message for completion
        if ($oldStatus != 'Completed' && $task->status == 'Completed') {
            $message = '🎉 Congratulations! Task "' . $task->title . '" is completed!';
        }
        
        return redirect()->route('tasks.index')->with('success', $message);
    }

    /**
     * Quick status update (AJAX ready)
     */
    public function updateStatus(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $task->update(['status' => $request->status]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $task->status]);
        }
        
        return redirect()->route('tasks.index')->with('success', 'Status updated to ' . $task->status);
    }

    /**
     * Feature 6 & 8: Deleting Data (Soft Delete Trashing)
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $taskTitle = $task->title;
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task "' . $taskTitle . '" moved to trash!');
    }

    /**
     * Feature 9: Retrieving Soft Deleted Data
     */
    public function trashed(Request $request)
    {
        $query = Task::onlyTrashed()->where('user_id', auth()->id());
        
        // Search in trashed
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }
        
        $trashedTasks = $query->orderBy('deleted_at', 'desc')->paginate(10);
        
        // Statistics
        $pendingTasks = Task::where('user_id', auth()->id())->where('status', 'Pending')->count();
        $inProgressTasks = Task::where('user_id', auth()->id())->where('status', 'In Progress')->count();
        $completedTasks = Task::where('user_id', auth()->id())->where('status', 'Completed')->count();
        
        return view('tasks.trashed', compact('trashedTasks', 'pendingTasks', 'inProgressTasks', 'completedTasks'));
    }

    /**
     * Feature 10: Restore A Record
     */
    public function restore($id)
    {
        $task = Task::onlyTrashed()->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $taskTitle = $task->title;
        $task->restore();

        return redirect()->route('tasks.trashed')
            ->with('success', 'Task "' . $taskTitle . '" restored successfully!');
    }

    /**
     * Feature 10: Delete Record Permanently
     */
    public function forceDelete($id)
    {
        $task = Task::onlyTrashed()->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $taskTitle = $task->title;
        $task->forceDelete();

        return redirect()->route('tasks.trashed')
            ->with('success', 'Task "' . $taskTitle . '" permanently deleted!');
    }
    
    /**
     * Bulk delete multiple tasks
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Task::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
            return response()->json(['success' => true, 'message' => count($ids) . ' tasks moved to trash']);
        }
        return response()->json(['success' => false, 'message' => 'No tasks selected']);
    }
    
    /**
     * Export tasks to CSV
     */
    public function exportCSV()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        $filename = 'tasks_' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['ID', 'Title', 'Subject', 'Priority', 'Due Date', 'Status', 'Created At']);
        
        foreach ($tasks as $task) {
            fputcsv($handle, [
                $task->id, $task->title, $task->subject, 
                $task->priority, $task->due_date, $task->status, $task->created_at
            ]);
        }
        
        return response()->stream(function() use ($handle) {
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    // ============================================
    // CALENDAR METHODS (ADDED)
    // ============================================
    
    /**
     * Calendar view page - Display tasks in calendar format
     */
    public function calendar()
    {
        return view('tasks.calendar');
    }

    /**
     * Get calendar data as JSON for FullCalendar
     * Returns all tasks with due dates, colors based on priority
     */
    public function calendarData()
    {
        $userId = auth()->id();
        
        // Get all tasks for the logged-in user
        $tasks = Task::where('user_id', $userId)
            ->select('id', 'title', 'description', 'subject', 'priority', 'status', 'due_date')
            ->orderBy('due_date')
            ->get();
        
        $events = [];
        
        foreach ($tasks as $task) {
            // Set color based on priority
            switch ($task->priority) {
                case 'High':
                    $backgroundColor = '#FEE2E2';
                    $textColor = '#991B1B';
                    break;
                case 'Medium':
                    $backgroundColor = '#FEF3C7';
                    $textColor = '#92400E';
                    break;
                case 'Low':
                    $backgroundColor = '#D1FAE5';
                    $textColor = '#065F46';
                    break;
                default:
                    $backgroundColor = '#F1F5F9';
                    $textColor = '#475569';
            }
            
            // Build event object for FullCalendar
            $events[] = [
                'id' => $task->id,
                'title' => $task->title,
                'start' => $task->due_date,
                'end' => $task->due_date,
                'allDay' => true,
                'backgroundColor' => $backgroundColor,
                'borderColor' => 'transparent',
                'textColor' => $textColor,
                'extendedProps' => [
                    'description' => $task->description ?? 'No description provided',
                    'subject' => $task->subject,
                    'priority' => $task->priority,
                    'status' => $task->status,
                    'taskId' => $task->id,
                    'due_date' => $task->due_date
                ]
            ];
        }
        
        return response()->json($events);
    }
}
