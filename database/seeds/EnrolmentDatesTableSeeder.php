<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EnrolmentDatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('enrolment_dates')->insert([
            'year' => 2016,
            'term' => '2',
            'reenrolmentOpenDate' => '2016-01-01',
            'reenrolmentCloseDate' => '2016-02-01',
            'adjustmentOpenDate' => '2016-03-01',
            'adjustmentCloseDate' => '2016-03-15',
            'examResultsRelease' => '2016-06-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
