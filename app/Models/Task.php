<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    // Feature 7: Mass Assignment
    protected $fillable = [
        'title',
        'description',
        'subject',
        'priority',
        'due_date',
        'status',
        'user_id'
    ];

    // Feature 3: Using Where Condition In Eloquent (Scopes)
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'In Progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'High');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
