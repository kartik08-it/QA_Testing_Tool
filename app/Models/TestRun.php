<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestRun extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id', 'name', 'description', 'environment', 
        'build_version', 'created_by', 'started_at', 'completed_at', 'status'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function executions()
    {
        return $this->hasMany(TestExecution::class);
    }

    public function getPassRateAttribute()
    {
        $total = $this->executions()->count();
        if ($total === 0) return 0;
        
        $passed = $this->executions()->where('status', 'passed')->count();
        return round(($passed / $total) * 100, 2);
    }

    public function getStatusCountsAttribute()
    {
        return [
            'passed' => $this->executions()->where('status', 'passed')->count(),
            'failed' => $this->executions()->where('status', 'failed')->count(),
            'blocked' => $this->executions()->where('status', 'blocked')->count(),
            'skipped' => $this->executions()->where('status', 'skipped')->count(),
            'pending' => $this->executions()->where('status', 'pending')->count(),
        ];
    }
}
