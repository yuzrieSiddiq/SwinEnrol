<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Student;
use App\Unit;
use App\EnrolmentUnits;
use App\Config;

class HomeController extends Controller
{
    public function index() {
        $data = [];

        $user = Auth::user();

        $student = Student::where('studentID', '=', '$user->username')->get();
        $data['student'] = $student;

        $enrolled = EnrolmentUnits::with('unit')
            ->where([
                ['studentID', '=', $user->username],
                ['year', '=', Config::find('year')->value],
                ['term', '=', Config::find('semester')->value],
                ['status', '=', 'pending']
            ])->get();
        $data['enrolled'] = $enrolled;

        return view ('student.student', $data);
    }
}
