<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Student;
use App\Unit;
use App\EnrolmentUnits;
use DB;
use Carbon\Carbon;
use App\Config;
use App\Course;
use App\UnitListing;
use App\StudyPlanner;
use App\StudentEnrolmentIssues;
use App\Requisite;

// student's unit operation is different. it should only add units to student's info

class ManageUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json();
        $data = [];

        $user = Auth::user(); // get username
        $data['student'] = Student::where('studentID', '=', $user->username)->get(); // get student information
        $data['enrolled'] = EnrolmentUnits::with('unit')->where('studentID', '=', $user->username)->get(); // get enrolled units
        $data['units'] = Unit::all(); // get all units

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get config information
        $data['phase'] = Config::find('enrolmentPhase');
        $data['year'] = Config::find('year');
        $data['semester'] = Config::find('semester');

        // get student information
        $user = Auth::user();
        $student = Student::find($user->username);
        $course = Course::find($student->courseCode);

        // get semester for unit listing
        $listingsemester = Config::find('semester')->value + 1;
        $listingyear = Config::find('year')->value;
        // because the config contains the value for current semester so we need to change it accordingly
        // because a unit listing shows the list for next semester
        if (Config::find('semester')->value == 'Semester 1') {
            $listingsemester = 'Semester 2';
        } else {
            // if semester 2 in 2016
            $listingyear += 1; // +1 year
            $listingsemester = 'Semester 1';
        }
        $data['listingyear'] = $listingyear;
        $data['listingsemester'] = $listingsemester;

        // check if foundation student
        if($course->studyLevel == 'Foundation')
        {
            // get courses from degree
            $data['courses'] = Course::where('studyLevel', '=', 'degree')->get();

            // get all units in current course - according to study planner
            $courseUnits = StudyPlanner::with('course')
            ->where('courseCode', '=', $student->courseCode)
            ->get();

            // get all completed units in current course
            $completedUnits = EnrolmentUnits::with('student')
            ->where('studentID', '=', $student->studentID)
            ->where('grade', '=', 'pass')
            ->get();

            // check foundation completion
            $completed = true;
            $status = false;
            foreach($courseUnits as $courseUnit)
            {
                foreach($completedUnits as $completedUnit)
                {
                    if($courseUnit->unitCode == $completedUnit->unitCode)
                    {
                        // set status to true and exit loop
                        $status = true;
                        break;
                    }
                    else
                        $status = false;
                }
                if($status == false)
                    $completed = false;
            }
            // show form if foundation completed
            if($completed == true)
                return view('student.selectcourse', $data);
        }

        // get all enrolled units for the upcoming semester
        $enrolled = EnrolmentUnits::with('unit')
        ->where('studentID', '=', $user->username)
        ->where('year', '=', Config::find('year')->value)
        ->where('semester', '=', Config::find('semester')->value)
        ->get();

        // sort enrolled units into long/short semesters
        $data['enrolledLong'] = [];
        $data['enrolledShort'] = [];
        foreach($enrolled as $unit)
        {
            if($unit->semesterLength == 'long')
                array_push($data['enrolledLong'], $unit); // add to long semester
            if($unit->semesterLength == 'short')
                array_push($data['enrolledShort'], $unit); // add to short semester
        }

        // get all current units - according to UnitListing
        $allUnits = UnitListing::with('unit')
        ->where('year', '=', $listingyear)
        ->where('semester', '=', $listingsemester)
        ->get();

        // filter units according to level of study
        $units = [];
        foreach($allUnits as $unit)
        {
            if($unit['unit']->studyLevel == $course->studyLevel)
                array_push($units, $unit); // push to units if study level matches
        }
        $data['units'] = $units;

        // sort units into long/short semesters
        $exists = false;
        $data['longSemester'] = [];
        $data['shortSemester'] = [];
        foreach($units as $unit)
        {
            if($unit->semesterLength == 'long')
            {
                foreach($data['enrolledLong'] as $enrolledUnit)
                {
                    if($unit->unitCode == $enrolledUnit->unitCode)
                        $exists = true; // if unit exists in long semester set to true
                }
                if($exists == false)
                    array_push($data['longSemester'], $unit); // push to long semester if not existing
                $exists = false;
            }

            if($unit->semesterLength == 'short')
            {
                foreach($data['enrolledShort'] as $enrolledUnit)
                {
                    if($unit->unitCode == $enrolledUnit->unitCode)
                        $exists = true; // if unit exists in short semester set to true
                }
                if($exists == false)
                    array_push($data['shortSemester'], $unit); // push to short semester if not existing
                $exists = false;
            }
        }

        // get all enrolment amendments
        $amendments = StudentEnrolmentIssues::where('studentID', '=', $user->username)
                                            ->where('issueID', '=', 4)->get();

        // Mini - Study Planner
        $data['year'] = $student->year;
        $data['term'] = $student->term;
        $data['planner'] = StudyPlanner::with('unit', 'course')
        ->where([
            ['year', '=', $data['year']],
            ['semester', '=', $data['term']],
            ['courseCode', '=', $student->courseCode]
        ])
        ->get();

        // get requisites
        $requisites = Requisite::all();

        // sort requisites
        $semesterUnits = $data['planner'];
        foreach($semesterUnits as $unit)
        {
            foreach($requisites as $requisite)
            {
                if($requisite->unitCode == $unit->unitCode)
                {
                    // only show prerequisite
                    if($requisite->type == 'prerequisite')
                        $data['requisite'][$unit->unitCode]['prerequisite'][] = $requisite->requisite;
                }
            }
        }

        // get semester size
        $data['size'] = Config::find('semesterLength')->value;

        // get semester unit count
        for($n = 0; $n < $data['size']; $n++)
        {
            $count[$n] = StudyPlanner::where([
                    [ 'year', '=', $data['year'] ],
                    [ 'semester', '=', $data['term'] ],
                    [ 'courseCode', '=', $student->courseCode ],
                    [ 'enrolmentTerm', '=', $n ]
                ])->count();
        }
        $data['count'] = $count;

        // generate year/semester strings
        // this term is to not semester, its a custom string to indicate the semester
        for($n = 0; $n < $data['size']; $n++)
            $term[$n] = 'Year ' . (1 + (($n - $n % 3) / 3)) . ' Semester ' . (1 + $n % 3);
        $data['semesters'] = $term;

        return view ('student.manageunits', $data);
        // return response()->json($data);
    }

    /**
     * Updates student's course when articulating
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function articulate(Request $request)
    {
        $input = $request->only([
            'courseCode'
        ]);

        // update student's course when articulating
        $student = Student::find(Auth::user()->username);
        $student->courseCode = $input['courseCode'];
        $student->save();

        return redirect('student/manageunits/create');
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
            // enrolment data
            'unitCode',
            'semesterLength'
        ]);

        // get user information
        $user = Auth::user();

        // get the semester and year for the enrolled from Manage Unit page
        $listingsemester = Config::find('semester')->value + 1;
        $listingyear = Config::find('year')->value;
        if (Config::find('semester')->value == 'Semester 1') {
            $listingsemester = 'Semester 2';
        } else {
            // if semester 2 in 2016
            $listingyear += 1; // +1 year
            $listingsemester = 'Semester 1';
        }

        // count pending units
        $unitCount = EnrolmentUnits::where('studentID', '=', $user->username)
        ->where('year', '=', Config::find('year')->value)
        ->where('semester', '=', Config::find('semester')->value)
        ->where('semesterLength', '=', $input['semesterLength'])
        ->where('status', '=', 'pending')
        ->count();

        if($unitCount < 4)
        {
            $unit = new EnrolmentUnits;
            $unit->studentID = Auth::user()->username;
            $unit->unitCode = $input['unitCode'];
            $unit->year = Config::find('year')->value;
            $unit->semester = Config::find('semester')->value;
            $unit->semesterLength = $input['semesterLength'];
            $unit->status = 'pending';
            $unit->result = 0.00;
            $unit->grade = 'ungraded';
            $unit->save();
        }
        else
        {
            return "Cannot enrol more than 4 units.";
        }

        return "ok";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return response()->json();
        $data = [];

        // get units for student
        $units = DB::table('enrolment_units')
            ->join('unit', 'unit.unitCode', '=', 'enrolment_units.unitCode')
            ->select('enrolment_units.*', 'unit.unitName')
            // ->where('studentID', '=', $studentID) // need to check for current semester too
            ->findOrFail($id);

        $data['units'] = $units;

        return view ('student.manageunits', $data);
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
     * adjustment_submit button onclick goes here
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only([
            'unitCode',
            'semesterLength',
            'reason',
            'status'
        ]);

        // count pending units
        $unitCount = EnrolmentUnits::where('studentID', '=', Auth::user()->username)
        ->where('year', '=', Config::find('year')->value)
        ->where('semester', '=', Config::find('semester')->value)
        ->where('semesterLength', '=', $input['semesterLength'])
        ->where('status', '=', 'pending')
        ->count();

        if($unitCount < 4)
        {
            if ($input['status'] == 'pending_drop') {
                // if existing unit is amended to remove, just update existing entry
                $unit = EnrolmentUnits::where('studentID', Auth::user()->username)
                ->where('unitCode', $input['unitCode'])
                ->update(['status' => $input['status']]);
            } else {
                // if amendment is to add, add new unit with status
                $unit = new EnrolmentUnits;
                $unit->studentID = Auth::user()->username;
                $unit->unitCode = $input['unitCode'];
                $unit->year = Config::find('year')->value;
                $unit->semester = Config::find('semester')->value;
                $unit->semesterLength = $input['semesterLength'];
                $unit->status = $input['status'];
                $unit->result = 0.00;
                $unit->grade = 'ungraded';
                $unit->save();
            }

            // create an amendment issue
            $issue = new StudentEnrolmentIssues;
            $issue->studentID = Auth::user()->username;
            $issue->issueID = 4; // amendment issue
            $issue->status = $input['status'];
            $issue->submissionData = $input['reason'];  // borrow this field as the reason
            $issue->attachmentData = $input['unitCode'];// borrow this field as the unitCode
            $issue->save();
        }
        else
        {
            return "Cannot enrol more than 4 units.";
        }

        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $input = $request->only([
            'unitCode',
            'semesterLength'
        ]);

        $user = Auth::user(); // get user information

        // delete unit
        $unit = EnrolmentUnits::where('unitCode', '=', $input['unitCode'])
        ->where('studentID', '=', Auth::user()->username)
        ->where('year', '=', Config::find('year')->value)
        ->where('semester', '=', Config::find('semester')->value)
        ->where('semesterLength', '=', $input['semesterLength'])
        ->delete();

        return 'deleted';
    }
}
