<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestExecution extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_run_id', 'test_case_id', 'executed_by', 'status', 
        'actual_result', 'comments', 'execution_time', 'executed_at'
    ];

    protected $casts = [
        'executed_at' => 'datetime',
    ];

    public function testRun()
    {
        return $this->belongsTo(TestRun::class);
    }

    public function testCase()
    {
        return $this->belongsTo(TestCase::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }

    public function defects()
    {
        return $this->hasMany(Defect::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}