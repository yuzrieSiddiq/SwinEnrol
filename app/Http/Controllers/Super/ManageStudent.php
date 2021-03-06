<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Config;
use App\Course;
use App\Student;
use App\User;

class ManageStudent extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $username = User::where('permissionLevel', '=', 1)->get(); // get all students
        $data['users'] = $username;

        return view ('super.managestudent', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        // get all courses
        $data['courses'] = Course::all();

        // get config information
        $data['year'] = Config::find('year')->value;
        $data['semester'] = Config::find('semester')->value;

        return view('super.managestudent_create', $data);
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
            'studentID',
            'givenName',
            'surname',
            'courseCode',
            'password',
            'year',
            'semester'
        ]);

        // create and store new student
        $student = new Student;
        $student->create([
            'studentID' => $input['studentID'],
            'surname' => $input['surname'],
            'givenName' => $input['givenName'],
            'courseCode' => $input['courseCode'],
            'year' => $input['year'],
            'term' => $input['semester']
        ]);

        // create and store user information
        $user = new User;
        $user->create([
            'username' => $input['studentID'],
            'password' => bcrypt($input['password']),
            'permissionLevel' => 1
        ]);

        return redirect('super/managestudent');
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
        $data = [];
        $data['courses'] = Course::all(); // get all courses

        // get student information
        $data['user'] = User::where('username', $id)->first();
        $data['student'] = Student::where('studentID', $id)->first();
        $data['year'] = Carbon::now()->year;

        return view('super.managestudent_create', $data);
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
        $input = $request->only([
            'studentID',
            'givenName',
            'surname',
            'courseCode',
            'password'
        ]);

        // find and update student information
        $student = Student::where('studentID', '=', $id)
        ->update([
            'studentID' => $input['studentID'],
            'surname' => $input['surname'],
            'givenName' => $input['givenName'],
            'courseCode' => $input['courseCode']
        ]);

        // find and update student information
        $user = User::where('permissionLevel', '=', 1)
        ->where('username', '=', $id)
        ->update([
            'username' => $input['studentID'],
            'password' => bcrypt($input['password'])
        ]);

        return redirect('super/managestudent');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete user and student information
        User::where('permissionLevel', '=', 1)
        ->where('username', '=', $id)
        ->delete();

        Student::where('studentID', '=', $id)
        ->delete();

        return redirect('super/managestudent');
    }
}
