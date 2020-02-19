<?php

use Illuminate\Database\Seeder;
use App\DailyMission;

class DailyMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$handle = fopen(asset('public/calendar.csv'), "r");
        $filename=storage_path("/app/public/calendar.csv");
        $content = File::get($filename);
        while ($csvLine = fgetcsv($content, 1000, ",")) {
        $daily_mission =new DailyMission();
        $daily_mission->date=$csvLine[1] . '-'. $csvLine[0].'-2020';
        $daily_mission->challenge_name=$csvLine[2];
        $daily_mission->save();    
        }
    }
}
