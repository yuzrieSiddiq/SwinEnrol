<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // primary key
    protected $primaryKey = 'courseCode';
    public $incrementing = false;

    // course relation
    public function unit()
    {
        return $this->hasMany('App\Unit', 'courseCode');
    }

    public function internal_course_transfer()
    {
        return $this->hasMany('App\InternalCourseTransfer', 'courseCode');
    }
}