<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color'];

    public function testCases()
    {
        return $this->morphedByMany(TestCase::class, 'taggable');
    }

    public function defects()
    {
        return $this->morphedByMany(Defect::class, 'taggable');
    }
}