<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CollegeCourse extends Pivot
{
    protected $table = 'college_course';

    protected $casts = [
        'course_details' => 'array',
        'eligibility' => 'array',
        'fees' => 'decimal:2'
    ];
}