<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    protected $primaryKey = 'student_id';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'student_name',
        'gender',
        'dob',
        'enrollment',
        'enrollment_date',
        'description',
        'dept_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'enrollment_date' => 'date',
        ];
    }

    /**
     * Get the department that the student belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }
}
