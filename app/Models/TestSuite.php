<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class TestSuite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['project_id', 'name', 'description', 'parent_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(TestSuite::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TestSuite::class, 'parent_id');
    }

    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }
}
