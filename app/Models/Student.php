<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_name',
        'email',
        'gender',
        'enrollment_date',
        'description',
        'dept_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }

    // Accessor to calculate years enrolled dynamically
    public function getYearsEnrolledAttribute()
    {
        if (!$this->enrollment_date) return 0;
        $enrollDate = Carbon::parse($this->enrollment_date);
        return number_format($enrollDate->diffInDays(now()) / 365.25, 1);
    }
}