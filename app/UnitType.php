<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    // table properties
    protected $table = 'unit_type';

    // relation
    public function study_planner()
    {
        return $this->hasMany('App\StudyPlanner', 'unitCode');
    }

    // inverse relation
    public function unit()
	{
		return $this->belongsTo('App\Unit', 'unitCode', 'unitCode');
	}

    public function course()
    {
        return $this->belongsTo('App\Course', 'courseCode', 'courseCode');
    }

    public function type()
    {
        return $this->belongsTo('App\Type', 'typeId', 'typeId');
    }
}
