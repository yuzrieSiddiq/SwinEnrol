<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('unit')->insert([
            [
                'unitCode' => 'HIT3315',
                'unitName' => 'Languages in Software Development',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"10\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"1\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"1\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'HIT3158',
                'unitName' => 'Software Engineering Project A',
                'prerequisite' => 'HIT3315',
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"20\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"1\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"1\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'HIT3310',
                'unitName' => 'Software Architecture and Design',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"30\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"1\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"2\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'HIT1234',
                'unitName' => 'Internet Technologies',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => 'HIT1235',
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"40\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"2\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"3\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'HIT1235',
                'unitName' => 'Web Programming',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => 'HIT1234',
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"50\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"2\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"4\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'MGT10001',
                'unitName' => 'Introduction to Management',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"60\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"3\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"4\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'ACC10007',
                'unitName' => 'Management Accounting',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"70\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"3\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"4\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'ACC10008',
                'unitName' => 'Management Accounting B',
                'prerequisite' => 'ACC10007',
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '0',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"80\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"4\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"5\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'UNI20',
                'unitName' => 'A Unit With Many MinimumCompletedUnits',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '20',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"90\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"4\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"9\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'UNI2',
                'unitName' => 'A Unit With Few MinimumCompletedUnits',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '2',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"100\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"4\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"10\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'unitCode' => 'INFO',
                'unitName' => 'A Unit With Information',
                'prerequisite' => NULL,
                'corequisite' => NULL,
                'antirequisite' => NULL,
                'minimumCompletedUnits' => '2',
                'information' => "[{\"convenor\":\"Brian Sim\"},{\"maxStudents\":\"110\"},{\"lectureDuration\":\"1.5\",\"lectureGroups\":\"4\",\"lecturers\":[\"Brian Sim\"],\"lecturers_count\":1},{\"tutorialDuration\":\"1.5\",\"tutorialGroups\":\"10\",\"tutors\":[\"Fish\"],\"tutors_count\":1}]",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
