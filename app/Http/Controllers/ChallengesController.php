<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use Carbon\Carbon;
use App\User;
use App\Score;

class ChallengesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function currentChallenge()
    {
        $today = Carbon::now()->toDateString();
        return Challenge::where('start_date','<=',$today)->where('deadline','>=',$today)->get();
    }
    
    public function leaderBoard()
    {
        $challenge = Challenge::currentChallenge()->first();
        if($challenge){
            return Score::with('user')->where('challenge_id',$challenge->id)->orderBy('score_amount','desc')->paginate(30);
        }else{
            return response()->json([
                'message' => 'no challenge at the moment'
            ], 200);
        }
        
    }

    public function user_status(Request $request){
        $challenge = Challenge::currentChallenge()->first();
        if($challenge){
            $scores = Score::where('challenge_id',$challenge->id)->orderBy('score_amount','desc')->get();
            $position = $scores->search(function ( $score ) {
                return $score->user_id == auth()->user()->id;
            })+1;
            return response()->json([
                'score' =>Score::where('challenge_id',$challenge->id)->where('user_id',auth()->user()->id)->first()->score_amount,
                'rank' => $position 
            ], 200);
        }else{
            return response()->json([
                'message' =>'there is no challenge at the moment'
            ], 400);
        }
    }

}
