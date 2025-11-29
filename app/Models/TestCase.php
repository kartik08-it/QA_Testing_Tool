<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id', 'test_suite_id', 'title', 'description', 
        'preconditions', 'steps', 'expected_result', 'priority', 
        'type', 'status', 'automated', 'created_by', 'assigned_to', 
        'estimated_time'
    ];

    protected $casts = [
        'steps' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function testSuite()
    {
        return $this->belongsTo(TestSuite::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function executions()
    {
        return $this->hasMany(TestExecution::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function latestExecution()
    {
        return $this->hasOne(TestExecution::class)->latestOfMany();
    }
}