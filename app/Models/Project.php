<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'description', 
        'key', 
        'created_by', 
        'status'
    ];

    /**
     * Get the user who created the project
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all members of this project
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Get all test suites for this project
     */
    public function testSuites()
    {
        return $this->hasMany(TestSuite::class);
    }

    /**
     * Get all test cases for this project
     */
    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }

    /**
     * Get all test runs for this project
     */
    public function testRuns()
    {
        return $this->hasMany(TestRun::class);
    }

    /**
     * Get all defects for this project
     */
    public function defects()
    {
        return $this->hasMany(Defect::class);
    }

    /**
     * Check if user is a member of this project
     */
    public function hasMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    /**
     * Add a member to this project
     */
    public function addMember($userId, $role = 'member')
    {
        return $this->members()->attach($userId, ['role' => $role]);
    }

    /**
     * Remove a member from this project
     */
    public function removeMember($userId)
    {
        return $this->members()->detach($userId);
    }

    /**
     * Scope to get projects accessible by a user
     */
    public function scopeAccessibleBy($query, $userId)
    {
        return $query->where('created_by', $userId)
                     ->orWhereHas('members', function($q) use ($userId) {
                         $q->where('user_id', $userId);
                     });
    }
}