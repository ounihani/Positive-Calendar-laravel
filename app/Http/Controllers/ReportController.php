<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportController extends Controller
{
    public function report_car(Request $request){
        $report = new Report();
        $report->reported_post_id=$request->post_id;
        $report->reporter_id=$request->user()->id;
        $report->text=$request->text;
        $report->save();
        return response()->json([
            'message' => 'Successfully reported!'
        ], 201);
    }

    public function reports_list(){
            
    }

}
