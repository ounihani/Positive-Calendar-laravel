<?php

namespace App\Http\Controllers;
use App\DailyMission;
use Carbon\Carbon;
use Illuminate\Http\Request;


class DailyMissionController extends Controller
{
    public function next_challenges(){
        for($i=0;$i<7;$i++){
            $next_seven_days_missions=[];
            for( $i=0 ; $i<7 ; $i++){
                $date = Carbon::now()->addDays($i)->toDateString();
                array_push($next_seven_days_missions,$daily_mission = DailyMission::select('date','challenge_name')->where('date',$date)->get()[0]);
            }
            return $next_seven_days_missions;
        }
    }

    public function get_challenge_by_date(Request $request){
        $date = $request->date;
        return DailyMission::select('date','challenge_name')->where('date',$date)->get(); 
    }

    public function get_calendar(){
       return DailyMission::all('date','challenge_name');
    }
}
