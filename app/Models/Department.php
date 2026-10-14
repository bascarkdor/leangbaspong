<?php

namespace App\Models;

use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    /** @use HasFactory<DepartmentFactory> */
    use HasFactory;

    protected $primaryKey = 'dept_id';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'dept_name',
        'manager_id',
        'location_id',
    ];

    /**
     * Get the students belonging to this department.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'dept_id', 'dept_id');
    }
}
