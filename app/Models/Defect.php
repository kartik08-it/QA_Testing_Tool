<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Defect extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id', 'test_execution_id', 'title', 'description', 
        'steps_to_reproduce', 'severity', 'priority', 'status', 
        'environment', 'reported_by', 'assigned_to'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function testExecution()
    {
        return $this->belongsTo(TestExecution::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}