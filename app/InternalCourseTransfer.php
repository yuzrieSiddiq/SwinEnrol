<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalCourseTransfer extends Model
{
    protected $table = 'internal_course_transfer';

    // inverse relation
    public function student()
	{
		return $this->belongsTo('App\Student', 'studentID', 'studentID');
	}

	public function course()
	{
		return $this->belongsTo('App\Course', 'courseCode', 'courseCode');
	}
}
