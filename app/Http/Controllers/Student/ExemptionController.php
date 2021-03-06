<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Course;
use App\Student;
use App\EnrolmentIssues;
use App\StudentEnrolmentIssues;
use App\CourseCoordinator;
use App\UnitListing;
use App\Unit;
use App\Config;
use Carbon\Carbon;

class ExemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        $user = Auth::user(); // get user information

        // get user student and coordinator
        $student = Student::where('studentID', '=', $user->username)->first();
        $studentcourse = Course::where('courseCode', '=', $student->courseCode)->first();
        $coursecoordinator = CourseCoordinator::where('courseCode', '=', $student->courseCode)->first();

        $data['student'] = $student;
        $data['studentcourse'] = $studentcourse;
        $data['coursecoordinator'] = $coursecoordinator;

        // get previous, current and next year
        $currentyear = Carbon::now()->year;
        $nextyear = Carbon::now()->addYears(1)->year;
        $next2year = Carbon::now()->addYears(2)->year;
        $data['currentyear'] = $currentyear;
        $data['nextyear'] = $nextyear;
        $data['next2year'] = $next2year;

        // get current enrolment units
        $data['semesterUnits'] = UnitListing::with('unit')
        ->where('year', '=', Config::find('year')->value)
        ->where('semester', '=', Config::find('semester')->value)
        ->get();

        $data['units'] = Unit::with('requisite')->get(); // get units with requisites

        $data['allunits'] = Unit::all(); // get all units

        return view('student.exemption', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only([
            'issueID',
            'submissionData',
            'attachmentData'
        ]);

        $issue = new StudentEnrolmentIssues;
        $issue->studentID = Auth::user()->username;
        $issue->issueID = $input['issueID'];
        $issue->status = 'pending';
        $issue->submissionData = $input['submissionData'];
        $issue->attachmentData = $input['attachmentData'];
        $issue->save();

        return response()->json($issue);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
